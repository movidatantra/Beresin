@extends('layouts.pelanggan')

@section('content')

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-9">

<div class="card border-0 shadow rounded-4">

<div class="card-body p-5">

<a href="/my-orders"
class="text-decoration-none">

← Kembali

</a>

<h3 class="fw-bold mt-3">

Detail Komplain

</h3>

<hr>

<div class="row">

<div class="col-md-6 mb-3">

<label class="text-muted">

Nomor Komplain

</label>

<h5>

{{ $complaint->complaint_number }}

</h5>

</div>

<div class="col-md-6 mb-3">

<label class="text-muted">

Status

</label>

<br>

@if($complaint->status=='pending')

<span class="badge bg-warning">

Sedang Ditinjau

</span>

@elseif($complaint->status=='process')

<span class="badge bg-info">

Diproses Admin

</span>

@elseif($complaint->status=='resolved')

<span class="badge bg-success">

Selesai

</span>

@else

<span class="badge bg-danger">

Ditolak

</span>

@endif

</div>

</div>

<hr>

<h5>

Informasi Komplain

</h5>

<table class="table">

<tr>

<th width="220">

Order

</th>

<td>

{{ $complaint->order->invoice_number }}

</td>

</tr>

<tr>

<th>

Kategori

</th>

<td>

{{ $complaint->category }}

</td>

</tr>

<tr>

<th>

Judul

</th>

<td>

{{ $complaint->subject }}

</td>

</tr>

<tr>

<th>

Deskripsi

</th>

<td>

{{ $complaint->complaint }}

</td>

</tr>
<tr>

<th>

Metode Refund

</th>

<td>

@if($complaint->refund_type == 'bank')

    Transfer Bank

@elseif($complaint->refund_type == 'ewallet')

    E-Wallet

@else

    -

@endif

</td>

</tr>

<tr>

<th>

Tujuan Refund

</th>

<td>

@if($complaint->refund_type == 'bank')

    {{ $complaint->bank?->nama_bank ?? '-' }}

@elseif($complaint->refund_type == 'ewallet')

    {{ $complaint->ewallet?->nama_wallet ?? '-' }}

@else

    -

@endif

</td>

</tr>

<tr>

<th>

Nomor Rekening / Nomor HP

</th>

<td>

{{ $complaint->account_number ?? '-' }}

</td>

</tr>

<tr>

<th>

Nama Pemilik

</th>

<td>

{{ $complaint->account_holder ?? '-' }}

</td>

</tr>

</table>

<hr>

<h5>

Foto Bukti

</h5>

@if($complaint->photo)

<img
src="{{ asset('uploads/complaints/photos/'.$complaint->photo) }}"
class="img-fluid rounded shadow">

@else

<div class="alert alert-light">

Tidak ada foto.

</div>

@endif

<hr>

<h5>

Video Bukti

</h5>

@if($complaint->video)

<video
width="100%"
controls>

<source
src="{{ asset('uploads/complaints/videos/'.$complaint->video) }}">

</video>

@else

<div class="alert alert-light">

Tidak ada video.

</div>

@endif

<hr>

<h5>

Tanggapan Mitra

</h5>

@if($complaint->mitra_response)

<div class="alert alert-primary">

{{ $complaint->mitra_response }}

</div>

@else

<div class="alert alert-warning">

Belum ada tanggapan dari mitra.

</div>

@endif

<hr>

<h5>

Keputusan Admin

</h5>

@if($complaint->admin_response)

<div class="alert alert-success">

{{ $complaint->admin_response }}

</div>

@else

<div class="alert alert-secondary">

Admin masih melakukan peninjauan.

</div>

@endif

</div>

</div>

</div>

</div>

</div>

@endsection