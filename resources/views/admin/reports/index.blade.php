@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-fill text-primary"></i>
                Laporan Utama
            </h3>
            <p class="text-muted mb-0">
                Ringkasan aktivitas dan performa bisnis aplikasi Beres.in.
            </p>
        </div>
    </div>

    <!-- GLOBAL FILTER PERIODE LAPORAN -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ url('/admin/reports') }}" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-semibold mb-1">Dari Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-semibold mb-1">Sampai Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end pt-4">
                    <button type="submit" class="btn btn-primary btn-sm px-4 me-2 w-100">
                        <i class="bi bi-filter me-1"></i> Filter Data
                    </button>
                    <a href="{{ url('/admin/reports') }}" class="btn btn-light btn-sm px-3 w-50 border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- CARD STATISTIK UTAMA -->
    <div class="row g-4 mb-4">
        <!-- Total Order -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Order</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $totalOrder }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-box-seam-fill text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Pendapatan Platform</small>
                            <h4 class="fw-bold mt-2 mb-0 text-success">
                                Rp {{ number_format($totalIncome) }}
                            </h4>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cash-stack text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mitra -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Mitra</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $totalMitra }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-shop text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelanggan -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Pelanggan</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $totalCustomer }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people-fill text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATUS OPERASIONAL ORDER -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold text-success mb-1">{{ $completedOrder }}</h3>
                    <div class="text-muted small fw-medium">Order Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold text-warning mb-1">{{ $processOrder }}</h3>
                    <div class="text-muted small fw-medium">Order Diproses</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-3">
                    <h3 class="fw-bold text-danger mb-1">{{ $pendingOrder }}</h3>
                    <div class="text-muted small fw-medium">Order Pending</div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID MENU DETAIL LAPORAN -->
    <h5 class="fw-bold mb-3 text-dark mt-5">Detail Analisis Per Komponen</h5>
    <div class="row g-4 mb-5">
        <!-- Laporan Order -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-box-seam-fill fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Order</h5>
                        <p class="text-muted small">Melihat seluruh transaksi pemesanan layanan pelanggan beserta status dan pembayarannya.</p>
                    </div>
                    <a href="{{ route('admin.reports.orders') }}" class="btn btn-primary btn-sm rounded-pill px-4 mt-3 align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-cash-stack fs-2 text-success"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Pendapatan</h5>
                        <p class="text-muted small">Menampilkan total bagi hasil komisi platform dari transaksi mitra yang telah lunas.</p>
                    </div>
                    <a href="{{ route('admin.reports.income') }}" class="btn btn-success btn-sm rounded-pill px-4 mt-3 text-white align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Mitra -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-shop fs-2 text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Mitra</h5>
                        <p class="text-muted small">Menampilkan peringkat performa kerja seluruh mitra berdasarkan total transaksi.</p>
                    </div>
                    <a href="{{ route('admin.reports.mitras') }}" class="btn btn-warning btn-sm rounded-pill px-4 mt-3 text-white align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Pelanggan -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-people-fill fs-2 text-danger"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Pelanggan</h5>
                        <p class="text-muted small">Menampilkan data retensi pelanggan aktif beserta volume pemesanan ulang mereka.</p>
                    </div>
                    <a href="{{ route('admin.reports.customers') }}" class="btn btn-danger btn-sm rounded-pill px-4 mt-3 align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Layanan -->
        {{-- <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-tools fs-2 text-info"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Layanan</h5>
                        <p class="text-muted small">Menampilkan performa grafik kategori keahlian jasa yang paling sering dipesan pasar.</p>
                    </div>
                    <a href="{{ route('admin.reports.services') }}" class="btn btn-info btn-sm rounded-pill px-4 mt-3 text-white align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div> --}}

        <!-- Pengaduan -->
        {{-- <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                <div class="card-body d-flex flex-column justify-content-between p-0">
                    <div>
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-chat-left-text-fill fs-2 text-secondary"></i>
                        </div>
                        <h5 class="fw-bold">Laporan Pengaduan</h5>
                        <p class="text-muted small">Menampilkan data komplain dan sengketa transaksi lapangan dari pelanggan maupun mitra.</p>
                    </div>
                    <a href="{{ route('admin.reports.complaints') }}" class="btn btn-secondary btn-sm rounded-pill px-4 mt-3 align-self-center">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- SECTION CETAK LAPORAN DOKUMEN -->
    

</div>

@endsection