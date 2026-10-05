@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3 class="fw-bold">

Ulasan Pelanggan

</h3>

<small class="text-muted">

Monitoring kualitas layanan mitra

</small>

</div>

</div>
<div class="row text-center border rounded-3 bg-white shadow-sm py-3 mb-4">

<div class="col-md-3 border-end">

<small>Total Ulasan</small>

<h3 class="fw-bold text-primary">

{{ $totalReview }}

</h3>

</div>

<div class="col-md-3 border-end">

<small>Rating Platform</small>

<h3 class="fw-bold text-warning">

⭐ {{ $averageRating }}

</h3>

</div>

<div class="col-md-3 border-end">

<small>Rating 1-2</small>

<h3 class="fw-bold text-danger">

{{ $badReview }}

</h3>

</div>

<div class="col-md-3">

<small>Bintang 5</small>

<h3 class="fw-bold text-success">

{{ $fiveStar }}

</h3>

</div>

</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-3">

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Cari pelanggan, mitra, invoice..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <select
                        class="form-select"
                        name="rating">

                        <option value="">

                            Semua Rating

                        </option>

                        @for($i=5;$i>=1;$i--)

                            <option
                                value="{{ $i }}"
                                {{ request('rating')==$i?'selected':'' }}>

                                {{ $i }} Bintang

                            </option>

                        @endfor

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        class="form-select"
                        name="bad">

                        <option value="">

                            Semua Review

                        </option>

                        <option
                            value="1"
                            {{ request('bad')=='1'?'selected':'' }}>

                            Review Buruk

                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        class="form-control"
                        name="from"
                        value="{{ request('from') }}">

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        class="form-control"
                        name="to"
                        value="{{ request('to') }}">

                </div>

                <div class="col-md-1">

                    <button
                        class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

                <div class="col-md-3">

                    <select
                        class="form-select"
                        name="sort">

                        <option value="latest">

                            Terbaru

                        </option>

                        <option
                            value="oldest"
                            {{ request('sort')=='oldest'?'selected':'' }}>

                            Terlama

                        </option>

                    </select>

                </div>

                <div class="col-md-9">

                    <a
                        href="{{ route('admin.reviews') }}"
                        class="btn btn-secondary">

                        Reset Filter

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>
<div class="card shadow-sm border-0">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Order</th>

<th>Pelanggan</th>

<th>Mitra</th>

<th>Rating</th>

<th>Review</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($reviews as $review)

<tr>

<td>

{{ $reviews->firstItem()+$loop->index }}

</td>

<td>

{{ $review->order->invoice_number ?? '-' }}

</td>

<td>

{{ $review->user->name }}

</td>

<td>

{{ $review->mitra->business_name ?? $review->mitra->name }}

</td>

<td>

@for($i=1;$i<=5;$i++)

@if($i<=$review->rating)

<span class="text-warning">

★

</span>

@else

<span class="text-secondary">

☆

</span>

@endif

@endfor

</td>

<td width="350">

{{ Str::limit($review->review,80) }}

</td>

<td>

{{ $review->created_at->format('d M Y') }}

</td>

<td>

<a
href="{{ route('admin.reviews.show',$review->id) }}"
class="btn btn-primary btn-sm">

<i class="bi bi-eye-fill"></i>

Detail

</a>

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">

Belum ada ulasan.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-3">

{{ $reviews->links() }}

</div>

</div>

</div>

@endsection