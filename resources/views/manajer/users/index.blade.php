@extends('layouts.app')

@section('title', 'Manajemen Akun Staf (Manajer)')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Form Tambah Staf Baru (4 Cols) -->
    <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-[#ece4d5] shadow-sm h-fit">
        <div class="flex items-center space-x-2.5 mb-2">
            <div class="w-7 h-7 rounded-full bg-[#18181b] text-white flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h2 class="font-cartoon text-lg font-bold text-[#18181b]">Tambah Akun Staf</h2>
        </div>
        <p class="text-xs text-[#78716c] mb-5">Daftarkan akun staf baru dan tentukan hak akses peran.</p>

        <form action="{{ route('manajer.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Peran (Role Akses) *</label>
                <select name="peran" required class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-bold text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
                    <option value="Resepsionis">Resepsionis (Meja Depan)</option>
                    <option value="Petugas Kebersihan">Petugas Kebersihan (Housekeeping)</option>
                    <option value="Manajer">Manajer Hotel (Penuh)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Nomor Identitas (NIK/Paspor) *</label>
                <input type="text" name="no_identitas" value="{{ old('no_identitas') }}" required placeholder="Contoh: 3201010101010010"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama staf hotel"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Alamat Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="staf@hotel.com"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Kata Sandi Default *</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="0812xxxxxxxx"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#18181b] uppercase mb-1">Alamat Rumah</label>
                <textarea name="alamat" rows="2" placeholder="Alamat tinggal staf"
                    class="w-full px-3.5 py-2.5 bg-[#faf6ee] border border-[#ece4d5] rounded-2xl text-xs font-medium text-[#18181b] focus:ring-2 focus:ring-[#18181b]">{{ old('alamat') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-[#18181b] hover:bg-black text-white font-extrabold py-3 px-4 rounded-full text-xs shadow transition mt-2">
                Simpan Akun Staf
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Staf (8 Cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl border border-[#ece4d5] shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-[#ece4d5] flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-7 h-7 rounded-full bg-[#18181b] text-white flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h2 class="font-cartoon text-lg font-bold text-[#18181b]">Daftar Staf & Hak Akses</h2>
                    <p class="text-xs text-[#78716c]">Kelola akun staf aktif yang memiliki otorisasi masuk ke sistem.</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left text-xs text-[#1c1917]">
                <thead class="bg-[#faf6ee] uppercase text-[10px] tracking-wider text-[#78716c] font-extrabold border-b border-[#ece4d5]">
                    <tr>
                        <th class="px-6 py-3.5">Nama & Kontak</th>
                        <th class="px-6 py-3.5">Peran (Role)</th>
                        <th class="px-6 py-3.5">No. Identitas</th>
                        <th class="px-6 py-3.5">Status Akun</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ece4d5]">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#faf6ee]/60 transition">
                            <td class="px-6 py-3.5">
                                <div class="font-extrabold text-[#18181b]">{{ $user->nama }}</div>
                                <div class="text-[10px] text-[#78716c]">{{ $user->email }} | {{ $user->no_hp ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3.5">
                                @if($user->peran === 'Manajer')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-[#e3d6f8] text-[#5b21b6]">Manajer</span>
                                @elseif($user->peran === 'Resepsionis')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-[#d4e5f9] text-[#1e40af]">Resepsionis</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-[#fde8cf] text-[#7c2d12]">Petugas Kebersihan</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 font-mono font-bold text-[#18181b]">
                                {{ $user->no_identitas }}
                            </td>
                            <td class="px-6 py-3.5">
                                @if($user->aktif)
                                    <span class="inline-flex items-center text-[11px] font-bold text-[#065f46]">
                                        <span class="w-2 h-2 rounded-full bg-[#059669] mr-1.5"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-[11px] font-bold text-[#991b1b]">
                                        <span class="w-2 h-2 rounded-full bg-[#dc2626] mr-1.5"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('manajer.users.toggle', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-[11px] font-bold px-3 py-1 rounded-full border transition {{ $user->aktif ? 'text-[#991b1b] border-[#f8b4ae] hover:bg-[#fdd8d5]' : 'text-[#065f46] border-[#a9ebd0] hover:bg-[#d6f5e8]' }}">
                                            {{ $user->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[11px] text-[#78716c] italic font-semibold">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#78716c]">
                                Belum ada data staf terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-[#ece4d5] bg-[#faf6ee]">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
