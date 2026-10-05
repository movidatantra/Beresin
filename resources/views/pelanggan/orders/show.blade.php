@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Tombol Kembali -->
            <div class="mb-4">
                <a href="/my-orders" class="text-decoration-none text-secondary fw-semibold small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesanan Saya
                </a>
            </div>

            <!-- Card Utama Detail -->
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header Status -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center border-bottom pb-4 mb-4 gap-3">
                        <div>
                            <span class="text-muted small">Kode Pesanan</span>
                            <h4 class="fw-bold text-dark mb-0">BRS{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h4>
                        </div>
                        <div>

@switch($order->status)

    @case('pending')

        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">

            Menunggu Konfirmasi Mitra

        </span>

    @break

    @case('diterima')

        <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">

            Diterima

        </span>

    @break

    @case('menuju_lokasi')

        <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold">

            Menuju Lokasi

        </span>

    @break

    @case('dikerjakan')

        <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-semibold">

            Sedang Dikerjakan

        </span>

    @break

    @case('menunggu_konfirmasi')

        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">

            Menunggu Konfirmasi Anda

        </span>

    @break

    @case('selesai')

        <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">

            Pesanan Selesai

        </span>

    @break

    @case('dibatalkan')

        <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold">

            Dibatalkan

        </span>

    @break

    @default

        <span class="badge bg-secondary px-3 py-2 rounded-pill">

            {{ ucfirst($order->status) }}

        </span>

@endswitch

</div>
                    </div>

                    <!-- Informasi Mitra & Jadwal -->
                    <div class="row g-4 mb-4 border-bottom pb-4">
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-semibold mb-1">Nama Mitra</label>
                            <p class="fw-bold text-dark mb-0">{{ $order->mitra?->business_name ?? 'Mitra tidak ditemukan' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-semibold mb-1">Jadwal & Waktu Pelaksanaan</label>
                            <p class="fw-semibold text-dark mb-0">
                                📅 {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }} <br>
                                ⏰ Pukul {{ substr($order->jam, 0, 5) }} WIB
                            </p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-semibold mb-1">Alamat Pengerjaan</label>
                            <p class="text-dark mb-0 small">{{ $order->address }}</p>
                            @if($order->note)
                                <div class="bg-light p-2.5 rounded-3 mt-2 text-muted small">
                                    <strong>Catatan:</strong> {{ $order->note }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Rincian Layanan -->
                    <h6 class="fw-bold text-dark mb-3">Layanan yang Dipesan</h6>
                    <div class="mb-4">
                        @foreach($order->items as $item)
                        <div class="d-flex justify-content-between align-items-center py-2.5 border-bottom border-light">
                            <div>
                                <span class="fw-medium text-dark">{{ $item->service->name }}</span>
                                <br><small class="text-muted">Jumlah: {{ $item->qty }}x</small>
                            </div>
                            <span class="fw-bold text-dark">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Rincian Total Bayar -->
                    <div class="bg-light rounded-4 p-4 mb-4">
                        <div class="d-flex justify-content-between mb-2 small text-secondary">
                            <span>Subtotal Layanan</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small text-secondary">
                            <span>Biaya Layanan</span>
                            <span>Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fw-bold text-dark">Total Pembayaran</span>
                            <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <!-- Status Pembayaran & Metode -->
                   @php
    $payment = $order->payment;
    $paymentStatus = $payment->transaction_status ?? 'pending';
@endphp

<div class="card border-0 bg-light rounded-4 p-4 mb-4">

    <h5 class="fw-bold mb-3">
        💳 Informasi Pembayaran
    </h5>

    <div class="row">

        <div class="col-md-6 mb-3">

            <small class="text-muted">
                Status Pembayaran
            </small>
            <br>

            @if(in_array($paymentStatus,['settlement','capture']))

                <span class="badge bg-success mt-2">
                    Lunas
                </span>

            @elseif($paymentStatus=='pending')

                <span class="badge bg-warning text-dark mt-2">
                    Menunggu Pembayaran
                </span>

            @elseif(in_array($paymentStatus,['expire','cancel','deny']))

                <span class="badge bg-danger mt-2">
                    Pembayaran Gagal
                </span>

            @else

                <span class="badge bg-secondary mt-2">
                    {{ ucfirst($paymentStatus) }}
                </span>

            @endif

        </div>

        <div class="col-md-6 mb-3">

            <small class="text-muted">
                Metode Pembayaran
            </small>

            <div class="fw-bold mt-1">

                @if($payment && $payment->bank)

                    {{ strtoupper($payment->bank) }} Virtual Account

                @else

                    {{ strtoupper($payment->payment_type ?? 'ONLINE PAYMENT') }}

                @endif

            </div>

        </div>

        @if($payment && $payment->va_number)

        <div class="col-md-6 mb-3">

            <small class="text-muted">
                Nomor Virtual Account
            </small>

            <div class="fw-bold fs-5 mt-1">

                {{ $payment->va_number }}

            </div>

        </div>

        @endif

        @if($payment && $payment->expiry_time)

        <div class="col-md-6 mb-3">

            <small class="text-muted">
                Bayar Sebelum
            </small>

            <div class="fw-bold mt-1">

                {{ \Carbon\Carbon::parse($payment->expiry_time)->translatedFormat('d F Y H:i') }} WIB

            </div>

        </div>

        @endif

    </div>

</div>

</div>
@if($order->status == 'selesai')

    @if(!$order->review)

        <a href="{{ route('review.create',$order->id) }}"
           class="btn btn-warning w-100 mt-4">

            ⭐ Beri Rating & Ulasan

        </a>

    @else

        <div class="card shadow-sm border-0 rounded-4 mt-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    ⭐ Ulasan Anda
                </h5>

                <div class="mb-3">

                    @for($i=1;$i<=5;$i++)

                        @if($i <= $order->review->rating)

                            <i class="bi bi-star-fill text-warning"></i>

                        @else

                            <i class="bi bi-star text-warning"></i>

                        @endif

                    @endfor

                    <span class="fw-bold ms-2">
                        {{ $order->review->rating }}/5
                    </span>

                </div>

                <p class="mb-3">

                    {{ $order->review->review }}

                </p>

                <small class="text-muted">

                    {{ $order->review->created_at->translatedFormat('d F Y H:i') }}
                    WIB

                </small>

            </div>

        </div>

    @endif

@endif
                        
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>


@endsection