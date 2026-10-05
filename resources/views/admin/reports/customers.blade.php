@extends('layouts.admin')

@section('title', 'Laporan Pelanggan')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-people-fill text-primary"></i>

                Laporan Pelanggan

            </h3>

            <p class="text-muted mb-0">

                Menampilkan seluruh data pelanggan beserta aktivitas pemesanannya.

            </p>

        </div>

    </div>

    <!-- CARD STATISTIK -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pelanggan

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $totalCustomer }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Pelanggan Aktif

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $activeCustomer }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Booking

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $totalBooking }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Transaksi

                    </small>

                    <h5 class="fw-bold text-success mt-2">

                        Rp {{ number_format($totalTransaction) }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-funnel-fill text-primary"></i>

                Filter Pelanggan

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.customers') }}">

                <div class="row g-3">

                    <div class="col-lg-5">

                        <label class="form-label">

                            Nama / Email

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Cari pelanggan...">

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

                            <option value="tidak_aktif">

                                Tidak Aktif

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex align-items-end gap-2">

                        <button class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        <a href="{{ route('admin.reports.customers') }}"
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

                        Cetak laporan pelanggan.

                    </small>

                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('admin.reports.customers.pdf', request()->query()) }}"
   class="btn btn-danger rounded-pill">

    <i class="bi bi-file-earmark-pdf-fill"></i>

    PDF

</a>

                   <a href="{{ route('admin.reports.customers.excel', request()->query()) }}"
   class="btn btn-success rounded-pill">

    <i class="bi bi-file-earmark-excel-fill"></i>

    Excel

</a>

                </div>

            </div>

        </div>

    </div>

    <!-- PART 2 -->
    <!-- TABEL PELANGGAN -->
    <!-- TABEL DATA PELANGGAN -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table text-primary"></i>

                    Data Pelanggan

                </h5>

                <small class="text-muted">

                    Daftar seluruh pelanggan aplikasi Beres.in.

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

                        <th>Nama</th>

                        <th>Email</th>

                        <th>No. HP</th>

                        <th>Total Booking</th>

                        <th>Total Transaksi</th>

                        <th>Status</th>

                        <th width="120">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($customers as $customer)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($customers->currentPage()-1) * $customers->perPage() }}

                        </td>

                        <td>

                            @if($customer->photo)

                                <img src="{{ asset('storage/'.$customer->photo) }}"
                                     width="55"
                                     height="55"
                                     class="rounded-circle">

                            @else

                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}"
                                     width="55"
                                     class="rounded-circle">

                            @endif

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $customer->name }}

                            </div>

                        </td>

                        <td>

                            {{ $customer->email }}

                        </td>

                        <td>

                            {{ $customer->phone ?? '-' }}

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $customer->orders_count }}

                            </span>

                        </td>

                        <td>

                            <span class="fw-bold text-success">

                                Rp {{ number_format($customer->total_transaction) }}

                            </span>

                        </td>

                        <td>

                            @if($customer->orders_count > 0)

                                <span class="badge bg-success">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    Belum Pernah Order

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

                                <i class="bi bi-people display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    Belum Ada Data Pelanggan

                                </h5>

                                <p class="text-muted">

                                    Data pelanggan akan ditampilkan di sini.

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

                {{ $customers->firstItem() ?? 0 }}

                -

                {{ $customers->lastItem() ?? 0 }}

                dari

                {{ $customers->total() }}

                pelanggan

            </small>

            {{ $customers->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection

