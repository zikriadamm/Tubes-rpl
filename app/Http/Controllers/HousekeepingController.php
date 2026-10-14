<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class HousekeepingController extends Controller
{
    public function index()
    {
        $kamarKotor = Kamar::where('status_kebersihan', 'Kotor')->orderBy('nomor_kamar')->get();
        $semuaKamar = Kamar::orderBy('nomor_kamar')->get();

        $stats = [
            'kotor' => $kamarKotor->count(),
            'bersih' => Kamar::where('status_kebersihan', 'Bersih')->count(),
            'total' => $semuaKamar->count(),
        ];

        return view('kebersihan.index', compact('kamarKotor', 'semuaKamar', 'stats'));
    }

    public function tandaiBersih(Kamar $kamar)
    {
        // Petugas Kebersihan memperbarui status kebersihan kamar menjadi Bersih;
        // status kamar otomatis kembali menjadi Tersedia (jika tidak sedang Terisi)
        $newStatus = ($kamar->status === 'Terisi') ? 'Terisi' : 'Tersedia';

        $kamar->update([
            'status_kebersihan' => 'Bersih',
            'status' => $newStatus,
        ]);

        return back()->with('success', "Kamar {$kamar->nomor_kamar} telah selesai dibersihkan. Status kamar kini Bersih & Tersedia.");
    }

    public function tandaiKotor(Kamar $kamar)
    {
        $kamar->update([
            'status_kebersihan' => 'Kotor',
        ]);

        return back()->with('info', "Kamar {$kamar->nomor_kamar} telah ditandai memerlukan pembersihan.");
    }
}
