@extends('layouts.mitra')

@section('content')

<div class="container-fluid">


<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Pendapatan Mitra

        </h2>

        <p class="text-muted mb-0">

            Riwayat pemasukan dari pelanggan

        </p>

    </div>

    <a href="/pendapatan"
       class="btn btn-outline-primary">

        <i class="bi bi-arrow-clockwise"></i>

        Refresh

    </a>

</div>

<!-- FILTER -->

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-3">

                    <label class="form-label">

                        Tanggal Awal

                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="form-control">

                </div>

                <div class="col-md-3">

                    <label class="form-label">

                        Tanggal Akhir

                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="form-control">

                </div>

                <div class="col-md-3">

                    <label class="form-label">

                        Metode Pembayaran

                    </label>

                    <select
                        name="payment_method"
                        class="form-select">

                        <option value="all">

                            Semua

                        </option>

                        <option
                            value="cod"
                            {{ request('payment_method') == 'cod' ? 'selected' : '' }}>

                            COD

                        </option>

                        <option
                            value="midtrans"
                            {{ request('payment_method') == 'midtrans' ? 'selected' : '' }}>

                            Virtual Account

                        </option>

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        <i class="bi bi-funnel-fill"></i>

                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- CARD STATISTIK -->

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Pendapatan Hari Ini

                        </small>

                        <h3 class="fw-bold text-success mt-2">

                            Rp {{ number_format($hariIni ?? 0) }}

                        </h3>

                    </div>

                    <i class="bi bi-cash-stack fs-1 text-success"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Pendapatan Bulan Ini

                        </small>

                        <h3 class="fw-bold text-primary mt-2">

                            Rp {{ number_format($bulanIni ?? 0) }}

                        </h3>

                    </div>

                    <i class="bi bi-graph-up-arrow fs-1 text-primary"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Total Pendapatan

                        </small>

                        <h3 class="fw-bold text-dark mt-2">

                            Rp {{ number_format($pendapatan ?? 0) }}

                        </h3>

                    </div>

                    <i class="bi bi-wallet2 fs-1 text-dark"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- TRANSAKSI -->

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="fw-bold mb-0">

                Transaksi Pendapatan

            </h5>

            <span class="badge bg-success">

                {{ count($transaksi) }} Transaksi

            </span>

        </div>

        @forelse($transaksi as $trx)

        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">

            <div class="d-flex align-items-center">

                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">

                    <i class="bi bi-arrow-down-circle-fill text-success"></i>

                </div>

                <div>

                    <div class="fw-semibold">

                        Pendapatan dari

                        {{ $trx->user?->name ?? '-' }}

                    </div>

                    <small class="text-muted d-block">

                        {{ $trx->user?->name ?? '-' }}

                    </small>

                    <div class="mt-1">

                        @if($trx->payment_method == 'cod')

                            <span class="badge bg-secondary">

                                COD

                            </span>

                        @elseif($trx->payment_method == 'midtrans')

                            <span class="badge bg-primary">

                                Virtual Account

                            </span>

                        @endif

                        <span class="badge bg-success">

                            Lunas

                        </span>

                    </div>

                </div>

            </div>

            <div class="text-end">

                <div class="fw-bold text-success">
    +Rp {{ number_format($trx->total_price - 10000, 0, ',', '.') }}
</div>

                <small class="text-muted">

                    {{ $trx->created_at->format('d M Y') }}

                </small>

            </div>

        </div>

        @empty

        <div class="text-center py-5">

            <i class="bi bi-wallet2 fs-1 text-muted"></i>

            <p class="text-muted mt-3">

                Belum ada transaksi pendapatan

            </p>

        </div>

        @endforelse

    </div>

</div>


</div>

@endsection
