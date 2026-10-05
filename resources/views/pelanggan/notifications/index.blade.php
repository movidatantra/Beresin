@extends('layouts.pelanggan')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-bell-fill text-primary"></i>

                Notifikasi

            </h2>

            <p class="text-muted">

                Seluruh aktivitas terbaru akun Anda.

            </p>

        </div>

    </div>

    @forelse($notifications as $notification)

    <div class="card border-0 shadow-sm rounded-4 mb-3">

        <div class="card-body">

            <div class="d-flex">

                <div class="me-3">

                    @if($notification->type=='order')

                        <div class="rounded-circle bg-primary bg-opacity-10
                                    d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-cart-check-fill
                                      text-primary fs-3"></i>

                        </div>

                    @elseif($notification->type=='payment')

                        <div class="rounded-circle bg-success bg-opacity-10
                                    d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-wallet2
                                      text-success fs-3"></i>

                        </div>

                    @elseif($notification->type=='review')

                        <div class="rounded-circle bg-warning bg-opacity-10
                                    d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-star-fill
                                      text-warning fs-3"></i>

                        </div>

                    @else

                        <div class="rounded-circle bg-secondary bg-opacity-10
                                    d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-bell-fill
                                      text-secondary fs-3"></i>

                        </div>

                    @endif

                </div>

                <div class="flex-grow-1">

                    <div class="d-flex justify-content-between">

                        <h5 class="fw-bold mb-1">

                            {{ $notification->title }}

                        </h5>

                        @if(!$notification->is_read)

                            <span class="badge bg-danger">

                                Baru

                            </span>

                        @endif

                    </div>

                    <p class="text-muted mb-2">

                        {{ $notification->message }}

                    </p>

                    <small class="text-secondary">

                        <i class="bi bi-clock"></i>

                        {{ $notification->created_at->diffForHumans() }}

                    </small>

                </div>

            </div>

        </div>

    </div>

    @empty

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body text-center py-5">

            <i class="bi bi-bell-slash fs-1 text-secondary"></i>

            <h4 class="mt-3">

                Belum Ada Notifikasi

            </h4>

            <p class="text-muted">

                Semua notifikasi aktivitas Anda akan muncul di sini.

            </p>

        </div>

    </div>

    @endforelse

    <div class="mt-4">

        {{ $notifications->links() }}

    </div>

</div>

@endsection