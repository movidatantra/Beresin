
@extends('layouts.admin')

@section('content')

<!-- HEADER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold mb-1">
                Dashboard Admin
            </h2>

            <p class="text-muted mb-0">
                Monitoring seluruh aktivitas platform Beres.in
            </p>

        </div>

        <!-- LONCENG -->

        <div class="dropdown">

            <button
                class="btn btn-light position-relative"
                data-bs-toggle="dropdown">

                <i class="bi bi-bell-fill fs-3"></i>

                @if($jumlahNotifikasi > 0)

                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                        {{ $jumlahNotifikasi }}

                    </span>

                @endif

            </button>

            <div
                class="dropdown-menu dropdown-menu-end shadow p-0"
                style="width:350px">

                <div class="p-3 border-bottom">

                    <strong>Notifikasi</strong>

                </div>

                @forelse($notifications as $notif)

                    <a href="{{ $notif['url'] }}"
                       class="dropdown-item py-3">

                        <div class="d-flex">

                            <i class="bi {{ $notif['icon'] }} text-{{ $notif['color'] }} fs-4 me-3"></i>

                            <div>

                                <strong>{{ $notif['title'] }}</strong>

                                <br>

                                <small class="text-muted">

                                    {{ $notif['message'] }}

                                </small>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="text-center p-3">

                        Tidak ada notifikasi

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<!-- STATISTIK MITRA -->

<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Total Mitra

                </small>

                <h2 class="fw-bold text-primary">

                    {{ $totalMitra }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Mitra Verified

                </small>

                <h2 class="fw-bold text-success">

                    {{ $verifiedMitra }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Menunggu Approval

                </small>

                <h2 class="fw-bold text-warning">

                    {{ $pendingMitra }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Mitra Ditolak

                </small>

                <h2 class="fw-bold text-danger">

                    {{ $rejectedMitra }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- STATISTIK PLATFORM -->

<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Total Order

                </small>

                <h2 class="fw-bold text-primary">

                    {{ $totalOrder }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Total Pelanggan

                </small>

                <h2 class="fw-bold text-info">

                    {{ $totalPelanggan }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Menunggu Pencairan

                </small>

                <h2 class="fw-bold text-warning">

                    {{ $pendingPencairan }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-muted">

                    Pencairan Berhasil

                </small>

                <h2 class="fw-bold text-success">

                    {{ $berhasilPencairan }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- QUICK ACTION -->

<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">

        <a href="/admin/mitra"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <i class="bi bi-person-check-fill fs-1 text-primary"></i>

                    <h6 class="mt-3 mb-0">

                        Verifikasi Mitra

                    </h6>

                </div>

            </div>

        </a>

    </div>

    <div class="col-lg-3 col-md-6">

        <a href="/admin/orders"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <i class="bi bi-cart-check-fill fs-1 text-success"></i>

                    <h6 class="mt-3 mb-0">

                        Kelola Order

                    </h6>

                </div>

            </div>

        </a>

    </div>

    <div class="col-lg-3 col-md-6">

        <a href="/admin/withdrawals"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <i class="bi bi-cash-stack fs-1 text-warning"></i>

                    <h6 class="mt-3 mb-0">

                        Kelola Pencairan Saldo

                    </h6>

                </div>

            </div>

        </a>

    </div>

    <div class="col-lg-3 col-md-6">

        <a href="/admin/reports"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <i class="bi bi-bar-chart-fill fs-1 text-danger"></i>

                    <h6 class="mt-3 mb-0">

                        Laporan

                    </h6>

                </div>

            </div>

        </a>

    </div>

</div>

<!-- TABEL & NOTIFIKASI -->

<div class="row">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    Mitra Menunggu Verifikasi

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Nama</th>

                                <th>Usaha</th>

                                <th>Area</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($mitraPendingList as $mitra)

                            <tr>

                                <td>

                                    {{ $mitra->name }}

                                </td>

                                <td>

                                    {{ $mitra->business_name }}

                                </td>

                                <td>

                                    {{ $mitra->business_area }}

                                </td>

                                <td>

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                </td>

                                <td>

                                    <a href="/admin/mitra/approve/{{ $mitra->id }}"
                                       class="btn btn-success btn-sm">

                                        Approve

                                    </a>

                                    <a href="/admin/mitra/reject/{{ $mitra->id }}"
                                       class="btn btn-danger btn-sm">

                                        Reject

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center py-4">

                                    Tidak ada mitra menunggu verifikasi

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    🔔 Notifikasi Admin

                </h5>

            </div>

            <div class="card-body">

                <div class="alert alert-warning">

                    {{ $pendingMitra }}
                    mitra menunggu verifikasi

                </div>

                <div class="alert alert-info">

                    {{ $pendingPencairan }}
                    pencairan menunggu approval

                </div>

                <div class="alert alert-success">

                    {{ $totalOrder }}
                    total order tercatat

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

