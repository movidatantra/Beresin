@extends('layouts.admin')

@section('title', 'Laporan Mitra')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-shop text-warning"></i>

                Laporan Mitra

            </h3>

            <p class="text-muted mb-0">

                Menampilkan performa seluruh mitra yang terdaftar pada aplikasi Beres.in.

            </p>

        </div>

    </div>

    <!-- CARD STATISTIK -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Mitra

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $totalMitra }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Mitra Terverifikasi

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $verifiedMitra }}

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

                    <h2 class="fw-bold text-primary mt-2">

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

                <i class="bi bi-funnel-fill text-warning"></i>

                Filter Mitra

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.mitras') }}">

                <div class="row g-3">

                    <div class="col-lg-4">

                        <label class="form-label">

                            Nama Mitra

                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Cari nama mitra...">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Status Verifikasi

                        </label>

                        <select name="verification_status"
                                class="form-select">

                            <option value="">Semua</option>

                            <option value="pending">Pending</option>

                            <option value="verified">Terverifikasi</option>

                            <option value="rejected">Ditolak</option>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Spesialisasi

                        </label>

                        <input type="text"
                               name="specialization"
                               value="{{ request('specialization') }}"
                               class="form-control"
                               placeholder="Contoh: AC">

                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">

                        <button class="btn btn-warning text-white w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.mitras') }}"
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

                        Cetak laporan performa mitra.

                    </small>

                </div>

                <div class="d-flex gap-2">

                    <div class="d-flex gap-2">

    <a href="{{ route('admin.reports.mitras.pdf', request()->query()) }}"
       class="btn btn-danger rounded-pill">

        <i class="bi bi-file-earmark-pdf-fill"></i>

        Export PDF

    </a>

    <a href="{{ route('admin.reports.mitras.excel', request()->query()) }}"
       class="btn btn-success rounded-pill">

        <i class="bi bi-file-earmark-excel-fill"></i>

        Export Excel

    </a>

</div>

                </div>

            </div>

        </div>

    </div>

    <!-- PART 2 -->
    <!-- Tabel Mitra -->

    <!-- TABEL MITRA -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table text-warning"></i>

                    Data Mitra

                </h5>

                <small class="text-muted">

                    Daftar seluruh mitra beserta performanya.

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

                        <th>Foto</th>

                        <th>Nama Mitra</th>

                        <th>Usaha</th>

                        <th>Spesialisasi</th>

                        <th>Total Order</th>

                        <th>Pendapatan</th>

                        <th>Status</th>

                        <th width="120">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($mitras as $mitra)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($mitras->currentPage()-1) * $mitras->perPage() }}

                        </td>

                        <td>

                            @if($mitra->photo)

                                <img src="{{ asset('storage/'.$mitra->photo) }}"
                                     width="55"
                                     height="55"
                                     class="rounded-circle object-fit-cover">

                            @else

                                <img src="https://ui-avatars.com/api/?name={{ urlencode($mitra->name) }}"
                                     width="55"
                                     class="rounded-circle">

                            @endif

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $mitra->name }}

                            </div>

                            <small class="text-muted">

                                {{ $mitra->email }}

                            </small>

                        </td>

                        <td>

                            {{ $mitra->business_name ?? '-' }}

                        </td>

                        <td>

                            {{ $mitra->specialization ?? '-' }}

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $mitra->orders_count }}

                            </span>

                        </td>

                        <td>

                            <span class="fw-bold text-success">

                                Rp {{ number_format($mitra->income) }}

                            </span>

                        </td>

                        <td>

                            @if($mitra->verification_status=='verified')

                                <span class="badge bg-success">

                                    Terverifikasi

                                </span>

                            @elseif($mitra->verification_status=='pending')

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Ditolak

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="#"

                               class="btn btn-info btn-sm rounded-pill">

                                <i class="bi bi-eye-fill"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9">

                            <div class="text-center py-5">

                                <i class="bi bi-shop display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    Belum Ada Data Mitra

                                </h5>

                                <p class="text-muted">

                                    Data mitra akan tampil di sini.

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

                {{ $mitras->firstItem() ?? 0 }}

                -

                {{ $mitras->lastItem() ?? 0 }}

                dari

                {{ $mitras->total() }}

                data

            </small>

            {{ $mitras->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection
