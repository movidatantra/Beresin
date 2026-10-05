@extends('layouts.pelanggan')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-credit-card-fill text-success"></i>

Laporan Pembayaran

</h2>

<p class="text-muted">

Riwayat seluruh pembayaran layanan Anda.

</p>

</div>

<div>

<a href="{{ route('customer.reports.payments.pdf',request()->query()) }}"
class="btn btn-danger rounded-pill">

<i class="bi bi-file-earmark-pdf-fill"></i>

Export PDF

</a>

<a href="{{ route('customer.reports.payments.excel',request()->query()) }}"
class="btn btn-success rounded-pill">

<i class="bi bi-file-earmark-excel-fill"></i>

Export Excel

</a>

</div>

</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Status Pembayaran</label>

<select
    name="payment_status"
    class="form-select">

    <option value="">Semua</option>

    <option value="belum_bayar"
        {{ request('payment_status')=='belum_bayar' ? 'selected' : '' }}>

        Belum Bayar

    </option>

    <option value="lunas"
        {{ request('payment_status')=='lunas' ? 'selected' : '' }}>

        Lunas

    </option>

</select>

</div>

<div class="col-md-3">

<label>Tanggal Awal</label>

<input
type="date"
name="start_date"
class="form-control"
value="{{ request('start_date') }}">

</div>

<div class="col-md-3">

<label>Tanggal Akhir</label>

<input
type="date"
name="end_date"
class="form-control"
value="{{ request('end_date') }}">

</div>

<div class="col-md-2 d-grid">

<label>&nbsp;</label>

<button class="btn btn-primary">

<i class="bi bi-search"></i>

Filter

</button>

</div>

</div>

</form>

</div>

</div>
    <!-- =========================
         STATISTIK PEMBAYARAN
    ========================= -->

    <div class="row mb-4">

        <!-- TOTAL PEMBAYARAN -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Pengeluaran

                            </small>

                            <h3 class="fw-bold text-success mt-2">

                                Rp {{ number_format($totalPayment,0,',','.') }}

                            </h3>

                        </div>

                        <div
                            class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-wallet2 text-success fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- LUNAS -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Sudah Dibayar

                            </small>

                            <h2 class="fw-bold text-primary mt-2">

                                {{ $paid }}

                            </h2>

                        </div>

                        <div
                            class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-check-circle-fill text-primary fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- MENUNGGU -->

        

        <!-- BELUM BAYAR -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Belum Dibayar

                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                {{ $unpaid }}

                            </h2>

                        </div>

                        <div
                            class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-x-circle-fill text-danger fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- =========================
         TABEL PEMBAYARAN
    ========================= -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-credit-card-fill text-success"></i>

                Riwayat Pembayaran

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Invoice</th>

                            <th>Tanggal</th>

                            <th>Mitra</th>

                            <th>Layanan</th>

                            <th>Metode</th>

                            <th>Status Pembayaran</th>

                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payments as $no => $payment)

                        <tr>

                            <td>

                                {{ $payments->firstItem() + $no }}

                            </td>

                            <td>

                                <span class="fw-semibold">

                                    {{ $payment->invoice_number ?? '-' }}

                                </span>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($payment->jadwal)->format('d M Y') }}

                                <br>

                                <small class="text-muted">

                                    {{ $payment->jam }}

                                </small>

                            </td>

                            <td>

                                {{ $payment->mitra->business_name ?? $payment->mitra->name ?? '-' }}

                            </td>

                            <td>

                                {{ $payment->service->name ?? '-' }}

                            </td>

                            <td>

                                {{ ucfirst($payment->payment_method) }}

                            </td>

                            <td>

                                @switch($payment->payment_status)

                                    @case('lunas')

                                        <span class="badge bg-success">

                                            Lunas

                                        </span>

                                    @break

                                    @case('menunggu_verifikasi')

                                        <span class="badge bg-warning">

                                            Menunggu Verifikasi

                                        </span>

                                    @break

                                    @case('belum_bayar')

                                        <span class="badge bg-danger">

                                            Belum Bayar

                                        </span>

                                    @break

                                    @default

                                        <span class="badge bg-secondary">

                                            -

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                <span class="fw-bold text-success">

                                    Rp {{ number_format($payment->total_price,0,',','.') }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8">

                                <div class="text-center py-5">

                                    <i class="bi bi-credit-card-2-front fs-1 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Belum Ada Riwayat Pembayaran

                                    </h5>

                                    <p class="text-muted">

                                        Riwayat pembayaran Anda akan muncul di sini.

                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $payments->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection