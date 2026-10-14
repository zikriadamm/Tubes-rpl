<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    // ==========================================
    // KELOLA DATA MASTER KAMAR
    // ==========================================

    public function kamarIndex()
    {
        $kamars = Kamar::orderBy('nomor_kamar')->paginate(15);
        return view('manajer.kamar.index', compact('kamars'));
    }

    public function kamarStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_kamar' => 'required|string|max:20|unique:kamars,nomor_kamar',
            'tipe' => 'required|in:Standar,Deluxe,Suite',
            'harga_per_malam' => 'required|numeric|gt:0',
            'status' => 'required|in:Tersedia,Terisi,Perawatan',
            'status_kebersihan' => 'required|in:Bersih,Kotor',
        ], [
            'nomor_kamar.unique' => 'Nomor kamar tidak boleh ganda (sudah ada di database).',
            'harga_per_malam.gt' => 'Harga per malam harus lebih dari 0.',
        ]);

        Kamar::create($validated);

        return back()->with('success', "Kamar nomor {$validated['nomor_kamar']} berhasil ditambahkan.");
    }

    public function kamarUpdate(Request $request, Kamar $kamar)
    {
        $validated = $request->validate([
            'nomor_kamar' => ['required', 'string', 'max:20', Rule::unique('kamars')->ignore($kamar->id)],
            'tipe' => 'required|in:Standar,Deluxe,Suite',
            'harga_per_malam' => 'required|numeric|gt:0',
            'status' => 'required|in:Tersedia,Terisi,Perawatan',
            'status_kebersihan' => 'required|in:Bersih,Kotor',
        ], [
            'nomor_kamar.unique' => 'Nomor kamar tidak boleh ganda.',
            'harga_per_malam.gt' => 'Harga per malam harus lebih dari 0.',
        ]);

        $kamar->update($validated);

        return back()->with('success', "Data kamar {$kamar->nomor_kamar} berhasil diperbarui.");
    }

    public function kamarDestroy(Kamar $kamar)
    {
        // Hanya Manajer yang boleh menghapus (diatur via RoleMiddleware)
        // Validasi tambahan: Kamar tidak boleh dihapus jika sedang terisi
        if ($kamar->status === 'Terisi') {
            return back()->with('error', "Kamar {$kamar->nomor_kamar} tidak dapat dihapus karena saat ini sedang Terisi oleh tamu.");
        }

        $nomor = $kamar->nomor_kamar;
        $kamar->delete();

        return back()->with('success', "Kamar nomor {$nomor} berhasil dihapus.");
    }

    // ==========================================
    // KELOLA AKUN PENGGUNA (STAF)
    // ==========================================

    public function userIndex()
    {
        $users = User::whereIn('peran', ['Resepsionis', 'Manajer', 'Petugas Kebersihan'])->orderBy('nama')->paginate(15);
        return view('manajer.users.index', compact('users'));
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'peran' => 'required|in:Resepsionis,Manajer,Petugas Kebersihan',
            'no_identitas' => 'required|string|max:50|unique:users,no_identitas',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ], [
            'no_identitas.unique' => 'Nomor identitas staf tidak boleh ganda.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $validated['aktif'] = true;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return back()->with('success', "Akun staf {$validated['nama']} ({$validated['peran']}) berhasil dibuat.");
    }

    public function userToggleAktif(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update([
            'aktif' => !$user->aktif,
        ]);

        $statusStr = $user->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->nama} berhasil {$statusStr}.");
    }
}
