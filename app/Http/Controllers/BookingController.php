<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\RoomUnit;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        $types = RoomType::with('photos')->get();
        $featured = RoomUnit::with('type.photos')->where('status', 'available')
            ->whereHas('type.photos')->orderByDesc('id')->first()
            ?? RoomUnit::with('type.photos')->where('status', 'available')->first();
        return view('home', compact('types', 'featured'));
    }

    private function dates(Request $request): array
    {
        $data = $request->validate(['check_in' => 'required|date|after_or_equal:today', 'check_out' => 'required|date|after:check_in']);
        $nights = Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));
        if ($nights > 30) throw ValidationException::withMessages(['check_out' => 'Maksimal 30 malam per reservasi.']);
        return [$data['check_in'], $data['check_out'], $nights];
    }

    public function search(Request $request)
    {
        [$in, $out, $nights] = $this->dates($request);
        $units = RoomUnit::with('type.photos')->where('status', 'available')
            ->whereDoesntHave('reservations', fn ($q) => $q->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                ->where('check_in', '<', $out)->where('check_out', '>', $in))->orderBy('number')->get();
        return view('search', compact('units', 'in', 'out', 'nights'));
    }

    public function detail(Request $request, RoomUnit $roomUnit)
    {
        $roomUnit->load('type.photos');
        $in = $out = $nights = null;
        $available = $roomUnit->status === 'available';
        if ($request->filled('check_in') || $request->filled('check_out')) {
            [$in, $out, $nights] = $this->dates($request);
            $available = $available && !$roomUnit->reservations()
                ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                ->where('check_in', '<', $out)->where('check_out', '>', $in)->exists();
        }
        return view('room', compact('roomUnit', 'in', 'out', 'nights', 'available'));
    }

    public function store(Request $request, MidtransService $midtrans)
    {
        [$in, $out, $nights] = $this->dates($request);
        $data = $request->validate(['room_unit_id' => 'required|exists:room_units,id']);
        $reservation = DB::transaction(function () use ($data, $in, $out, $nights, $request) {
            $unit = RoomUnit::with('type')->lockForUpdate()->findOrFail($data['room_unit_id']);
            if ($unit->status !== 'available' || $unit->reservations()->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                ->where('check_in', '<', $out)->where('check_out', '>', $in)->exists()) {
                throw ValidationException::withMessages(['room_unit_id' => 'Kamar ini baru saja dipesan. Pilih unit lain.']);
            }
            $price = $unit->type->price_per_night;
            $booking = Reservation::create(['user_id' => $request->user()->id, 'room_unit_id' => $unit->id,
                'check_in' => $in, 'check_out' => $out, 'price_per_night' => $price, 'nights' => $nights,
                'total' => $price * $nights, 'status' => 'pending']);
            Payment::create(['reservation_id' => $booking->id, 'order_id' => 'HOTEL-'.Str::uuid(), 'status' => 'pending']);
            return $booking->load('payment', 'unit.type', 'user');
        }, 3);
        try {
            $token = $midtrans->createToken($reservation);
            $reservation->payment()->update(['snap_token' => $token]);
        } catch (\Throwable $e) {
            $definitelyRejected = ($e instanceof \Illuminate\Http\Client\RequestException && $e->response->clientError())
                || str_contains($e->getMessage(), 'MIDTRANS_SERVER_KEY belum diatur');
            if ($definitelyRejected) {
                DB::transaction(function () use ($reservation) {
                    $reservation->payment()->update(['status' => 'failed']);
                    $reservation->update(['status' => 'failed']);
                });
            }
            report($e);
            return redirect()->route('bookings.show', $reservation)->with('error', $definitelyRejected
                ? 'Token pembayaran ditolak. Periksa konfigurasi Midtrans Sandbox.'
                : 'Pembuatan token belum dapat dipastikan. Periksa status pembayaran sebelum memesan ulang.');
        }
        return redirect()->route('bookings.show', $reservation);
    }

    public function mine(Request $request)
    {
        return view('bookings', ['bookings' => Reservation::with('unit.type', 'payment')->where('user_id', $request->user()->id)->latest()->get()]);
    }
    public function show(Request $request, Reservation $reservation)
    {
        abort_unless($request->user()->id === $reservation->user_id || $request->user()->role === 'admin', 403);
        return view('booking', ['booking' => $reservation->load('unit.type.photos', 'payment')]);
    }
}
