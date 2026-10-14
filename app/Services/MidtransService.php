<?php
namespace App\Services;

use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class MidtransService
{
    private function key(): string
    {
        $key = config('midtrans.server_key');
        if (!$key) throw new \RuntimeException('MIDTRANS_SERVER_KEY belum diatur.');
        return $key;
    }
    public function createToken(Reservation $booking): string
    {
        $response = Http::withBasicAuth($this->key(), '')->acceptJson()->timeout(15)->post(config('midtrans.snap_url'), [
            'transaction_details' => ['order_id' => $booking->payment->order_id, 'gross_amount' => $booking->total],
            'customer_details' => ['first_name' => $booking->user->name, 'email' => $booking->user->email],
            'item_details' => [['id' => 'room-'.$booking->room_unit_id, 'price' => $booking->total,
                'quantity' => 1, 'name' => 'Kamar '.$booking->unit->number.' ('.$booking->nights.' malam)']],
            'expiry' => ['unit' => 'minutes', 'duration' => 30],
        ]);
        $response->throw();
        return $response->json('token') ?: throw new \RuntimeException('Midtrans tidak mengembalikan token Snap.');
    }
    public function status(string $orderId): array
    {
        $response = Http::withBasicAuth($this->key(), '')->acceptJson()->timeout(15)
            ->get(config('midtrans.status_url').'/'.rawurlencode($orderId).'/status');
        $response->throw();
        return $response->json();
    }
    public function verifyNotification(array $data): void
    {
        foreach (['order_id', 'status_code', 'gross_amount', 'signature_key'] as $field) {
            if (!isset($data[$field]) || !is_string($data[$field])) abort(400, 'Notifikasi tidak lengkap.');
        }
        $expected = hash('sha512', $data['order_id'].$data['status_code'].$data['gross_amount'].$this->key());
        abort_unless(hash_equals($expected, $data['signature_key']), 403, 'Tanda tangan tidak valid.');
    }
    public function applyStatus(array $data): void
    {
        DB::transaction(function () use ($data) {
            $payment = Payment::where('order_id', $data['order_id'] ?? '')->lockForUpdate()->firstOrFail();
            $booking = Reservation::whereKey($payment->reservation_id)->lockForUpdate()->firstOrFail();
            $amount = (string) ($data['gross_amount'] ?? '');
            if (!preg_match('/^\d+(?:\.00)?$/', $amount) || (int) $amount !== (int) $booking->total) {
                throw ValidationException::withMessages(['gross_amount' => 'Jumlah pembayaran tidak cocok.']);
            }
            if (in_array($payment->status, ['paid', 'failed', 'expired', 'cancelled'], true)) return;
            $remote = $data['transaction_status'] ?? '';
            $fraud = strtolower($data['fraud_status'] ?? 'accept');
            $success = in_array($remote, ['settlement', 'capture'], true) && (string) ($data['status_code'] ?? '') === '200' && $fraud === 'accept';
            $failed = ['deny' => 'failed', 'failure' => 'failed', 'cancel' => 'cancelled', 'expire' => 'expired'];
            if (!$success && !isset($failed[$remote])) return;
            $payment->status = $success ? 'paid' : $failed[$remote];
            $payment->transaction_id = $data['transaction_id'] ?? $payment->transaction_id;
            $payment->payment_type = $data['payment_type'] ?? $payment->payment_type;
            if ($success) $payment->paid_at = now();
            $payment->save();
            if ($booking->status === 'pending') {
                $booking->status = $success ? 'confirmed' : $payment->status;
                $booking->save();
            }
        }, 3);
    }
}
