@extends('layouts.mitra')

@section('content')

@php
    $avg = round($reviews->avg('rating') ?? 0,1);
    $total = $reviews->count();
@endphp

<div class="container-fluid">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                ⭐ Rating & Review
            </h3>

            <p class="text-muted mb-0">
                Lihat penilaian pelanggan terhadap layanan Anda.
            </p>

        </div>

    </div>

    <!-- SUMMARY -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold text-warning">

                        {{ $avg }}

                    </h1>

                    <div class="mb-2">

                        @for($i=1;$i<=5;$i++)

                            @if($i<=round($avg))

                                <i class="bi bi-star-fill text-warning"></i>

                            @else

                                <i class="bi bi-star text-warning"></i>

                            @endif

                        @endfor

                    </div>

                    <small class="text-muted">

                        Rating Rata-rata

                    </small>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold text-primary">

                        {{ $total }}

                    </h1>

                    <small class="text-muted">

                        Total Review

                    </small>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold text-success">

                        {{ $avg >=4 ? '😊' : ($avg>=3 ? '🙂' : '😕') }}

                    </h1>

                    <small class="text-muted">

                        Kepuasan Pelanggan

                    </small>

                </div>

            </div>

        </div>

    </div>

    <!-- LIST REVIEW -->

    @forelse($reviews as $review)

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div class="d-flex">

                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"

                             style="width:60px;height:60px;">

                            <i class="bi bi-person-fill fs-3"></i>

                        </div>

                        <div class="ms-3">

                            <h5 class="fw-bold mb-1">

                                {{ $review->user->name }}

                            </h5>

                            <small class="text-muted">

                                Order
                                #BRS{{ str_pad($review->order_id,6,'0',STR_PAD_LEFT) }}

                            </small>

                        </div>

                    </div>

                    <small class="text-muted">

                        {{ $review->created_at->translatedFormat('d F Y') }}

                    </small>

                </div>

                <div class="my-3">

                    @for($i=1;$i<=5;$i++)

                        @if($i <= $review->rating)

                            <i class="bi bi-star-fill text-warning fs-5"></i>

                        @else

                            <i class="bi bi-star text-warning fs-5"></i>

                        @endif

                    @endfor

                    <span class="fw-bold ms-2">

                        {{ $review->rating }}/5

                    </span>

                </div>

                <div class="bg-light rounded-4 p-3">

                    "{{ $review->review }}"

                </div>

            </div>

        </div>

    @empty

        <div class="card border-0 shadow rounded-4">

            <div class="card-body text-center py-5">

                <i class="bi bi-chat-square-text display-1 text-secondary"></i>

                <h4 class="mt-3">

                    Belum Ada Review

                </h4>

                <p class="text-muted">

                    Review dari pelanggan akan muncul di sini.

                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection