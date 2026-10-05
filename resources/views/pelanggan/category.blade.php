@extends('layouts.pelanggan')

@section('content')

<style>

.hero{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

    color:white;

    border-radius:30px;

    padding:50px;

    margin-bottom:40px;

}

.mitra-card{

    background:white;

    border:none;

    border-radius:25px;

    overflow:hidden;

    box-shadow:0 10px 30px rgba(0,0,0,.06);

    transition:.3s;

}

.mitra-card:hover{

    transform:translateY(-5px);

}

.mitra-image{

    height:240px;

    object-fit:cover;

}

.badge-status{

    padding:8px 18px;

    border-radius:30px;

    font-size:13px;

}

.rating{

    background:#FEF3C7;

    color:#F59E0B;

    border-radius:30px;

    padding:6px 14px;

    font-size:13px;

    font-weight:700;

}

.btn-mitra{

    background:#2563eb;

    color:white;

    border-radius:50px;

    font-weight:600;

    padding:12px;

    text-decoration:none;

    display:block;

    text-align:center;

    transition:.3s;

}

.btn-mitra:hover{

    background:#1d4ed8;

    color:white;

}

.offline{

    background:#f8f9fa;

}

.offline .mitra-image{

    filter:grayscale(100%);

}

.offline .card-content{

    opacity:.8;

}
.offline-overlay{

    filter:none !important;

    opacity:1 !important;

}
.offline-overlay{

    position:absolute;

    top:15px;

    right:15px;

    background:#dc3545;

    color:white;

    padding:8px 16px;

    border-radius:30px;

    font-weight:bold;

}

.image-wrapper{

    position:relative;

}

</style>

<div class="container py-4">

<div class="hero">

<a href="/pelanggan"

class="btn btn-light rounded-pill mb-3">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

<h2 class="fw-bold">

{{ $category }}

</h2>

<p>

Pilih mitra terbaik untuk layanan

{{ $category }}

</p>

</div>

<div class="row g-4">

@forelse($mitras as $mitra)

<div class="col-lg-4">

<div class="mitra-card {{ !$mitra->is_online ? 'offline' : '' }}">

<div class="image-wrapper">

@if($mitra->business_photo)

<img

src="{{ asset('uploads/business/'.$mitra->business_photo) }}"

class="w-100 mitra-image">

@else

<img

src="https://placehold.co/600x350"

class="w-100 mitra-image">

@endif

@if(!$mitra->is_online)

<div class="offline-overlay">

🔴 TUTUP

</div>

@endif

</div>

<div class="p-4 card-content">

<div class="d-flex justify-content-between align-items-center">

<h4 class="fw-bold mb-0">

{{ $mitra->business_name }}

</h4>

<span class="review">
⭐ {{ number_format($mitra->review_avg_rating ?? 0, 1) }}
({{ $mitra->review_count }})
</span>

</div>

<p class="text-muted mt-3 mb-1">
    <i class="bi bi-geo-alt-fill text-danger"></i>
    {{ $mitra->address }}
</p>

<p class="text-primary fw-semibold mb-2">
    <i class="bi bi-signpost-2-fill"></i>
    {{ number_format($mitra->distance, 2) }} km dari lokasi Anda
</p>

<p class="text-muted mb-2">

<i class="bi bi-clock-fill text-primary"></i>

{{ substr($mitra->open_time,0,5) }}

-

{{ substr($mitra->close_time,0,5) }}

</p>

<p class="text-muted mb-4">

{{ $mitra->description }}

</p>

@if($mitra->is_online)

<span class="badge bg-success badge-status mb-4">

🟢 Sedang Buka

</span>

@else

<span class="badge bg-danger badge-status mb-4">

🔴 Sedang Tutup

</span>

@endif

@if($mitra->is_online)

<a

href="/mitra/{{ $mitra->id }}"

class="btn-mitra">

<i class="bi bi-shop"></i>

Lihat Mitra

</a>

@else

<button

class="btn btn-secondary w-100 rounded-pill"

disabled>

<i class="bi bi-shop"></i>

Mitra Sedang Tutup

</button>

@endif

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning rounded-4">

Belum ada mitra pada kategori ini.

</div>

</div>

@endforelse

</div>

</div>

@endsection