@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- ==============================
         HEADER
    =============================== -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-cash-stack text-success"></i>

                Laporan Pendapatan

            </h2>

            <p class="text-muted mb-0">

                Lihat, filter, dan cetak seluruh pendapatan yang telah Anda peroleh.

            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{ route('mitra.reports.income.pdf', request()->query()) }}"
               class="btn btn-danger rounded-pill me-2">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>

            <a href="{{ route('mitra.reports.income.excel', request()->query()) }}"
               class="btn btn-success rounded-pill">

                <i class="bi bi-file-earmark-excel-fill"></i>

                Export Excel

            </a>

        </div>

    </div>

    <!-- ==============================
         FILTER
    =============================== -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Awal

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control rounded-3"
                            value="{{ request('start_date') }}">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Akhir

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control rounded-3"
                            value="{{ request('end_date') }}">

                    </div>

                    <div class="col-md-4 mb-3">

                        <button class="btn btn-primary w-100 rounded-3">

                            <i class="bi bi-search"></i>

                            Terapkan Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ==============================
         STATISTIK
    =============================== -->

    <div class="row g-4 mb-4">

        <!-- TOTAL PENDAPATAN -->

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Pendapatan

                            </small>

                            <h3 class="fw-bold text-success mt-2">

                                Rp {{ number_format($totalIncome,0,',','.') }}

                            </h3>

                        </div>

                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-cash-stack text-success fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- TOTAL ORDER -->

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Order

                            </small>

                            <h3 class="fw-bold text-primary mt-2">

                                {{ $totalOrder }}

                            </h3>

                        </div>

                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-cart-check-fill text-primary fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ORDER SELESAI -->

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Order Selesai

                            </small>

                            <h3 class="fw-bold text-warning mt-2">

                                {{ $completedOrder }}

                            </h3>

                        </div>

                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-check-circle-fill text-warning fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ==============================
         TABEL
    =============================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="60">No</th>

                            <th>Tanggal</th>

                            <th>Pelanggan</th>

                            <th>Layanan</th>

                            <th>Metode</th>

                            <th>Status</th>

                            <th class="text-end">

                                Total

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($orders as $no => $order)

<tr>

    <td>

        {{ $orders->firstItem() + $no }}

    </td>

    <td>

        <div class="fw-semibold">

            {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}

        </div>

        <small class="text-muted">

            {{ $order->created_at->format('H:i') }} WIB

        </small>

    </td>

    <td>

        <div class="fw-semibold">

            {{ $order->user->name ?? '-' }}

        </div>

        <small class="text-muted">

            Pelanggan

        </small>

    </td>

    <td>

        <div class="fw-semibold">

            {{ $order->service->name ?? '-' }}

        </div>

    </td>

    <td>

        @switch($order->payment_method)

            @case('BANK_TRANSFER')

                <span class="badge bg-primary">

                    Transfer Bank

                </span>

                @break

            @case('QRIS')

                <span class="badge bg-success">

                    QRIS

                </span>

                @break

            @case('GOPAY')

                <span class="badge bg-info">

                    GoPay

                </span>

                @break

            @case('OVO')

                <span class="badge bg-warning text-dark">

                    OVO

                </span>

                @break

            @case('DANA')

                <span class="badge bg-primary">

                    DANA

                </span>

                @break

            @case('SHOPEEPAY')

                <span class="badge bg-danger">

                    ShopeePay

                </span>

                @break

            @default

                <span class="badge bg-secondary">

                    {{ $order->payment_method }}

                </span>

        @endswitch

    </td>

    <td>

        @switch($order->status)

            @case('pending')

                <span class="badge bg-warning text-dark">

                    Pending

                </span>

                @break

            @case('diterima')

                <span class="badge bg-info">

                    Diterima

                </span>

                @break

            @case('menuju_lokasi')

                <span class="badge bg-primary">

                    Menuju Lokasi

                </span>

                @break

            @case('dikerjakan')

                <span class="badge bg-secondary">

                    Dikerjakan

                </span>

                @break

            @case('selesai')

                <span class="badge bg-success">

                    Selesai

                </span>

                @break

            @case('dibatalkan')

                <span class="badge bg-danger">

                    Dibatalkan

                </span>

                @break

            @default

                <span class="badge bg-light text-dark">

                    {{ ucfirst($order->status) }}

                </span>

        @endswitch

    </td>

    <td class="text-end fw-bold text-success">

        Rp {{ number_format($order->total_price,0,',','.') }}

    </td>

</tr>

@empty

<tr>

    <td colspan="7">

        <div class="text-center py-5">

            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                 width="120"
                 class="mb-3">

            <h5 class="fw-bold">

                Belum Ada Data Pendapatan

            </h5>

            <p class="text-muted">

                Belum terdapat transaksi yang sesuai dengan filter yang dipilih.

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

        {{ $orders->firstItem() ?? 0 }}

        -

        {{ $orders->lastItem() ?? 0 }}

        dari

        {{ $orders->total() }}

        data

    </small>

    {{ $orders->withQueryString()->links() }}

</div>

</div>

</div>

</div>

@endsection
<style>

/* ===============================
   CARD
================================ */

.card{

    border-radius:20px;

    transition:.3s;

}

.card:hover{

    transform:translateY(-5px);

    box-shadow:0 15px 35px rgba(0,0,0,.08)!important;

}

/* ===============================
   BUTTON
================================ */

.btn{

    border-radius:12px;

    font-weight:600;

}

.btn-danger{

    box-shadow:0 8px 18px rgba(220,53,69,.25);

}

.btn-success{

    box-shadow:0 8px 18px rgba(25,135,84,.25);

}

.btn-primary{

    box-shadow:0 8px 18px rgba(13,110,253,.25);

}

/* ===============================
   TABLE
================================ */

.table{

    vertical-align:middle;

}

.table thead th{

    border:none;

    padding:16px;

    font-weight:700;

    white-space:nowrap;

}

.table tbody td{

    padding:18px 14px;

}

.table-hover tbody tr:hover{

    background:#f8fbff;

}

/* ===============================
   BADGE
================================ */

.badge{

    padding:8px 12px;

    border-radius:30px;

    font-size:12px;

    font-weight:600;

}

/* ===============================
   PAGINATION
================================ */

.pagination{

    margin-bottom:0;

}

.page-link{

    border-radius:10px!important;

    margin:0 3px;

    color:#2563eb;

}

.page-item.active .page-link{

    background:#2563eb;

    border-color:#2563eb;

}

/* ===============================
   MOBILE
================================ */

@media(max-width:768px){

    h2{

        font-size:22px;

    }

    .btn{

        width:100%;

        margin-bottom:10px;

    }

    .table{

        font-size:13px;

    }

}

</style>