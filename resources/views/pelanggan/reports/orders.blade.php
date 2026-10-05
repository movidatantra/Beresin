@extends('layouts.pelanggan')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold text-dark">

                <i class="bi bi-cart-check-fill text-primary"></i>

                Laporan Pesanan

            </h2>

            <p class="text-muted mb-0">

                Riwayat seluruh pesanan layanan yang pernah Anda lakukan.

            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{ route('customer.reports.orders.pdf', request()->query()) }}"
               class="btn btn-danger rounded-pill">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>

            <a href="{{ route('customer.reports.orders.excel', request()->query()) }}"
               class="btn btn-success rounded-pill">

                <i class="bi bi-file-earmark-excel-fill"></i>

                Export Excel

            </a>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select rounded-3">

                            <option value="">

                                Semua Status

                            </option>

                            <option value="pending"
                                {{ request('status')=='pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="diterima"
                                {{ request('status')=='diterima' ? 'selected' : '' }}>

                                Diterima

                            </option>

                            <option value="menuju_lokasi"
                                {{ request('status')=='menuju_lokasi' ? 'selected' : '' }}>

                                Menuju Lokasi

                            </option>

                            <option value="dikerjakan"
                                {{ request('status')=='dikerjakan' ? 'selected' : '' }}>

                                Dikerjakan

                            </option>

                            <option value="selesai"
                                {{ request('status')=='selesai' ? 'selected' : '' }}>

                                Selesai

                            </option>

                            <option value="dibatalkan"
                                {{ request('status')=='dibatalkan' ? 'selected' : '' }}>

                                Dibatalkan

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Tanggal Awal

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control rounded-3"
                            value="{{ request('start_date') }}">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Tanggal Akhir

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control rounded-3"
                            value="{{ request('end_date') }}">

                    </div>

                    <div class="col-lg-3 d-grid">

                        <label class="form-label">

                            &nbsp;

                        </label>

                        <button
                            class="btn btn-primary rounded-3">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
        <!-- =========================
         STATISTIK
    ========================= -->

    <div class="row mb-4">

        <!-- TOTAL ORDER -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Total Pesanan

                            </small>

                            <h2 class="fw-bold text-primary mt-2">

                                {{ $totalOrder }}

                            </h2>

                        </div>

                        <div
                            class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-cart-check-fill text-primary fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- PENDING -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Pending

                            </small>

                            <h2 class="fw-bold text-warning mt-2">

                                {{ $pendingOrder }}

                            </h2>

                        </div>

                        <div
                            class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-hourglass-split text-warning fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- SELESAI -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Pesanan Selesai

                            </small>

                            <h2 class="fw-bold text-success mt-2">

                                {{ $completedOrder }}

                            </h2>

                        </div>

                        <div
                            class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">

                            <i class="bi bi-check-circle-fill text-success fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- DIBATALKAN -->

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">

                                Dibatalkan

                            </small>

                            <h2 class="fw-bold text-danger mt-2">

                                {{ $cancelledOrder }}

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
         TABEL PESANAN
    ========================= -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-table text-primary"></i>

                Riwayat Pesanan

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

                            <th>Status</th>

                            <th>Pembayaran</th>

                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($orders as $no => $order)

                        <tr>

                            <td>

                                {{ $orders->firstItem()+$no }}

                            </td>

                            <td>

                                <span class="fw-semibold">

                                    {{ $order->invoice_number ?? '-' }}

                                </span>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}

                                <br>

                                <small class="text-muted">

                                    {{ $order->jam }}

                                </small>

                            </td>

                            <td>

                                {{ $order->mitra->business_name ?? $order->mitra->name ?? '-' }}

                            </td>

                            <td>

                                {{ $order->service->name ?? '-' }}

                            </td>

                            <td>

                                @switch($order->status)

                                    @case('pending')

                                        <span class="badge bg-warning">

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

                                        <span class="badge bg-secondary">

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

                                        <span class="badge bg-dark">

                                            -

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                @if($order->payment_status=='lunas')

                                    <span class="badge bg-success">

                                        Lunas

                                    </span>

                                @elseif($order->payment_status=='menunggu_verifikasi')

                                    <span class="badge bg-warning">

                                        Menunggu

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Belum Bayar

                                    </span>

                                @endif

                            </td>

                            <td>

                                <span class="fw-bold text-success">

                                    Rp {{ number_format($order->total_price,0,',','.') }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8">

                                <div class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Belum Ada Pesanan

                                    </h5>

                                    <p class="text-muted">

                                        Riwayat pesanan Anda akan muncul di sini.

                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $orders->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection