@extends('layouts.app')

@section('title', 'Panel Petugas Kebersihan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cartoon text-2xl sm:text-3xl font-bold text-[#18181b] tracking-tight">Panel Tugas Housekeeping</h1>
            <p class="text-xs sm:text-sm text-[#78716c] mt-0.5">Daftar kamar yang memerlukan pembersihan agar segera siap digunakan kembali.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-[#fde8cf] text-[#7c2d12] border border-[#f6caa2] shadow-xs">
                <span class="w-2 h-2 rounded-full bg-[#ea580c] mr-2 animate-pulse"></span>
                {{ $stats['kotor'] }} Kamar Perlu Dibersihkan
            </span>
        </div>
    </div>

    <!-- 3 Bento Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Card 1: Kotor -->
        <div class="bg-[#fde8cf] border border-[#f6caa2] p-5 rounded-3xl flex items-center justify-between shadow-xs">
            <div>
                <span class="text-xs font-bold text-[#7c2d12] uppercase tracking-wider block">Kamar Kotor</span>
                <span class="font-cartoon text-3xl font-bold text-[#7c2d12] mt-1 block">{{ $stats['kotor'] }} Unit</span>
                <span class="text-[11px] font-semibold text-[#9a3412] mt-0.5 block">Prioritas dibersihkan</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-white/70 flex items-center justify-center text-xl">
                🧹
            </div>
        </div>

        <!-- Card 2: Bersih -->
        <div class="bg-[#d4e5f9] border border-[#b6d4f6] p-5 rounded-3xl flex items-center justify-between shadow-xs">
            <div>
                <span class="text-xs font-bold text-[#1e40af] uppercase tracking-wider block">Sudah Bersih</span>
                <span class="font-cartoon text-3xl font-bold text-[#1e40af] mt-1 block">{{ $stats['bersih'] }} Unit</span>
                <span class="text-[11px] font-semibold text-[#1e40af]/80 mt-0.5 block">Siap ditempati tamu</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-white/70 flex items-center justify-center text-xl">
                ✨
            </div>
        </div>

        <!-- Card 3: Total -->
        <div class="bg-white border border-[#ece4d5] p-5 rounded-3xl flex items-center justify-between shadow-xs">
            <div>
                <span class="text-xs font-bold text-[#78716c] uppercase tracking-wider block">Total Seluruh Kamar</span>
                <span class="font-cartoon text-3xl font-bold text-[#18181b] mt-1 block">{{ $stats['total'] }} Unit</span>
                <span class="text-[11px] font-semibold text-[#78716c] mt-0.5 block">Kapasitas operasional</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#faf6ee] border border-[#ece4d5] flex items-center justify-center text-xl">
                🏨
            </div>
        </div>
    </div>

    <!-- Antrean Kamar Kotor (Priority Bento Cards) -->
    <div class="bg-white p-6 rounded-3xl border border-[#ece4d5] shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#ece4d5]">
            <div class="flex items-center space-x-2.5">
                <div class="w-7 h-7 rounded-full bg-[#18181b] text-white flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="font-cartoon text-lg font-bold text-[#18181b]">Antrean Kamar Kotor yang Harus Dibersihkan</h2>
            </div>
            <span class="text-xs font-bold text-[#78716c]">Task List Housekeeping</span>
        </div>

        @if($kamarKotor->isEmpty())
            <div class="p-8 text-center bg-[#d6f5e8]/60 border border-[#a9ebd0] rounded-3xl my-2">
                <div class="text-3xl mb-2">🎉</div>
                <h3 class="font-cartoon text-base font-bold text-[#065f46]">Semua Kamar Telah Bersih!</h3>
                <p class="text-xs text-[#065f46]/80 mt-1">Tidak ada kamar kotor yang menunggu pembersihan saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($kamarKotor as $kamar)
                    <div class="bg-[#fde8cf] border border-[#f6caa2] p-5 rounded-3xl flex flex-col justify-between shadow-xs hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-cartoon text-xl font-bold text-[#7c2d12]">Kamar {{ $kamar->nomor_kamar }}</span>
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full bg-white/80 text-[#7c2d12] shadow-2xs">
                                    Kotor
                                </span>
                            </div>
                            <div class="text-xs font-bold text-[#7c2d12]">Tipe: {{ $kamar->tipe }}</div>
                            <div class="text-[11px] text-[#9a3412] mt-1">Tarif: Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}/malam</div>
                            <div class="mt-3 p-2.5 rounded-2xl bg-white/60 text-[11px] font-semibold text-[#7c2d12] border border-[#f6caa2]/50 leading-relaxed">
                                Setelah dibersihkan, status kamar otomatis beralih kembali menjadi <strong>Tersedia</strong>.
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#f6caa2]">
                            <form action="{{ route('kebersihan.kamar.bersih', $kamar->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Kamar {{ $kamar->nomor_kamar }} selesai dibersihkan?')"
                                    class="w-full bg-[#18181b] hover:bg-black text-white font-extrabold text-xs py-2.5 px-4 rounded-full shadow transition flex items-center justify-center space-x-1.5">
                                    <span>Tandai Selesai Bersih</span>
                                    <span>✓</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Seluruh Status Kamar Hotel -->
    <div class="bg-white rounded-3xl border border-[#ece4d5] shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#ece4d5]">
            <h2 class="font-cartoon text-lg font-bold text-[#18181b]">Status Kebersihan Seluruh Kamar</h2>
            <p class="text-xs text-[#78716c]">Daftar kamar dan status operasional real-time.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#1c1917]">
                <thead class="bg-[#faf6ee] uppercase text-[10px] tracking-wider text-[#78716c] font-extrabold border-b border-[#ece4d5]">
                    <tr>
                        <th class="px-6 py-3.5">Nomor Kamar</th>
                        <th class="px-6 py-3.5">Tipe Kamar</th>
                        <th class="px-6 py-3.5">Status Kamar</th>
                        <th class="px-6 py-3.5">Status Kebersihan</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ece4d5]">
                    @foreach($semuaKamar as $kamar)
                        <tr class="hover:bg-[#faf6ee]/60 transition">
                            <td class="px-6 py-3.5 font-bold text-[#18181b]">Kamar {{ $kamar->nomor_kamar }}</td>
                            <td class="px-6 py-3.5 text-[#78716c]">{{ $kamar->tipe }}</td>
                            <td class="px-6 py-3.5 font-bold">
                                @if($kamar->status === 'Terisi')
                                    <span class="text-[#991b1b]">Terisi Tamu</span>
                                @elseif($kamar->status === 'Tersedia')
                                    <span class="text-[#065f46]">Tersedia</span>
                                @else
                                    <span class="text-[#854d0e]">Perawatan</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5">
                                @if($kamar->status_kebersihan === 'Bersih')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#d4e5f9] text-[#1e40af]">
                                        Bersih
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#fde8cf] text-[#7c2d12]">
                                        Kotor
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                @if($kamar->status_kebersihan === 'Kotor')
                                    <form action="{{ route('kebersihan.kamar.bersih', $kamar->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-[#18181b] hover:bg-black text-white text-[10px] font-extrabold px-3 py-1 rounded-full shadow-2xs">
                                            Set Bersih
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('kebersihan.kamar.kotor', $kamar->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-[10px] text-[#78716c] hover:text-[#7c2d12] font-semibold underline">
                                            Tandai Kotor
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
