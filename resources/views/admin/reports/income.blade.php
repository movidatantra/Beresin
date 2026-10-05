@extends('layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-cash-stack text-success"></i>

                Laporan Pendapatan

            </h3>

            <p class="text-muted mb-0">

                Menampilkan seluruh pendapatan aplikasi Beres.in berdasarkan transaksi yang telah dibayar.

            </p>

        </div>

    </div>

    <!-- CARD STATISTIK -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pendapatan

                    </small>

                    <h4 class="fw-bold text-success mt-2">

                        Rp {{ number_format($totalIncome) }}

                    </h4>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Lunas

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $paidOrder }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Transfer Bank

                    </small>

                    <h2 class="fw-bold text-info mt-2">

                        {{ $bankPayment }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        E-Wallet

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $ewalletPayment }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-funnel-fill text-success"></i>

                Filter Pendapatan

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.income') }}">

                <div class="row g-3">

                    <div class="col-lg-3">

                        <label>Tanggal Awal</label>

                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label>Tanggal Akhir</label>

                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label>Metode Pembayaran</label>

                        <select name="payment_method"
                                class="form-select">

                            <option value="">Semua</option>

                            <option value="bank">Transfer Bank</option>

                            <option value="ewallet">E-Wallet</option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex align-items-end gap-2">

                        <button class="btn btn-success w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.income') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- EXPORT -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold">
                    Export Laporan
                </h5>

                <small class="text-muted">
                    Cetak laporan sesuai filter yang dipilih.
                </small>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.reports.income.pdf', request()->query()) }}"
                   class="btn btn-danger rounded-pill">

                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    PDF

                </a>

                <a href="{{ route('admin.reports.income.excel', request()->query()) }}"
                   class="btn btn-success rounded-pill">

                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Excel

                </a>

            </div>

        </div>

    </div>
</div>

    <!-- PART 2 -->
    <!-- Tabel Pendapatan -->

    <!-- TABEL LAPORAN PENDAPATAN -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table text-success"></i>

                    Data Pendapatan

                </h5>

                <small class="text-muted">

                    Menampilkan transaksi yang telah menghasilkan pendapatan.

                </small>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>

                        <th>Kode Order</th>

                        <th>Jadwal</th>

                        <th>Pelanggan</th>

                        <th>Mitra</th>

                        <th>Metode</th>

                        <th>Total</th>

                        <th>Status Bayar</th>

                        <th>Status Order</th>

                        <th class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($orders as $order)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($orders->currentPage()-1) * $orders->perPage() }}

                        </td>

                        <td>

                            <span class="fw-semibold">

                                ORD-{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}

                            </span>

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}

                        </td>

                        <td>

                            {{ $order->user->name ?? '-' }}

                        </td>

                        <td>

                            {{ $order->mitra->name ?? '-' }}

                        </td>

                        <td>

                            @php
    $method = strtoupper($order->payment_method ?? '');
@endphp

@if($method == 'BANK_TRANSFER')

    <span class="badge bg-primary">
        <i class="bi bi-bank"></i>
        Transfer Bank
    </span>

@elseif(in_array($method,[
    'GOPAY',
    'OVO',
    'DANA',
    'SHOPEEPAY',
    'LINKAJA'
]))

    <span class="badge bg-info">
        <i class="bi bi-wallet2"></i>
        E-Wallet
    </span>

@elseif($method == 'QRIS')

    <span class="badge bg-success">
        <i class="bi bi-qr-code"></i>
        QRIS
    </span>

@elseif($method == 'CASH')

    <span class="badge bg-secondary">
        COD
    </span>

@else

    <span class="badge bg-dark">
        {{ $order->payment_method ?? '-' }}
    </span>

@endif

                        </td>

                        <td>

                            <span class="fw-bold text-success">

                                Rp {{ number_format($order->total_price) }}

                            </span>

                        </td>

                        <td>

                            @if($order->payment_status=='lunas')

                                <span class="badge bg-success">

                                    Lunas

                                </span>

                            @elseif($order->payment_status=='menunggu_verifikasi')

                                <span class="badge bg-warning">

                                    Menunggu Verifikasi

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Belum Bayar

                                </span>

                            @endif

                        </td>

                        <td>

                            @switch($order->status)

                                @case('pending')

                                    <span class="badge bg-secondary">

                                        Pending

                                    </span>

                                    @break

                                @case('diterima')

                                    <span class="badge bg-info">

                                        Diterima

                                    </span>

                                    @break

                                @case('menuju_lokasi')

                                    <span class="badge bg-primary">

                                        Menuju Lokasi

                                    </span>

                                    @break

                                @case('dikerjakan')

                                    <span class="badge bg-warning text-dark">

                                        Dikerjakan

                                    </span>

                                    @break

                                @case('selesai')

                                    <span class="badge bg-success">

                                        Selesai

                                    </span>

                                    @break

                                @case('dibatalkan')

                                    <span class="badge bg-danger">

                                        Dibatalkan

                                    </span>

                                    @break

                                @default

                                    <span class="badge bg-secondary">

                                        {{ ucfirst($order->status) }}

                                    </span>

                            @endswitch

                        </td>

                        <td class="text-center">

                            <a href="#"

                               class="btn btn-info btn-sm rounded-pill">

                                <i class="bi bi-eye-fill"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10">

                            <div class="text-center py-5">

                                <i class="bi bi-wallet2 display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    Belum Ada Data Pendapatan

                                </h5>

                                <p class="text-muted">

                                    Tidak ada transaksi yang dapat ditampilkan.

                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="card-footer bg-white">

        <div class="row align-items-center">

            <div class="col-md-6">

                <small class="text-muted">

                    Menampilkan

                    {{ $orders->firstItem() ?? 0 }}

                    -

                    {{ $orders->lastItem() ?? 0 }}

                    dari

                    {{ $orders->total() }}

                    transaksi

                </small>

            </div>

            <div class="col-md-6 text-md-end">

                <h5 class="fw-bold text-success mb-0">

                    Total Pendapatan :

                    Rp {{ number_format($orders->sum('total_price')) }}

                </h5>

            </div>

        </div>

        <div class="mt-3">

            {{ $orders->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection

