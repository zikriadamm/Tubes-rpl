@extends('layouts.app')

@section('title', 'Masuk ke Sistem')

@section('content')
<div class="max-w-md mx-auto my-6">
    <div class="bg-white p-8 sm:p-10 rounded-4xl shadow-md border border-[#ece4d5]">
        
        <!-- Header -->
        <div class="text-center mb-7">
            <div class="w-14 h-14 rounded-full bg-[#18181b] text-white flex items-center justify-center mx-auto mb-3 shadow">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h1 class="font-cartoon text-2xl sm:text-3xl font-bold text-[#18181b] tracking-tight">Selamat Datang di HotelOps</h1>
            <p class="text-xs text-[#78716c] mt-1 font-medium">Sistem Informasi Manajemen Meja Depan Hotel</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-[#18181b] uppercase mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]"
                    placeholder="nama@hotel.com">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-[#18181b] uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-[#ece4d5] text-[#18181b] focus:ring-[#18181b]">
                    <span class="ml-2 text-[#78716c] font-medium">Ingat sesi saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#18181b] hover:bg-black text-white font-extrabold py-3 px-4 rounded-full text-xs shadow transition mt-2">
                Masuk ke Aplikasi
            </button>
        </form>

        <!-- Quick Demo Login Buttons in Pastel Style -->
        <div class="mt-8 pt-6 border-t border-[#ece4d5]">
            <p class="text-[11px] font-extrabold text-[#78716c] uppercase tracking-wider text-center mb-3">
                Akses Cepat Pengujian / Demo Dosen:
            </p>
            <div class="space-y-2">
                <a href="{{ route('demo.login', 'Manajer') }}" class="flex items-center justify-between p-3 border border-[#cdbaf4] bg-[#e3d6f8] hover:bg-[#d8c5f6] rounded-2xl text-xs font-bold text-[#5b21b6] transition shadow-2xs">
                    <span class="flex items-center space-x-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#7c3aed]"></span>
                        <span>Login sebagai <strong>Manajer Hotel</strong></span>
                    </span>
                    <span>&rarr;</span>
                </a>
                <a href="{{ route('demo.login', 'Resepsionis') }}" class="flex items-center justify-between p-3 border border-[#b6d4f6] bg-[#d4e5f9] hover:bg-[#bfdaf7] rounded-2xl text-xs font-bold text-[#1e40af] transition shadow-2xs">
                    <span class="flex items-center space-x-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#2563eb]"></span>
                        <span>Login sebagai <strong>Resepsionis</strong></span>
                    </span>
                    <span>&rarr;</span>
                </a>
                <a href="{{ route('demo.login', 'Petugas Kebersihan') }}" class="flex items-center justify-between p-3 border border-[#f6caa2] bg-[#fde8cf] hover:bg-[#fbd8b4] rounded-2xl text-xs font-bold text-[#7c2d12] transition shadow-2xs">
                    <span class="flex items-center space-x-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ea580c]"></span>
                        <span>Login sebagai <strong>Petugas Kebersihan</strong></span>
                    </span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
