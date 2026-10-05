@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<h3 class="fw-bold mb-4">

Kelola Komplain

</h3>

<div class="card shadow">

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>No</th>

<th>No Komplain</th>

<th>Order</th>

<th>Pelanggan</th>

<th>Mitra</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($complaints as $complaint)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $complaint->complaint_number }}

</td>

<td>

{{ $complaint->order?->invoice_number ?? '-' }}

</td>

<td>

{{ $complaint->user->name }}

</td>

<td>

{{ $complaint->mitra->business_name }}

</td>

<td>

@if($complaint->status == 'pending')

    <span class="badge bg-warning">
        Menunggu Keputusan
    </span>

@elseif($complaint->status == 'approved')

    <span class="badge bg-primary">
        Refund Disetujui
    </span>

@elseif($complaint->status == 'rejected')

    <span class="badge bg-danger">
        Komplain Ditolak
    </span>

@elseif($complaint->status == 'resolved')

    <span class="badge bg-success">
        Refund Selesai
    </span>

@else

    <span class="badge bg-secondary">
        {{ ucfirst($complaint->status) }}
    </span>

@endif

</td>

<td>

<a
href="/admin/complaints/{{ $complaint->id }}"
class="btn btn-primary btn-sm">

Detail

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection