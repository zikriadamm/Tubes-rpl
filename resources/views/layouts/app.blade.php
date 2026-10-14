<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HotelOps') - Sistem Manajemen Operasional Hotel</title>
    <!-- Google Fonts: Montserrat (Body) & Fredoka (Cartoon Display) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Montserrat"', 'sans-serif'],
                        cartoon: ['"Fredoka"', 'cursive', 'sans-serif'],
                    },
                    colors: {
                        frame: '#e8b49b',
                        canvas: '#faf6ee',
                        surface: '#ffffff',
                        borderWarm: '#ece4d5',
                        charcoal: '#18181b',
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .canvas-container { border: none !important; box-shadow: none !important; border-radius: 0 !important; background: white !important; }
            .print-only { display: block !important; }
        }
    </style>
</head>
<body class="bg-[#e8b49b] text-[#1c1917] min-h-screen p-2 sm:p-5 lg:p-7 flex justify-center items-start font-sans antialiased selection:bg-[#fde8cf] selection:text-[#7c2d12]">

    <!-- Main Outer Framed Canvas Container -->
    <div class="canvas-container w-full max-w-[1550px] bg-[#faf6ee] rounded-3xl sm:rounded-4xl shadow-2xl border border-[#dec5b5]/60 overflow-hidden flex flex-col min-h-[94vh]">

        <!-- Top Header & Navigation Bar -->
        <header class="bg-transparent px-4 sm:px-8 pt-5 pb-4 border-b border-[#ece4d5]/70 no-print">
            <div class="flex flex-wrap items-center justify-between gap-4">
                
                <!-- Brand / Logo (Left) -->
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2.5 group">
                        <div class="w-10 h-10 rounded-full bg-[#18181b] flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition">
                            <!-- Geometric Hotel Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-cartoon font-bold text-xl tracking-wide text-[#18181b] block leading-tight">HotelOps</span>
                            <span class="text-[10px] uppercase font-bold text-[#78716c] tracking-widest block">Front Desk & PMS</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Tabs (Center Pill Bar) -->
                @auth
                    <nav class="flex items-center bg-[#f3ecdf]/80 p-1.5 rounded-full border border-[#e5dcce] text-xs font-semibold shadow-inner">
                        @if(auth()->user()->peran === 'Resepsionis' || auth()->user()->peran === 'Manajer')
                            <a href="{{ route('resepsionis.dashboard') }}" 
                               class="px-4 py-2 rounded-full transition {{ request()->routeIs('resepsionis.dashboard') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                Denah Kamar
                            </a>
                            <a href="{{ route('resepsionis.pemesanan.index') }}" 
                               class="px-4 py-2 rounded-full transition {{ request()->routeIs('resepsionis.pemesanan.*') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                Reservasi & Kasir
                            </a>
                            <a href="{{ route('resepsionis.tamu.index') }}" 
                               class="px-4 py-2 rounded-full transition {{ request()->routeIs('resepsionis.tamu.*') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                Buku Tamu
                            </a>
                        @endif

                        @if(auth()->user()->peran === 'Petugas Kebersihan' || auth()->user()->peran === 'Manajer')
                            <a href="{{ route('kebersihan.index') }}" 
                               class="px-4 py-2 rounded-full transition {{ request()->routeIs('kebersihan.*') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                Housekeeping
                            </a>
                        @endif

                        @if(auth()->user()->peran === 'Manajer')
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                    class="px-4 py-2 rounded-full transition flex items-center space-x-1 {{ request()->routeIs('manajer.*') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                    <span>Master Data</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak class="absolute left-0 mt-2 w-48 bg-white text-[#18181b] rounded-2xl shadow-xl py-2 z-50 border border-[#ece4d5]">
                                    <a href="{{ route('manajer.kamar.index') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-[#faf6ee]">Data Master Kamar</a>
                                    <a href="{{ route('manajer.users.index') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-[#faf6ee]">Manajemen Staf</a>
                                </div>
                            </div>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                    class="px-4 py-2 rounded-full transition flex items-center space-x-1 {{ request()->routeIs('laporan.*') ? 'bg-white text-[#18181b] shadow-sm font-bold' : 'text-[#78716c] hover:text-[#18181b]' }}">
                                    <span>Laporan Hotel</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak class="absolute left-0 mt-2 w-52 bg-white text-[#18181b] rounded-2xl shadow-xl py-2 z-50 border border-[#ece4d5]">
                                    <a href="{{ route('laporan.okupansi') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-[#faf6ee]">Laporan Okupansi Harian</a>
                                    <a href="{{ route('laporan.pendapatan') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-[#faf6ee]">Laporan Pendapatan Bulanan</a>
                                    <a href="{{ route('laporan.riwayat_tamu') }}" class="block px-4 py-2 text-xs font-semibold hover:bg-[#faf6ee]">Laporan Riwayat Tamu</a>
                                </div>
                            </div>
                        @endif
                    </nav>
                @endauth

                <!-- Right Micro Actions & User Profile -->
                <div class="flex items-center space-x-2.5">
                    @auth
                        <!-- Micro Icon Buttons -->
                        <div class="hidden sm:flex items-center space-x-1.5 mr-2">
                            <a href="{{ url('/') }}" title="Beranda" class="w-8 h-8 rounded-full bg-white border border-[#ece4d5] flex items-center justify-center text-[#78716c] hover:text-[#18181b] hover:bg-[#faf6ee] transition shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </a>
                            <div class="w-8 h-8 rounded-full bg-white border border-[#ece4d5] flex items-center justify-center text-[#78716c] shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                        </div>

                        <!-- User Profile Pill -->
                        <div class="flex items-center space-x-2 bg-white py-1 px-2.5 rounded-full border border-[#ece4d5] shadow-xs">
                            <div class="w-7 h-7 rounded-full bg-[#18181b] text-white flex items-center justify-center text-xs font-bold uppercase">
                                {{ substr(auth()->user()->nama, 0, 1) }}
                            </div>
                            <div class="text-left hidden md:block">
                                <div class="text-xs font-bold leading-none text-[#18181b]">{{ auth()->user()->nama }}</div>
                                <div class="text-[10px] text-[#78716c] font-semibold mt-0.5 leading-none">{{ auth()->user()->peran }}</div>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Keluar" class="w-8 h-8 rounded-full bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 flex items-center justify-center text-xs transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#18181b] text-white text-xs font-bold px-4 py-2 rounded-full shadow hover:bg-black transition">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Flash Notifications -->
        <div class="px-4 sm:px-8 mt-4 w-full no-print">
            @if(session('success'))
                <div class="bg-emerald-50/90 border border-emerald-200 text-emerald-900 px-4 py-3 rounded-2xl shadow-xs flex items-center justify-between text-xs font-semibold mb-3" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center space-x-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-800 text-base">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50/90 border border-rose-200 text-rose-900 px-4 py-3 rounded-2xl shadow-xs flex items-center justify-between text-xs font-semibold mb-3" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center space-x-2">
                        <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] font-bold">!</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-800 text-base">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-amber-50/90 border border-amber-200 text-amber-900 px-4 py-3 rounded-2xl shadow-xs text-xs mb-3">
                    <div class="font-bold mb-1">Periksa isian formulir:</div>
                    <ul class="list-disc list-inside space-y-0.5 text-amber-800">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Body Canvas -->
        <main class="flex-1 px-4 sm:px-8 py-5">
            @yield('content')
        </main>

        <!-- Subtle Footer -->
        <footer class="px-8 py-3.5 border-t border-[#ece4d5]/60 text-center text-[11px] font-medium text-[#78716c] no-print mt-auto bg-[#faf6ee]/50">
            HotelOps &bull; Sistem Manajemen Operasional Kamar Hotel & Meja Resepsionis &bull; Tugas Besar RPL
        </footer>
    </div>

</body>
</html>
