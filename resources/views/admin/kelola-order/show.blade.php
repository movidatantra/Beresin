@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold">

            Detail Order

        </h3>

        <small class="text-muted">

            Informasi lengkap transaksi

        </small>

    </div>

    <a
        href="{{ route('admin.orders') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>

</div>

<div class="card shadow border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Informasi Order

</h5>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="30%">

Invoice

</th>

<td>

{{ $order->invoice_number }}

</td>

</tr>

<tr>

<th>

Tanggal

</th>

<td>

{{ \Carbon\Carbon::parse($order->jadwal)->format('d F Y') }}

</td>

</tr>

<tr>

<th>

Jam

</th>

<td>

{{ $order->jam }}

</td>

</tr>

<tr>

<th>

Status

</th>

<td>

<span class="badge bg-primary">

{{ ucfirst(str_replace('_',' ',$order->status)) }}

</span>

</td>

</tr>

<tr>

<th>

Total

</th>

<td>

Rp {{ number_format($order->total_price,0,',','.') }}

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow border-0 rounded-4 mb-4">

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

{{ $order->user->name }}

</td>

</tr>

<tr>

<th>

Email

</th>

<td>

{{ $order->user->email }}

</td>

</tr>

<tr>

<th>

No HP

</th>

<td>

{{ $order->user->phone }}

</td>

</tr>

<tr>

<th>

Alamat

</th>

<td>

{{ $order->address }}

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow border-0 rounded-4 mb-4">

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

{{ $order->mitra->name }}

</td>

</tr>

<tr>

<th>

Usaha

</th>

<td>

{{ $order->mitra->business_name }}

</td>

</tr>

<tr>

<th>

No HP

</th>

<td>

{{ $order->mitra->phone }}

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow border-0 rounded-4 mb-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

Pembayaran

</h5>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="30%">

Metode

</th>

<td>

{{ $order->payment_method }}

</td>

</tr>

<tr>

<th>

Status

</th>

<td>

{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}

</td>

</tr>

<tr>

<th>

Total

</th>

<td>

Rp {{ number_format($order->total_price,0,',','.') }}

</td>

</tr>

</table>

</div>

</div>

<div class="d-flex gap-2">

<a
href="https://wa.me/62{{ ltrim($order->user->phone,'0') }}"
target="_blank"
class="btn btn-success">

<i class="bi bi-whatsapp"></i>

Hubungi Pelanggan

</a>

<a
href="https://wa.me/62{{ ltrim($order->mitra->phone,'0') }}"
target="_blank"
class="btn btn-primary">

<i class="bi bi-whatsapp"></i>

Hubungi Mitra

</a>

</div>

@endsection