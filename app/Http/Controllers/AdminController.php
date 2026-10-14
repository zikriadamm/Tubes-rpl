<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\RoomPhoto;
use App\Models\RoomType;
use App\Models\RoomUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'count' => Reservation::count(), 'paid' => Payment::where('status', 'paid')->count(),
            'revenue' => Reservation::whereHas('payment', fn ($q) => $q->where('status', 'paid'))->sum('total'),
            'recent' => Reservation::with('user', 'unit.type', 'payment')->latest()->take(8)->get(),
        ]);
    }
    public function rooms()
    {
        return view('admin.rooms', ['types' => RoomType::with('units', 'photos')->get()]);
    }
    private function typeData(Request $request): array
    {
        return $request->validate(['name' => 'required|string|max:100', 'description' => 'nullable|string|max:2000',
            'amenities' => 'nullable|string|max:2000',
            'price_per_night' => 'required|integer|min:1|max:100000000', 'capacity' => 'required|integer|min:1|max:20']);
    }
    public function storeType(Request $request)
    {
        RoomType::create($this->typeData($request));
        return back()->with('success', 'Tipe kamar ditambahkan.');
    }
    public function updateType(Request $request, RoomType $roomType)
    {
        $roomType->update($this->typeData($request));
        return back()->with('success', 'Tipe kamar diperbarui.');
    }
    public function storeUnit(Request $request)
    {
        RoomUnit::create($request->validate(['room_type_id' => 'required|exists:room_types,id',
            'number' => 'required|string|max:30|unique:room_units,number', 'status' => 'required|in:available,maintenance']));
        return back()->with('success', 'Unit kamar ditambahkan.');
    }
    public function updateUnit(Request $request, RoomUnit $roomUnit)
    {
        $data = $request->validate(['room_type_id' => 'required|exists:room_types,id',
            'number' => ['required', 'string', 'max:30', Rule::unique('room_units', 'number')->ignore($roomUnit->id)],
            'status' => 'required|in:available,maintenance']);
        $roomUnit->update($data);
        return back()->with('success', 'Unit kamar diperbarui.');
    }
    public function storePhoto(Request $request, RoomType $roomType)
    {
        $data = $request->validate(['photo' => 'required|image|max:4096']);
        $roomType->photos()->create(['path' => $data['photo']->store('rooms', 'public')]);
        return back()->with('success', 'Foto ditambahkan.');
    }
    public function deletePhoto(RoomPhoto $photo)
    {
        Storage::disk('public')->delete($photo->path); $photo->delete();
        return back()->with('success', 'Foto dihapus.');
    }
    public function reservations()
    {
        return view('admin.reservations', ['bookings' => Reservation::with('user', 'unit.type', 'payment')->latest()->paginate(20)]);
    }
    public function checkIn(Reservation $reservation)
    {
        abort_unless($reservation->status === 'confirmed', 422);
        $reservation->update(['status' => 'checked_in']);
        return back()->with('success', 'Tamu ditandai sudah check-in.');
    }
    public function checkOut(Reservation $reservation)
    {
        abort_unless($reservation->status === 'checked_in', 422);
        $reservation->update(['status' => 'checked_out']);
        return back()->with('success', 'Tamu ditandai sudah check-out.');
    }
}
