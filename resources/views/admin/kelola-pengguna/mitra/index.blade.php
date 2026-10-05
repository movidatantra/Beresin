@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold">

            Kelola Mitra

        </h3>

        <small class="text-muted">

            Daftar seluruh mitra Beres.in

        </small>

    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <small>Total Mitra</small>

                <h2 class="fw-bold text-primary">

                    {{ $totalMitra }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <small>Verified</small>

                <h2 class="fw-bold text-success">

                    {{ $verified }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <small>Pending</small>

                <h2 class="fw-bold text-warning">

                    {{ $pending }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <small>Rejected</small>

                <h2 class="fw-bold text-danger">

                    {{ $rejected }}

                </h2>

            </div>

        </div>

    </div>

</div>
<div class="card border-0 shadow rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <!-- Search -->
                <div class="col-md-4">

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Cari nama, usaha atau email..."
                        value="{{ request('search') }}">

                </div>

                <!-- Status Verifikasi -->
                <div class="col-md-2">

                    <select
                        name="verification_status"
                        class="form-select">

                        <option value="">Semua Status</option>

                        <option
                            value="verified"
                            {{ request('verification_status')=='verified'?'selected':'' }}>

                            Verified

                        </option>

                        <option
                            value="pending"
                            {{ request('verification_status')=='pending'?'selected':'' }}>

                            Pending

                        </option>

                        <option
                            value="rejected"
                            {{ request('verification_status')=='rejected'?'selected':'' }}>

                            Rejected

                        </option>

                    </select>

                </div>

                <!-- Online -->
                <div class="col-md-2">

                    <select
                        name="online"
                        class="form-select">

                        <option value="">Semua</option>

                        <option
                            value="1"
                            {{ request('online')=='1'?'selected':'' }}>

                            Online

                        </option>

                        <option
                            value="0"
                            {{ request('online')=='0'?'selected':'' }}>

                            Offline

                        </option>

                    </select>

                </div>

                <!-- Sort -->
                <div class="col-md-2">

                    <select
                        name="sort"
                        class="form-select">

                        <option value="latest">

                            Terbaru

                        </option>

                        <option
                            value="oldest"
                            {{ request('sort')=='oldest'?'selected':'' }}>

                            Terlama

                        </option>

                        <option
                            value="az"
                            {{ request('sort')=='az'?'selected':'' }}>

                            Nama A-Z

                        </option>

                        <option
                            value="za"
                            {{ request('sort')=='za'?'selected':'' }}>

                            Nama Z-A

                        </option>

                    </select>

                </div>

                <!-- Button -->
                <div class="col-md-2 d-flex">

                    <button
                        class="btn btn-primary w-100 me-2">

                        <i class="bi bi-search"></i>

                    </button>

                    <a
                        href="{{ route('admin.kelola-pengguna.mitra') }}"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>
<div class="card border-0 shadow rounded-4">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Foto</th>

                        <th>Nama</th>

                        <th>Usaha</th>

                        <th>Spesialisasi</th>

                        <th>Area</th>

                        <th>Status</th>

                        <th>Online</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($mitras as $mitra)

                    <tr>

                        <td>

                            {{ $mitras->firstItem()+$loop->index }}

                        </td>

                        <td>

                            @if($mitra->photo)

                                <img
                                    src="{{ asset('uploads/profile/'.$mitra->photo) }}"
                                    width="50"
                                    height="50"
                                    class="rounded-circle"
                                    style="object-fit:cover">

                            @else

                                <i class="bi bi-person-circle fs-1 text-primary"></i>

                            @endif

                        </td>

                        <td>

                            <strong>

                                {{ $mitra->name }}

                            </strong>

                            <br>

                            <small class="text-muted">

                                {{ $mitra->email }}

                            </small>

                        </td>

                        <td>

                            {{ $mitra->business_name }}

                        </td>

                        <td>

                            {{ $mitra->specialization }}

                        </td>

                        <td>

                            {{ $mitra->business_area }}

                        </td>

                        <td>

                            @if($mitra->verification_status=='verified')

                                <span class="badge bg-success">

                                    Verified

                                </span>

                            @elseif($mitra->verification_status=='pending')

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Rejected

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($mitra->is_online)

                                <span class="badge bg-success">

                                    Online

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    Offline

                                </span>

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('admin.kelola-pengguna.mitra.show',$mitra->id) }}"
                                class="btn btn-primary btn-sm">

                                <i class="bi bi-eye-fill"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center py-5">

                            Belum ada data mitra.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $mitras->links() }}

        </div>

    </div>

</div>

@endsection