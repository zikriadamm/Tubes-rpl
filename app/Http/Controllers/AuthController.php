<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->aktif) {
                Auth::logout();
                return back()->with('error', 'Akun Anda dinonaktifkan. Hubungi Manajer.');
            }

            return $this->redirectBasedOnRole($user)->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function demoLogin(string $peran)
    {
        $user = User::where('peran', $peran)->where('aktif', true)->first();

        if (!$user) {
            return back()->with('error', 'Akun demo untuk peran ' . $peran . ' tidak ditemukan.');
        }

        Auth::login($user);
        request()->session()->regenerate();

        return $this->redirectBasedOnRole($user)->with('success', 'Berhasil masuk sebagai demo: ' . $user->nama);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    protected function redirectBasedOnRole(User $user)
    {
        return match ($user->peran) {
            'Manajer' => redirect()->route('manajer.kamar.index'),
            'Resepsionis' => redirect()->route('resepsionis.dashboard'),
            'Petugas Kebersihan' => redirect()->route('kebersihan.index'),
            default => redirect()->route('login'),
        };
    }
}
