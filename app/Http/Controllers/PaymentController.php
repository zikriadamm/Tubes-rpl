<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request, MidtransService $midtrans)
    {
        $data = $request->all();
        $midtrans->verifyNotification($data);
        $midtrans->applyStatus($data);
        return response()->json(['ok' => true]);
    }
    public function sync(Request $request, Reservation $reservation, MidtransService $midtrans)
    {
        abort_unless($request->user()->id === $reservation->user_id || $request->user()->role === 'admin', 403);
        try {
            $midtrans->applyStatus($midtrans->status($reservation->payment->order_id));
            return back()->with('success', 'Status pembayaran diperbarui dari Midtrans.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Status belum dapat diperiksa. Coba lagi nanti.');
        }
    }
}
