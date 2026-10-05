@extends('layouts.pelanggan')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-star-fill text-warning"></i>

Laporan Rating & Review

</h2>

<p class="text-muted">

Riwayat seluruh rating dan review yang pernah Anda berikan.

</p>

</div>

<div>

<a href="{{ route('customer.reports.reviews.pdf',request()->query()) }}"
class="btn btn-danger rounded-pill">

<i class="bi bi-file-earmark-pdf-fill"></i>

Export PDF

</a>

<a href="{{ route('customer.reports.reviews.excel',request()->query()) }}"
class="btn btn-success rounded-pill">

<i class="bi bi-file-earmark-excel-fill"></i>

Export Excel

</a>

</div>

</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-5">

<label>Tanggal Awal</label>

<input
type="date"
name="start_date"
class="form-control"
value="{{ request('start_date') }}">

</div>

<div class="col-md-5">

<label>Tanggal Akhir</label>

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

    <!-- =========================
         TABEL REVIEW
    ========================= -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="fw-bold mb-0">

                <i class="bi bi-chat-left-text-fill text-primary"></i>

                Riwayat Rating & Review

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="5%">No</th>

                            <th width="12%">Tanggal</th>

                            <th width="20%">Mitra</th>

                            <th width="18%">Layanan</th>

                            <th width="15%">Rating</th>

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

                                {{ $review->created_at->format('d M Y') }}

                            </td>

                            <td>

                                {{ $review->mitra->business_name ?? $review->mitra->name ?? '-' }}

                            </td>

                            <td>

                                {{ $review->order->service->name ?? '-' }}

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

                            <td>

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

                            <td colspan="6">

                                <div class="text-center py-5">

                                    <i class="bi bi-chat-square-text fs-1 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Belum Ada Review

                                    </h5>

                                    <p class="text-muted">

                                        Review yang Anda berikan kepada mitra akan tampil di sini.

                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $reviews->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection