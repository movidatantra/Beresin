@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3 class="fw-bold">

Detail Ulasan

</h3>

<small class="text-muted">

Informasi lengkap review pelanggan

</small>

</div>

<a
href="{{ route('admin.reviews') }}"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

</div>
<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Informasi Ulasan

</h5>

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<th width="30%">

Order

</th>

<td>

{{ $review->order->invoice_number }}

</td>

</tr>

<tr>

<th>

Tanggal Review

</th>

<td>

{{ $review->created_at->format('d F Y H:i') }}

</td>

</tr>

<tr>

<th>

Rating

</th>

<td>

@for($i=1;$i<=5;$i++)

@if($i<=$review->rating)

<span class="text-warning fs-4">

★

</span>

@else

<span class="text-secondary fs-4">

☆

</span>

@endif

@endfor

</td>

</tr>

<tr>

<th>

Komentar

</th>

<td>

{{ $review->review }}

</td>

</tr>

</table>

</div>

</div>
<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Pelanggan

</h5>

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<th width="30%">

Nama

</th>

<td>

{{ $review->user->name }}

</td>

</tr>

<tr>

<th>

Email

</th>

<td>

{{ $review->user->email }}

</td>

</tr>

<tr>

<th>

No HP

</th>

<td>

{{ $review->user->phone }}

</td>

</tr>

</table>

</div>

</div>
<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Mitra

</h5>

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<th width="30%">

Nama

</th>

<td>

{{ $review->mitra->name }}

</td>

</tr>

<tr>

<th>

Usaha

</th>

<td>

{{ $review->mitra->business_name }}

</td>

</tr>

<tr>

<th>

No HP

</th>

<td>

{{ $review->mitra->phone }}

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Transaksi

</h5>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="30%">

Invoice

</th>

<td>

{{ $review->order->invoice_number }}

</td>

</tr>

<tr>

<th>

Tanggal Booking

</th>

<td>

{{ \Carbon\Carbon::parse($review->order->jadwal)->format('d F Y') }}

</td>

</tr>

<tr>

<th>

Jam

</th>

<td>

{{ $review->order->jam }}

</td>

</tr>

<tr>

<th>

Total

</th>

<td>

Rp {{ number_format($review->order->total_price,0,',','.') }}

</td>

</tr>

<tr>

<th>

Metode Pembayaran

</th>

<td>

{{ $review->order->payment_method }}

</td>

</tr>

<tr>

<th>

Status Order

</th>

<td>

<span class="badge bg-success">

{{ ucfirst(str_replace('_',' ',$review->order->status)) }}

</span>

</td>

</tr>

</table>

</div>

</div>


<div class="d-flex gap-2">

<a
href="https://wa.me/62{{ ltrim($review->user->phone,'0') }}"
target="_blank"
class="btn btn-success">

<i class="bi bi-whatsapp"></i>

Hubungi Pelanggan

</a>

<a
href="https://wa.me/62{{ ltrim($review->mitra->phone,'0') }}"
target="_blank"
class="btn btn-primary">

<i class="bi bi-whatsapp"></i>

Hubungi Mitra

</a>

</div>

@endsection