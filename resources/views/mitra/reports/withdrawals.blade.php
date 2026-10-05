@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-wallet2 text-success"></i>

                Laporan Pencairan Saldo

            </h2>

            <p class="text-muted">

                Riwayat seluruh pencairan saldo yang pernah Anda ajukan.

            </p>

        </div>

        <div>

            <a href="{{ route('mitra.reports.withdrawals.pdf', request()->query()) }}"
               class="btn btn-danger rounded-pill me-2">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>

            <a href="{{ route('mitra.reports.withdrawals.excel', request()->query()) }}"
               class="btn btn-success rounded-pill">

                <i class="bi bi-file-earmark-excel-fill"></i>

                Export Excel

            </a>

        </div>

    </div>

    <!-- FILTER -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-5">

                        <label class="fw-semibold">

                            Tanggal Awal

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ request('start_date') }}">

                    </div>

                    <div class="col-md-5">

                        <label class="fw-semibold">

                            Tanggal Akhir

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ request('end_date') }}">

                    </div>

                    <div class="col-md-2 d-grid">

                        <label>&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- CARD -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pencairan

                    </small>

                    <h3 class="fw-bold text-success">

                        Rp {{ number_format($totalWithdrawal,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Pengajuan

                    </small>

                    <h3 class="fw-bold text-primary">

                        {{ $totalRequest }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Approved

                    </small>

                    <h3 class="fw-bold text-success">

                        {{ $approved }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Pending

                    </small>

                    <h3 class="fw-bold text-warning">

                        {{ $pending }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- TABEL -->

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Jumlah</th>

                            <th>Metode</th>

                            <th>Rekening</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($withdrawals as $no => $withdraw)

<tr>

    <td>

        {{ $withdrawals->firstItem() + $no }}

    </td>

    <td>

        <div class="fw-semibold">

            {{ $withdraw->created_at->format('d M Y') }}

        </div>

        <small class="text-muted">

            {{ $withdraw->created_at->format('H:i') }}

        </small>

    </td>

    <td>

        <span class="fw-bold text-success">

            Rp {{ number_format($withdraw->amount,0,',','.') }}

        </span>

    </td>

    <td>

        @if($withdraw->withdraw_type == 'bank')

            <span class="badge bg-primary">

                Transfer Bank

            </span>

        @else

            <span class="badge bg-success">

                E-Wallet

            </span>

        @endif

    </td>

    <td>

        <div class="fw-semibold">

            {{ $withdraw->bank_name }}

        </div>

        <small class="text-muted">

            {{ $withdraw->account_number }}

        </small>

    </td>

    <td>

        @if($withdraw->status == 'pending')

            <span class="badge bg-warning text-dark">

                Pending

            </span>

        @elseif($withdraw->status == 'approved')

            <span class="badge bg-success">

                Approved

            </span>

        @elseif($withdraw->status == 'rejected')

            <span class="badge bg-danger">

                Rejected

            </span>

        @else

            <span class="badge bg-secondary">

                {{ ucfirst($withdraw->status) }}

            </span>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="6">

        <div class="text-center py-5">

            <i class="bi bi-wallet2 display-1 text-secondary"></i>

            <h5 class="mt-3">

                Belum Ada Riwayat Pencairan

            </h5>

            <p class="text-muted">

                Anda belum pernah melakukan pencairan saldo.

            </p>

        </div>

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">

    <small class="text-muted">

        Menampilkan

        {{ $withdrawals->firstItem() ?? 0 }}

        -

        {{ $withdrawals->lastItem() ?? 0 }}

        dari

        {{ $withdrawals->total() }}

        data

    </small>

    {{ $withdrawals->withQueryString()->links() }}

</div>

</div>

</div>

</div>

<style>

.card{

    border-radius:20px;

}

.table td{

    vertical-align:middle;

}

.table thead th{

    white-space:nowrap;

}

.badge{

    font-size:13px;

    padding:7px 12px;

    border-radius:20px;

}

</style>

@endsection