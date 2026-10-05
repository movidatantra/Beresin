@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-bar-graph-fill text-primary"></i>
                Laporan Mitra
            </h2>

            <p class="text-muted mb-0">
                Kelola dan cetak seluruh laporan aktivitas Anda.
            </p>

        </div>

    </div>

    <div class="row g-4">

        <!-- Pendapatan -->

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100 report-card">

                <div class="card-body text-center p-4">

                    <div class="icon-circle bg-success-subtle text-success mb-3">

                        <i class="bi bi-cash-stack fs-2"></i>

                    </div>

                    <h5 class="fw-bold">
                        Laporan Pendapatan
                    </h5>

                    <p class="text-muted small">

                        Lihat seluruh pendapatan, filter transaksi, dan cetak laporan PDF maupun Excel.

                    </p>

                    <a href="{{ route('mitra.reports.income') }}"
                       class="btn btn-success rounded-pill px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <!-- ORDER -->

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100 report-card">

                <div class="card-body text-center p-4">

                    <div class="icon-circle bg-primary-subtle text-primary mb-3">

                        <i class="bi bi-cart-check-fill fs-2"></i>

                    </div>

                    <h5 class="fw-bold">

                        Laporan Order

                    </h5>

                    <p class="text-muted small">

                        Seluruh riwayat order yang pernah Anda kerjakan.

                    </p>

                    <a href="{{ route('mitra.reports.orders') }}"
                       class="btn btn-primary rounded-pill px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <!-- REVIEW -->

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100 report-card">

                <div class="card-body text-center p-4">

                    <div class="icon-circle bg-warning-subtle text-warning mb-3">

                        <i class="bi bi-star-fill fs-2"></i>

                    </div>

                    <h5 class="fw-bold">

                        Rating & Review

                    </h5>

                    <p class="text-muted small">

                        Lihat penilaian pelanggan beserta ulasan terhadap layanan Anda.

                    </p>

                    <a href="{{ route('mitra.reports.reviews') }}"
                       class="btn btn-warning rounded-pill px-4 text-white">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <!-- Pencairan -->

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100 report-card">

                <div class="card-body text-center p-4">

                    <div class="icon-circle bg-danger-subtle text-danger mb-3">

                        <i class="bi bi-wallet2 fs-2"></i>

                    </div>

                    <h5 class="fw-bold">

                        Pencairan Saldo

                    </h5>

                    <p class="text-muted small">

                        Riwayat pencairan saldo ke rekening atau e-wallet Anda.

                    </p>

                    <a href="{{ route('mitra.reports.withdrawals') }}"
                       class="btn btn-danger rounded-pill px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.report-card{

    transition:.3s;

}

.report-card:hover{

    transform:translateY(-8px);

    box-shadow:0 15px 35px rgba(0,0,0,.12)!important;

}

.icon-circle{

    width:85px;

    height:85px;

    margin:auto;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

}

</style>

@endsection