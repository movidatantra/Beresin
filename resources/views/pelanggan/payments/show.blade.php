@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body p-4">

                    <a href="/my-orders" class="text-decoration-none">
                        ← Kembali
                    </a>

                    <h3 class="fw-bold mt-3">
                        Pembayaran Pesanan
                    </h3>

                    <hr>

                    {{-- Status --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Bayar Sebelum
                            </h5>

                            <span class="text-muted">

                                @if($order->payment && $order->payment->expiry_time)

                                    {{ \Carbon\Carbon::parse($order->payment->expiry_time)->translatedFormat('d F Y, H:i') }} WIB

                                @else

                                    Menunggu pembuatan Virtual Account

                                @endif

                            </span>

                        </div>

                       <div>

    @php
        $status = $order->payment->transaction_status ?? 'pending';
    @endphp

    @switch($status)

        @case('settlement')
        @case('capture')

            <span class="badge bg-success fs-6">
                ✅ Lunas
            </span>

        @break

        @case('pending')

            <span class="badge bg-warning text-dark fs-6">
                ⏳ Menunggu Pembayaran
            </span>

        @break

        @case('expire')
        @case('cancel')
        @case('deny')

            <span class="badge bg-danger fs-6">
                ❌ Pembayaran Gagal
            </span>

        @break

        @default

            <span class="badge bg-secondary fs-6">
                {{ ucfirst($status) }}
            </span>

    @endswitch

</div>

                    </div>

                    <hr>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="mb-4">

                        <small class="text-muted">
                            Metode Pembayaran
                        </small>

                        <h5 class="fw-bold mt-2">

                            @if($order->payment && $order->payment->bank)

                                {{ strtoupper($order->payment->bank) }}
                                Virtual Account

                            @elseif($order->payment && $order->payment->payment_type)

                                {{ strtoupper($order->payment->payment_type) }}

                            @else

                                Belum dipilih

                            @endif

                        </h5>

                    </div>

                    <hr>

                    {{-- NOMOR VA --}}
                    <div class="mb-4">

                        <small class="text-muted">

                            Nomor Virtual Account

                        </small>

                        <div class="d-flex justify-content-between align-items-center">

                            <h3 class="fw-bold mb-0">

                                {{ $order->payment->va_number ?? '-' }}

                            </h3>

                            @if(!empty($order->payment->va_number))

                                <button
                                    class="btn btn-outline-success btn-sm"
                                    onclick="copyVA()">

                                    Salin

                                </button>

                            @endif

                        </div>

                    </div>

                    <hr>

                    {{-- TOTAL --}}
                    <div class="mb-4">

                        <small class="text-muted">

                            Total Tagihan

                        </small>

                        <h2 class="fw-bold text-primary">

                            Rp {{ number_format($order->total_price,0,',','.') }}

                        </h2>

                    </div>

                    <div class="alert alert-light border">

                        <strong>Penting</strong>

                        <ul class="mb-0 mt-2">

                            <li>
                                Transfer hanya ke nomor Virtual Account di atas.
                            </li>

                            <li>
                                Pesanan akan diteruskan ke mitra setelah pembayaran berhasil diverifikasi.
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@if(!empty($order->payment->va_number))

<script>

function copyVA(){

    navigator.clipboard.writeText(
        "{{ $order->payment->va_number }}"
    );

    alert("Nomor Virtual Account berhasil disalin.");

}

</script>

@endif

@endsection