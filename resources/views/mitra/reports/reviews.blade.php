@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-star-fill text-warning"></i>

                Laporan Rating & Review

            </h2>

            <p class="text-muted">

                Lihat seluruh penilaian pelanggan terhadap layanan Anda.

            </p>

        </div>

        <div>

            <a href="{{ route('mitra.reports.reviews.pdf', request()->query()) }}"
               class="btn btn-danger rounded-pill me-2">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>

            <a href="{{ route('mitra.reports.reviews.excel', request()->query()) }}"
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

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Rating Rata-rata

                    </small>

                    <h2 class="fw-bold text-warning">

                        {{ number_format($averageRating,1) }}

                        <i class="bi bi-star-fill"></i>

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Review

                    </small>

                    <h2 class="fw-bold text-primary">

                        {{ $totalReview }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Rating 5 ⭐

                    </small>

                    <h2 class="fw-bold text-success">

                        {{ $rating5 }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- DETAIL RATING -->

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="alert alert-success">

                ⭐⭐⭐⭐☆

                <b>

                    {{ $rating4 }}

                </b>

            </div>

        </div>

        <div class="col-md-3">

            <div class="alert alert-info">

                ⭐⭐⭐☆☆

                <b>

                    {{ $rating3 }}

                </b>

            </div>

        </div>

        <div class="col-md-3">

            <div class="alert alert-warning">

                ⭐⭐☆☆☆

                <b>

                    {{ $rating2 }}

                </b>

            </div>

        </div>

        <div class="col-md-3">

            <div class="alert alert-danger">

                ⭐☆☆☆☆

                <b>

                    {{ $rating1 }}

                </b>

            </div>

        </div>

    </div>

    <!-- TABEL -->

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead class="table-warning">

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Pelanggan</th>

                            <th>Rating</th>

                            <th>Review</th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($reviews as $no => $review)

<tr>

    <td>

        {{ $reviews->firstItem() + $no }}

    </td>

    <td>

        <div class="fw-semibold">

            {{ $review->created_at->format('d M Y') }}

        </div>

        <small class="text-muted">

            {{ $review->created_at->format('H:i') }}

        </small>

    </td>

    <td>

        <div class="d-flex align-items-center">

            <div
                class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"
                style="width:45px;height:45px;">

                {{ strtoupper(substr($review->user->name ?? 'P',0,1)) }}

            </div>

            <div>

                <div class="fw-semibold">

                    {{ $review->user->name ?? '-' }}

                </div>

                <small class="text-muted">

                    Pelanggan

                </small>

            </div>

        </div>

    </td>

    <td>

        @for($i=1;$i<=5;$i++)

            @if($i <= $review->rating)

                <i class="bi bi-star-fill text-warning"></i>

            @else

                <i class="bi bi-star text-secondary"></i>

            @endif

        @endfor

        <br>

        <small class="text-muted">

            {{ $review->rating }}/5

        </small>

    </td>

    <td style="max-width:350px;">

        @if($review->review)

            {{ $review->review }}

        @else

            <span class="text-muted">

                Tidak ada komentar.

            </span>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="5">

        <div class="text-center py-5">

            <i class="bi bi-chat-square-heart display-1 text-secondary"></i>

            <h5 class="mt-3">

                Belum Ada Review

            </h5>

            <p class="text-muted">

                Belum ada pelanggan yang memberikan penilaian.

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

        {{ $reviews->firstItem() ?? 0 }}

        -

        {{ $reviews->lastItem() ?? 0 }}

        dari

        {{ $reviews->total() }}

        review

    </small>

    {{ $reviews->withQueryString()->links() }}

</div>

</div>

</div>

</div>

<style>

.card{

    border-radius:20px;

}

.table thead th{

    white-space:nowrap;

}

.table td{

    vertical-align:middle;

}

.alert{

    border-radius:15px;

    text-align:center;

    font-weight:600;

}

</style>

@endsection