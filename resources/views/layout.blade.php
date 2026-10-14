<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hotel Nusa') · Hotel Nusa</title>
    <link rel="stylesheet" href="{{ asset('css/hotel-v2.css') }}">
</head>
<body>
<div class="app-shell">
    <aside class="side-rail" aria-label="Navigasi utama">
        <a class="rail-brand" href="{{ route('home') }}" aria-label="Hotel Nusa, beranda">N<span>.</span></a>
        <nav class="rail-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" title="Beranda" aria-label="Beranda"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 10 9-7 9 7v10H3zM9 20v-7h6v7"/></svg><small>Beranda</small></a>
            <a href="{{ route('home') }}#tipe-kamar" title="Tipe kamar" aria-label="Tipe kamar"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 20V7h18v13M3 16h18M6 12h4m4 0h4M3 20v2m18-2v2"/></svg><small>Kamar</small></a>
            @auth
            <a href="{{ route('bookings.mine') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}" title="Pesanan saya" aria-label="Pesanan saya"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M8 2v4m8-4v4M4 10h16m-12 5h8"/></svg><small>Pesanan</small></a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}" title="Panel admin" aria-label="Panel admin"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg><small>Admin</small></a>
            @endif
            @endauth
        </nav>
        <span class="rail-footer" title="Mode pembayaran sandbox">S</span>
    </aside>
    <div class="app-area">
        <header class="topbar">
            <a class="mobile-brand" href="{{ route('home') }}">Hotel Nusa</a>
            <a class="top-search" href="{{ route('home') }}#cari-kamar"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><span>Cari kamar dan tanggal menginap</span></a>
            <div class="top-actions">
                @auth
                <span class="top-name">{{ auth()->user()->name }}</span>
                <a class="avatar" href="{{ auth()->user()->role === 'admin' ? route('admin.index') : route('bookings.mine') }}" aria-label="Buka akun">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</a>
                <form method="post" action="{{ route('logout') }}">@csrf<button class="top-logout" type="submit">Keluar</button></form>
                @else
                <a class="top-login" href="{{ route('login') }}">Masuk</a>
                <a class="top-register" href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </header>
        <main class="content">
            @if(session('success'))<div class="notice success" role="status">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="notice error" role="alert">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="notice error" role="alert"><strong>Periksa masukan Anda.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
        <footer class="app-footer">Hotel Nusa <span>Pembayaran melalui Midtrans Sandbox</span></footer>
    </div>
</div>
<script>
document.querySelectorAll('[data-gallery]').forEach(function(gallery){
    var main=gallery.querySelector('[data-gallery-main]');
    gallery.querySelectorAll('[data-gallery-src]').forEach(function(button){
        button.addEventListener('click',function(){
            main.src=button.dataset.gallerySrc;
            main.alt=button.dataset.galleryAlt;
            gallery.querySelectorAll('[data-gallery-src]').forEach(function(item){item.setAttribute('aria-pressed','false')});
            button.setAttribute('aria-pressed','true');
        });
    });
});
</script>
@stack('scripts')
</body>
</html>
