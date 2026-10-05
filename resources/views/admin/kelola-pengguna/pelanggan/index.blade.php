@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold">
            Kelola Pelanggan
        </h3>

        <small class="text-muted">
            Daftar seluruh pelanggan Beres.in
        </small>

    </div>

</div>

<!-- Statistik -->

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow rounded-4">

            <div class="card-body">

                <small class="text-muted">
                    Total Pelanggan
                </small>

                <h2 class="fw-bold text-primary">

                    {{ $totalCustomer }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- Search -->

<div class="card border-0 shadow rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <!-- Search -->
                <div class="col-md-5">

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Cari nama, email atau nomor HP..."
                        value="{{ request('search') }}">

                </div>

                <!-- Status -->
                <div class="col-md-3">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">Semua Status</option>

                        <option value="active"
                            {{ request('status')=='active'?'selected':'' }}>

                            Aktif

                        </option>

                        <option value="suspended"
                            {{ request('status')=='suspended'?'selected':'' }}>

                            Suspended

                        </option>

                    </select>

                </div>

                <!-- Sort -->
                {{-- <div class="col-md-2">

                    <select
                        name="sort"
                        class="form-select">

                        <option value="latest">Terbaru</option>

                        <option value="oldest"
                            {{ request('sort')=='oldest'?'selected':'' }}>

                            Terlama

                        </option>

                        <option value="az"
                            {{ request('sort')=='az'?'selected':'' }}>

                            Nama A-Z

                        </option>

                        <option value="za"
                            {{ request('sort')=='za'?'selected':'' }}>

                            Nama Z-A

                        </option>

                    </select>

                </div> --}}

                <!-- Button -->
                <div class="col-md-2 d-flex">

                    <button
                        class="btn btn-primary w-100 me-2">

                        <i class="bi bi-search"></i>

                    </button>

                    <a
                        href="{{ route('admin.kelola-pengguna.pelanggan') }}"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Table -->

<div class="card border-0 shadow rounded-4">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>No</th>

                    <th>Nama</th>

                    <th>Email</th>

                    <th>No HP</th>
                    <th>Status</th>

                    <th>Tanggal Daftar</th>

                    <th>Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($customers as $customer)

                    <tr>

                        <td>

                            {{ $customers->firstItem() + $loop->index }}

                        </td>

                        <td>

                            {{ $customer->name }}

                        </td>

                        <td>

                            {{ $customer->email }}

                        </td>

                        <td>

                            {{ $customer->phone }}

                        </td>
                        <td>

    @if($customer->status == 'active')

        <span class="badge bg-success">

            <i class="bi bi-check-circle-fill"></i>

            Aktif

        </span>

    @elseif($customer->status == 'suspended')

        <span class="badge bg-danger">

            <i class="bi bi-person-x-fill"></i>

            Suspended

        </span>

    @else

        <span class="badge bg-secondary">

            Tidak Diketahui

        </span>

    @endif

</td>

                        <td>

                            {{ $customer->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <a
                                href="{{ route('admin.kelola-pengguna.pelanggan.show',$customer->id) }}"
                                class="btn btn-primary btn-sm">

                                <i class="bi bi-eye-fill"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-4">

                            Tidak ada pelanggan

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $customers->links() }}

        </div>

    </div>

</div>

@endsection