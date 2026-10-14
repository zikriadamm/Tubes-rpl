@extends('layouts.app')

@section('title', 'Laporan Okupansi Kamar Harian')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <div>
            <h1 class="font-cartoon text-2xl sm:text-3xl font-bold text-[#18181b] tracking-tight">Laporan Okupansi Kamar (Harian)</h1>
            <p class="text-xs sm:text-sm text-[#78716c] mt-0.5">Rekapitulasi tingkat keterisian kamar harian dan persentase okupansi hotel.</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="bg-[#18181b] hover:bg-black text-white text-xs font-bold py-2.5 px-5 rounded-full shadow flex items-center space-x-1.5 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </div>

    <!-- Filter Tanggal (Hidden on Print) -->
    <div class="bg-white p-4 rounded-3xl border border-[#ece4d5] shadow-sm no-print">
        <form action="{{ route('laporan.okupansi') }}" method="GET" class="flex items-center gap-3">
            <label class="text-xs font-bold text-[#18181b] uppercase">Pilih Tanggal Laporan:</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="px-4 py-2 bg-[#faf6ee] border border-[#ece4d5] rounded-full text-xs font-bold text-[#18181b] focus:ring-2 focus:ring-[#18181b]">
            <button type="submit" class="bg-[#18181b] hover:bg-black text-white text-xs font-bold px-5 py-2 rounded-full shadow-xs transition">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- 3 Bento KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 no-print">
        <div class="bg-white border border-[#ece4d5] p-5 rounded-3xl">
            <span class="text-xs font-bold text-[#78716c] uppercase block">Total Unit Kamar</span>
            <span class="font-cartoon text-3xl font-bold text-[#18181b] mt-1 block">{{ $totalKamar }} Kamar</span>
        </div>
        <div class="bg-[#fdd8d5] border border-[#f8b4ae] p-5 rounded-3xl">
            <span class="text-xs font-bold text-[#991b1b] uppercase block">Kamar Terisi (Occupied)</span>
            <span class="font-cartoon text-3xl font-bold text-[#991b1b] mt-1 block">{{ $kamarTerisiCount }} Kamar</span>
        </div>
        <div class="bg-[#d6f5e8] border border-[#a9ebd0] p-5 rounded-3xl">
            <span class="text-xs font-bold text-[#065f46] uppercase block">Persentase Okupansi Harian</span>
            <span class="font-cartoon text-3xl font-bold text-[#065f46] mt-1 block">{{ $persentaseOkupansi }}%</span>
        </div>
    </div>

    <!-- Printable Report Container -->
    <div class="bg-white p-8 sm:p-10 rounded-4xl border border-[#ece4d5] shadow-sm text-[#1c1917]">
        <!-- Letterhead Header -->
        <div class="border-b-2 border-[#18181b] pb-4 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="font-cartoon text-2xl font-bold text-[#18181b] tracking-tight">HOTEL NUSANTARA</h2>
                    <p class="text-xs text-[#78716c] font-bold">LAPORAN TINGKAT OKUPANSI KAMAR HARIAN</p>
                </div>
                <div class="text-right text-xs">
                    <div class="text-[#78716c] font-semibold">Tanggal Analisis:</div>
                    <div class="text-sm font-black text-[#18181b]">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="border border-[#ece4d5] rounded-2xl overflow-hidden mb-6">
            <table class="w-full text-left text-xs text-[#1c1917]">
                <thead class="bg-[#faf6ee] uppercase text-[10px] font-bold text-[#78716c] border-b border-[#ece4d5]">
                    <tr>
                        <th class="px-4 py-3.5">Nomor Kamar</th>
                        <th class="px-4 py-3.5">Tipe Kamar</th>
                        <th class="px-4 py-3.5">Tarif / Malam</th>
                        <th class="px-4 py-3.5">Status Keterisian</th>
                        <th class="px-4 py-3.5">Nama Tamu Menginap</th>
                        <th class="px-4 py-3.5">Kebersihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ece4d5]">
                    @foreach($kamarData as $item)
                        <tr class="hover:bg-[#faf6ee]/60 transition">
                            <td class="px-4 py-3 font-bold font-mono text-[#18181b]">No. {{ $item['nomor_kamar'] }}</td>
                            <td class="px-4 py-3 text-[#78716c] font-medium">{{ $item['tipe'] }}</td>
                            <td class="px-4 py-3 font-semibold">Rp {{ number_format($item['harga_per_malam'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 font-extrabold">
                                @if($item['status_keterisian'] === 'Terisi')
                                    <span class="text-[#991b1b] bg-[#fdd8d5] px-2.5 py-0.5 rounded-full text-[10px]">Terisi</span>
                                @elseif($item['status_keterisian'] === 'Dipesan')
                                    <span class="text-[#1e40af] bg-[#d4e5f9] px-2.5 py-0.5 rounded-full text-[10px]">Dipesan</span>
                                @else
                                    <span class="text-[#065f46] bg-[#d6f5e8] px-2.5 py-0.5 rounded-full text-[10px]">Kosong</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-bold text-[#18181b]">{{ $item['nama_tamu'] }}</td>
                            <td class="px-4 py-3 text-[10px] font-bold">
                                <span class="{{ $item['status_kebersihan'] === 'Bersih' ? 'text-[#065f46]' : 'text-[#7c2d12]' }}">
                                    {{ $item['status_kebersihan'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="grid grid-cols-2 gap-8 pt-8 text-center text-xs">
            <div></div>
            <div>
                <p class="text-[#78716c] mb-14 font-medium">Mengetahui, Manajer Hotel</p>
                <p class="font-bold border-t border-[#18181b] pt-1 inline-block px-8 text-[#18181b]">
                    {{ auth()->user()->nama }}
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
