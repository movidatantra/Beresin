@extends('layouts.admin')

@section('title', 'Laporan Layanan')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-tools text-info"></i>

                Laporan Layanan

            </h3>

            <p class="text-muted mb-0">

                Menampilkan performa seluruh layanan yang tersedia pada aplikasi Beres.in.

            </p>

        </div>

    </div>

    <!-- CARD STATISTIK -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Layanan

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $totalService }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Layanan Aktif

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $activeService }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Order

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $totalOrder }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pendapatan

                    </small>

                    <h5 class="fw-bold text-success mt-2">

                        Rp {{ number_format($totalIncome) }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-funnel-fill text-info"></i>

                Filter Layanan

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.services') }}">

                <div class="row g-3">

                    <div class="col-lg-5">

                        <label class="form-label">

                            Nama Layanan

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Cari layanan...">

                    </div>

                    <div class="col-lg-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">Semua</option>

                            <option value="aktif">

                                Aktif

                            </option>

                            <option value="nonaktif">

                                Nonaktif

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex align-items-end gap-2">

                        <button class="btn btn-info text-white w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.services') }}"
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

                        Cetak laporan layanan.

                    </small>

                </div>

                <div class="d-flex gap-2">

                    <a href="#"
                       class="btn btn-danger rounded-pill">

                        <i class="bi bi-file-earmark-pdf-fill"></i>

                        PDF

                    </a>

                    <a href="#"
                       class="btn btn-success rounded-pill">

                        <i class="bi bi-file-earmark-excel-fill"></i>

                        Excel

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- PART 2 -->
    <!-- TABEL LAYANAN -->

</div>

@endsection