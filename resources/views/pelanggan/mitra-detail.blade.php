@extends('layouts.pelanggan')

@section('content')

<style>

.cover{

    height:320px;

    object-fit:cover;

    border-radius:30px;

}

.profile-card{

    border:none;

    border-radius:30px;

    box-shadow:0 10px 30px rgba(0,0,0,.05);

}

.service-card{

    border:2px solid #eee;

    border-radius:20px;

    transition:.3s;

}

.service-card:hover{

    border-color:#2563eb;

    transform:translateY(-3px);

}

.btn-detail{

    background:#2563eb;

    color:white;

    border-radius:50px;

    text-decoration:none;

    padding:10px 20px;

}

.btn-detail:hover{

    color:white;

    background:#1d4ed8;

}

</style>

<div class="container py-5">

<div class="row">

<div class="col-lg-5">

@if($mitra->business_photo)

<img

src="{{ asset('uploads/business/'.$mitra->business_photo) }}"

class="w-100 cover">

@else

<img

src="https://placehold.co/700x500"

class="w-100 cover">

@endif

</div>

<div class="col-lg-7">

<div class="card profile-card">

<div class="card-body p-5">

<h2 class="fw-bold">

{{ $mitra->business_name }}

</h2>

<span class="rating-badge">
    ⭐ {{ number_format($service->mitra->reviews_avg_rating ?? 0, 1) }}
    ({{ $service->mitra->reviews_count ?? 0 }})
</span>
@if($mitra->is_online)

<span class="badge bg-success">

🟢 Sedang Buka

</span>

@else

<span class="badge bg-danger">

🔴 Sedang Tutup

</span>

@endif

<hr>

<p>

<i class="bi bi-geo-alt-fill text-danger"></i>

{{ $mitra->address }}

</p>

<p>

<i class="bi bi-clock-fill text-primary"></i>

{{ substr($mitra->open_time,0,5) }}

-

{{ substr($mitra->close_time,0,5) }}

</p>

<p>

<i class="bi bi-shield-check text-success"></i>

@if($mitra->service_warranty)

Garansi Layanan

@else

Tidak Ada Garansi

@endif

</p>

<hr>

<h5>

Tentang Mitra

</h5>

<p class="text-muted">

{{ $mitra->description }}

</p>

</div>

</div>

</div>

</div>

<hr class="my-5">

<h3 class="fw-bold mb-4">

Layanan Tersedia

</h3>

<div class="row">

@foreach($mitra->services as $service)

<div class="col-lg-4 mb-4">

<div class="card service-card h-100">

@if($service->image)

<img

src="{{ asset('uploads/'.$service->image) }}"

class="card-img-top"

style="height:220px;object-fit:cover;">

@endif

<div class="card-body">

<h5>

{{ $service->name }}

</h5>

<p class="text-muted">

{{ $service->duration }}

</p>

<h4 class="text-primary">

Rp {{ number_format($service->price) }}

</h4>

@if($mitra->is_online)

<a

href="/service/{{ $service->id }}"

class="btn-detail w-100 d-block text-center">

Detail

</a>

@else

<button

class="btn btn-secondary w-100"

disabled>

Mitra Tutup

</button>

@endif

</div>

</div>

</div>

@endforeach

</div>

</div>

@endsection