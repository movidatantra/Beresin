@extends('layouts.admin')

@section('title', 'Laporan Order')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb mb-2">

                    <li class="breadcrumb-item">
                        <a href="/admin/dashboard" class="text-decoration-none">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.reports') }}"
                           class="text-decoration-none">

                            Laporan

                        </a>
                    </li>

                    <li class="breadcrumb-item active">

                        Laporan Order

                    </li>

                </ol>

            </nav>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-box-seam-fill text-primary"></i>

                Laporan Order

            </h3>

            <p class="text-muted mb-0">

                Menampilkan seluruh transaksi pemesanan layanan.

            </p>

        </div>

    </div>

    <!-- Ringkasan -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

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

        <div class="col-lg-3 col-md-6">

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

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Diproses

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $orders->where('status','diproses')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Order Pending

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $orders->where('status','pending')->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Filter -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">

                <i class="bi bi-funnel-fill text-primary"></i>

                Filter Laporan

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.orders') }}">

                <div class="row g-3">

                    <div class="col-lg-3">

                        <label class="form-label">

                            Tanggal Awal

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Tanggal Akhir

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Status

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

                            <option value="diproses"
                                {{ request('status')=='diproses' ? 'selected' : '' }}>

                                Diproses

                            </option>

                            <option value="selesai"
                                {{ request('status')=='selesai' ? 'selected' : '' }}>

                                Selesai

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex align-items-end gap-2">

                        <button
                            class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.orders') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Export -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold mb-1">

                        Export Laporan

                    </h5>

                    <small class="text-muted">

                        Cetak laporan berdasarkan filter yang dipilih.

                    </small>

                </div>

                <div class="d-flex gap-2">

                   <a href="{{ route('admin.reports.orders.pdf', request()->query()) }}"
   class="btn btn-danger rounded-pill">

    <i class="bi bi-file-earmark-pdf-fill"></i>
    Export PDF
</a>

<a href="{{ route('admin.reports.orders.excel', request()->query()) }}"
   class="btn btn-success rounded-pill">

    <i class="bi bi-file-earmark-excel-fill"></i>
    Export Excel
</a>

                </div>

            </div>

        </div>

    </div>

    <!-- PART 2 -->
    <!-- Di sini nanti kita akan menambahkan tabel order lengkap -->

    <!-- TABEL ORDER -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table text-primary"></i>

                    Data Laporan Order

                </h5>

                <small class="text-muted">

                    Menampilkan seluruh data transaksi pelanggan.

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

                        <th>Tanggal</th>

                        <th>Pelanggan</th>

                        <th>Mitra</th>

                        <th>Layanan</th>

                        <th>Total</th>

                        <th>Pembayaran</th>

                        <th>Status</th>

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

                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}

                        </td>

                        <td>

                            {{ $order->user->name ?? '-' }}

                        </td>

                        <td>

                            {{ $order->mitra->name ?? '-' }}

                        </td>

                        <td>

                            {{ $order->service->name ?? '-' }}

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

                            @if($order->status=='pending')

                                <span class="badge bg-secondary">

                                    Pending

                                </span>

                            @elseif($order->status=='diproses')

                                <span class="badge bg-primary">

                                    Diproses

                                </span>

                            @elseif($order->status=='selesai')

                                <span class="badge bg-success">

                                    Selesai

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Dibatalkan

                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <a href="#"
                               class="btn btn-sm btn-info rounded-pill">

                                <i class="bi bi-eye-fill"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10">

                            <div class="text-center py-5">

                                <i class="bi bi-inbox display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    Belum Ada Data Order

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

        <div class="d-flex justify-content-between align-items-center flex-wrap">

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

</div>

@endsection