@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- ===============================
         HEADER
    ================================ -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-cart-check-fill text-primary"></i>

                Laporan Order

            </h2>

            <p class="text-muted mb-0">

                Lihat seluruh riwayat order yang pernah Anda kerjakan.

            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{ route('mitra.reports.orders.pdf', request()->query()) }}"
               class="btn btn-danger rounded-pill me-2">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>

            <a href="{{ route('mitra.reports.orders.excel', request()->query()) }}"
               class="btn btn-success rounded-pill">

                <i class="bi bi-file-earmark-excel-fill"></i>

                Export Excel

            </a>

        </div>

    </div>

    <!-- ===============================
         FILTER
    ================================ -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Status Order

                        </label>

                        <select
                            name="status"
                            class="form-select">

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

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Awal

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ request('start_date') }}">

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Akhir

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ request('end_date') }}">

                    </div>

                    <div class="col-md-2 mb-3 d-grid">

                        <label class="form-label">

                            &nbsp;

                        </label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ===============================
         STATISTIK
    ================================ -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Order

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $orders->total() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Selesai

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $orders->where('status','selesai')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Pending

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $orders->where('status','pending')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Dibatalkan

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $orders->where('status','dibatalkan')->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- ===============================
         TABEL
    ================================ -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>

                            <th>Invoice</th>

                            <th>Tanggal</th>

                            <th>Pelanggan</th>

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

        {{ $orders->firstItem() + $no }}

    </td>

    <td>

        <span class="fw-semibold text-primary">

            {{ $order->invoice_number ?? '-' }}

        </span>

    </td>

    <td>

        <div class="fw-semibold">

            {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}

        </div>

        <small class="text-muted">

            {{ $order->jam }}

        </small>

    </td>

    <td>

        <div class="fw-semibold">

            {{ $order->user->name ?? '-' }}

        </div>

        <small class="text-muted">

            {{ $order->user->phone ?? '-' }}

        </small>

    </td>

    <td>

        {{ $order->service->name ?? '-' }}

    </td>

    <td>

        @switch($order->status)

            @case('pending')

                <span class="badge bg-warning text-dark">

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

                    {{ ucfirst($order->status) }}

                </span>

        @endswitch

    </td>

    <td>

        @switch($order->payment_method)

            @case('BANK_TRANSFER')

                <span class="badge bg-primary">

                    Transfer Bank

                </span>

                @break

            @case('QRIS')

                <span class="badge bg-success">

                    QRIS

                </span>

                @break

            @case('GOPAY')

                <span class="badge bg-success">

                    GoPay

                </span>

                @break

            @case('OVO')

                <span class="badge bg-warning text-dark">

                    OVO

                </span>

                @break

            @case('DANA')

                <span class="badge bg-info">

                    DANA

                </span>

                @break

            @case('SHOPEEPAY')

                <span class="badge bg-danger">

                    ShopeePay

                </span>

                @break

            @default

                <span class="badge bg-secondary">

                    {{ $order->payment_method }}

                </span>

        @endswitch

    </td>

    <td class="text-end">

        <span class="fw-bold text-success">

            Rp {{ number_format($order->total_price,0,',','.') }}

        </span>

    </td>

</tr>

@empty

<tr>

    <td colspan="8">

        <div class="text-center py-5">

            <i class="bi bi-inbox display-1 text-secondary"></i>

            <h5 class="mt-3">

                Belum Ada Order

            </h5>

            <p class="text-muted">

                Tidak ada data order yang sesuai dengan filter.

            </p>

        </div>

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">

    <small class="text-muted">

        Menampilkan

        {{ $orders->firstItem() ?? 0 }}

        -

        {{ $orders->lastItem() ?? 0 }}

        dari

        {{ $orders->total() }}

        data

    </small>

    {{ $orders->withQueryString()->links() }}

</div>

</div>

</div>

@endsection