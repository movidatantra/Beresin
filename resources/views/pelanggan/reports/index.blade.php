@extends('layouts.pelanggan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-file-earmark-bar-graph-fill text-primary"></i>

                Laporan Customer

            </h2>

            <p class="text-muted">

                Kelola seluruh riwayat transaksi dan aktivitas Anda.

            </p>

        </div>

    </div>

    <div class="row">

        <!-- ORDER -->

        <div class="col-lg-4 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <div
                        class="rounded-circle bg-primary bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:90px;height:90px;">

                        <i class="bi bi-cart-check-fill text-primary"
                           style="font-size:42px"></i>

                    </div>

                    <h4 class="fw-bold">

                        Laporan Pesanan

                    </h4>

                    <p class="text-muted">

                        Lihat seluruh riwayat pemesanan jasa yang pernah dilakukan.

                    </p>

                    <a href="{{ route('customer.reports.orders') }}"
                       class="btn btn-primary rounded-pill px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <!-- PEMBAYARAN -->

        <div class="col-lg-4 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <div
                        class="rounded-circle bg-success bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:90px;height:90px;">

                        <i class="bi bi-credit-card-fill text-success"
                           style="font-size:42px"></i>

                    </div>

                    <h4 class="fw-bold">

                        Laporan Pembayaran

                    </h4>

                    <p class="text-muted">

                        Riwayat pembayaran seluruh transaksi layanan.

                    </p>

                    <a href="{{ route('customer.reports.payments') }}"
                       class="btn btn-success rounded-pill px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <!-- REVIEW -->

        <div class="col-lg-4 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-body text-center">

                    <div
                        class="rounded-circle bg-warning bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:90px;height:90px;">

                        <i class="bi bi-star-fill text-warning"
                           style="font-size:42px"></i>

                    </div>

                    <h4 class="fw-bold">

                        Rating & Review

                    </h4>

                    <p class="text-muted">

                        Seluruh ulasan dan penilaian yang pernah Anda berikan.

                    </p>

                    <a href="{{ route('customer.reports.reviews') }}"
                       class="btn btn-warning rounded-pill text-white px-4">

                        <i class="bi bi-arrow-right-circle"></i>

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection