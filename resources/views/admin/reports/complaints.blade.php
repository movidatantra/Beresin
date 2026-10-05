@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-chat-left-text-fill text-danger"></i>

                Laporan Pengaduan

            </h3>

            <p class="text-muted mb-0">

                Menampilkan seluruh pengaduan pelanggan dan mitra pada aplikasi Beres.in.

            </p>

        </div>

    </div>

    <!-- CARD -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pengaduan

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $totalComplaint }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Menunggu

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $waitingComplaint }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Ditanggapi

                    </small>

                    <h2 class="fw-bold text-info mt-2">

                        {{ $processComplaint }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Selesai

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $doneComplaint }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-funnel-fill text-danger"></i>

                Filter Pengaduan

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.complaints') }}">

                <div class="row g-3">

                    <div class="col-lg-4">

                        <label class="form-label">

                            Nama Pelapor

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">Semua</option>

                            <option value="pending">Pending</option>

                            <option value="diproses">Diproses</option>

                            <option value="selesai">Selesai</option>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Tanggal

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="form-control">

                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">

                        <button class="btn btn-danger w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.complaints') }}"
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

                        Cetak laporan pengaduan.

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
    <!-- TABEL PENGADUAN -->

<!-- TABEL DATA PENGADUAN -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table text-danger"></i>

                    Data Pengaduan

                </h5>

                <small class="text-muted">

                    Daftar seluruh pengaduan pelanggan dan mitra.

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

                        <th>Tanggal</th>

                        <th>Pelapor</th>

                        <th>Role</th>

                        <th>Judul</th>

                        <th>Isi Pengaduan</th>

                        <th>Status</th>

                        <th>Ditanggapi Oleh</th>

                        <th width="130">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($complaints as $complaint)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($complaints->currentPage()-1) * $complaints->perPage() }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y') }}

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $complaint->user->name ?? '-' }}

                            </div>

                        </td>

                        <td>

                            @if(($complaint->user->role ?? '') == 'pelanggan')

                                <span class="badge bg-primary">

                                    Pelanggan

                                </span>

                            @else

                                <span class="badge bg-warning text-dark">

                                    Mitra

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $complaint->title }}

                        </td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($complaint->description,60) }}

                        </td>

                        <td>

                            @if($complaint->status=='pending')

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            @elseif($complaint->status=='diproses')

                                <span class="badge bg-info">

                                    Diproses

                                </span>

                            @elseif($complaint->status=='selesai')

                                <span class="badge bg-success">

                                    Selesai

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    {{ ucfirst($complaint->status) }}

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $complaint->admin->name ?? '-' }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="{{ route('admin.complaints.show',$complaint->id) }}"

                                   class="btn btn-info btn-sm rounded-pill">

                                    <i class="bi bi-eye-fill"></i>

                                </a>

                                <a href="{{ route('admin.complaints.show',$complaint->id) }}"

                                   class="btn btn-success btn-sm rounded-pill">

                                    <i class="bi bi-chat-left-text-fill"></i>

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9">

                            <div class="text-center py-5">

                                <i class="bi bi-chat-square-text display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    Belum Ada Pengaduan

                                </h5>

                                <p class="text-muted">

                                    Pengaduan dari pelanggan maupun mitra akan tampil di sini.

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

                {{ $complaints->firstItem() ?? 0 }}

                -

                {{ $complaints->lastItem() ?? 0 }}

                dari

                {{ $complaints->total() }}

                pengaduan

            </small>

            {{ $complaints->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection