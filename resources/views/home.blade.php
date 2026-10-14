@extends('layout')
@section('title', 'Jelajahi kamar')
@section('content')
<div class="view-heading"><div><p class="eyebrow">Pilihan kamar</p><h1>Ruang untuk beristirahat.</h1><p>Lihat kamar, pilih tanggal, lalu pesan unit yang tersedia.</p></div><span class="heading-count">{{ $types->count() }} tipe kamar</span></div>
@if($featured)
<section class="feature-layout" aria-label="Kamar pilihan">
    <div class="feature-main">
        <div class="feature-title"><div><h2>{{ $featured->type->name }}</h2><p>Unit {{ $featured->number }} · hingga {{ $featured->type->capacity }} tamu</p></div><a href="{{ route('rooms.detail', $featured) }}">Lihat detail kamar</a></div>
        <div class="gallery" data-gallery>
            @if($featured->type->photos->isNotEmpty())
                <img class="gallery-main" data-gallery-main src="{{ asset('storage/'.$featured->type->photos->first()->path) }}" alt="Kamar {{ $featured->type->name }}">
                <div class="gallery-thumbs" aria-label="Foto kamar">@foreach($featured->type->photos as $photo)<button type="button" data-gallery-src="{{ asset('storage/'.$photo->path) }}" data-gallery-alt="Foto {{ $featured->type->name }} {{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}"><img src="{{ asset('storage/'.$photo->path) }}" alt=""><span class="sr-only">Lihat foto {{ $loop->iteration }}</span></button>@endforeach</div>
            @else<div class="gallery-empty">Foto kamar dapat ditambahkan oleh admin.</div>@endif
            <div class="gallery-chip">Unit {{ $featured->number }}</div>
        </div>
    </div>
    <aside class="feature-side"><h2>Informasi kamar</h2><p class="side-intro">{{ $featured->type->description }}</p><div class="info-line"><span>Jenis</span><strong>{{ $featured->type->name }}</strong></div><div class="info-line"><span>Kapasitas</span><strong>{{ $featured->type->capacity }} tamu</strong></div><div class="info-line"><span>Harga per malam</span><strong>Rp {{ number_format($featured->type->price_per_night, 0, ',', '.') }}</strong></div><a class="button" href="{{ route('rooms.detail', $featured) }}">Lihat kamar ini</a></aside>
</section>
@endif
<section class="below-layout" id="cari-kamar">
    <div class="overview-card"><p class="eyebrow">Reservasi Hotel Nusa</p><h2>Datang sesuai rencana Anda.</h2><p>Harga ditampilkan per malam dalam rupiah. Pilih tanggal untuk melihat unit yang masih tersedia; total akhir dihitung saat reservasi dibuat.</p><div class="overview-points"><span>Satu reservasi untuk satu unit</span><span>Tanpa biaya tambahan</span><span>Pembayaran sandbox</span></div></div>
    <form class="booking-widget" action="{{ route('rooms.search') }}" method="get"><div class="widget-title"><h2>Periksa ketersediaan</h2><span>01 / Pilih tanggal</span></div><div class="date-pair"><label>Check-in<input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ old('check_in', request('check_in')) }}" required></label><label>Check-out<input type="date" name="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out', request('check_out')) }}" required></label></div><button class="button dark" type="submit">Lihat kamar tersedia</button></form>
</section>
<section class="catalog-section" id="tipe-kamar"><div class="section-heading"><div><p class="eyebrow">Katalog</p><h2>Tipe kamar</h2></div><p>Pilih yang sesuai dengan kebutuhan menginap Anda.</p></div><div class="type-grid">@forelse($types as $type)<article class="type-card">@if($type->photos->first())<img src="{{ asset('storage/'.$type->photos->first()->path) }}" alt="Kamar {{ $type->name }}">@else<div class="photo-placeholder">{{ $type->name }}</div>@endif<div class="card-body"><div class="card-meta">Hingga {{ $type->capacity }} tamu</div><h3>{{ $type->name }}</h3><p>{{ $type->description }}</p><div class="card-bottom"><strong>Rp {{ number_format($type->price_per_night,0,',','.') }} <small>/ malam</small></strong><a href="{{ route('home') }}#cari-kamar">Periksa tanggal</a></div></div></article>@empty<p>Belum ada tipe kamar.</p>@endforelse</div></section>
@endsection
