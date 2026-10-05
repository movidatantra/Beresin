@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold">

            Pembayaran

        </h3>

        <small class="text-muted">

            Monitoring seluruh transaksi pembayaran pelanggan

        </small>

    </div>

</div>

<div class="card shadow border-0 rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-3">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari Invoice / Pelanggan / Mitra"
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <select
                        name="method"
                        class="form-select">

                        <option value="">

                            Semua Metode

                        </option>

                        <option
                            value="COD"
                            {{ request('method')=='COD'?'selected':'' }}>

                            COD

                        </option>

                        <option
                            value="Virtual Account"
                            {{ request('method')=='Virtual Account'?'selected':'' }}>

                            Virtual Account

                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">

                            Semua Status

                        </option>

                        <option
                            value="belum_bayar">

                            Belum Bayar

                        </option>

                        <option
                            value="menunggu_verifikasi">

                            Pending

                        </option>

                        <option
                            value="lunas">

                            Lunas

                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        name="from"
                        class="form-control"
                        value="{{ request('from') }}">

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        name="to"
                        class="form-control"
                        value="{{ request('to') }}">

                </div>

                <div class="col-md-1">

                    <button
                        class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

                <div class="col-md-3">

                    <select
                        name="sort"
                        class="form-select">

                        <option value="latest">

                            Terbaru

                        </option>

                        <option value="oldest">

                            Terlama

                        </option>

                        <option value="highest">

                            Nominal Terbesar

                        </option>

                        <option value="lowest">

                            Nominal Terkecil

                        </option>

                    </select>

                </div>

                <div class="col-md-9">

                    <a
                        href="{{ route('admin.pembayaran') }}"
                        class="btn btn-secondary">

                        Reset Filter

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>
<div class="card border-0 shadow">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Invoice</th>

<th>Pelanggan</th>

<th>Mitra</th>

<th>Tanggal</th>

<th>Metode</th>

<th>Total</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>

{{ $payment->invoice_number }}

</td>

<td>

{{ $payment->user->name }}

</td>

<td>

{{-- {{ $payment->mitra->business_name }} --}}
{{ $payment->mitra->business_name ?? '-' }}

</td>

<td>

{{ $payment->created_at->format('d M Y') }}

</td>

<td>

@if($payment->payment_method=="COD")

<span class="badge bg-primary">

COD

</span>

@else

<span class="badge bg-info">

VA

</span>

@endif

</td>

<td>

Rp {{ number_format($payment->total_price,0,',','.') }}

</td>

<td>

@if($payment->payment_status=="lunas")

<span class="badge bg-success">

Lunas

</span>

@elseif($payment->payment_status=="menunggu_verifikasi")

<span class="badge bg-warning">

Pending

</span>

@else

<span class="badge bg-danger">

Belum Bayar

</span>

@endif

</td>

<td>

<a

href="#"

class="btn btn-primary btn-sm">

Detail

</a>

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">

Belum ada transaksi.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-3">

{{ $payments->links() }}

</div>

</div>

</div>

@endsection