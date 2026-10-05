@extends('layouts.pelanggan')

@section('content')

<style>
body {
    background: #f4f7fb;
}

/* HEADER */
.page-header {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 25px;
    padding: 35px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
}

.page-header::before {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .08);
    right: -60px;
    top: -60px;
}

/* CARD */
.order-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    transition: .3s;
    overflow: hidden;
    margin-bottom: 24px;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, .10);
}

/* HEADER CARD */
.order-top {
    padding: 20px 25px;
    border-bottom: 1px solid #edf2f7;
}

/* BADGE */
.status-badge {
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 13px;
}

/* BODY */
.order-body {
    padding: 25px;
}

.info-icon {
    width: 36px;
    height: 36px;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* TOTAL */
.total-box {
    background: #f8fafc;
    border-radius: 15px;
    padding: 18px;
}

/* FOOTER */
.order-footer {
    border-top: 1px solid #edf2f7;
    padding: 20px 25px;
}

/* BUTTON */
.btn-detail,
.btn-cancel {
    border-radius: 50px;
    padding: 10px 25px;
    font-weight: 600;
}

/* STATUS TIMELINE */
.progress-order {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    gap: 8px;
    margin: 30px 0;
}

.progress-order::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 55px;
    right: 55px;
    height: 3px;
    background: #e5e7eb;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    flex: 1;
    min-width: 90px;
    text-align: center;
}

.step-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e5e7eb;
    color: #94a3b8;
    font-size: 15px;
    font-weight: bold;
}

.step.active .step-circle {
    background: #2563eb;
    color: white;
}

.step.finish .step-circle {
    background: #22c55e;
    color: white;
}

.step-title {
    margin-top: 8px;
    font-size: 11px;
    color: #6b7280;
    font-weight: 600;
}
</style>


<div class="container py-4">

    <!-- =========================================================
         HEADER
    ========================================================== -->
    <div class="page-header">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <h2 class="fw-bold mb-2">

                    <i class="bi bi-bag-check-fill me-2"></i>

                    Pesanan Saya

                </h2>

                <p class="mb-0 opacity-75">

                    Pantau seluruh proses layanan yang sedang berjalan
                    bersama mitra Beres.in.

                </p>

            </div>


            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <span class="badge bg-light text-primary rounded-pill px-4 py-3 fs-6">

                    {{ $orders->count() }} Pesanan

                </span>

            </div>

        </div>

    </div>


    @forelse($orders as $order)

    <!-- =========================================================
         ORDER CARD
    ========================================================== -->

    <div class="order-card">


        <!-- =====================================================
             HEADER CARD
        ====================================================== -->

        <div class="order-top d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>

                <h5 class="fw-bold mb-1">

                    {{ $order->mitra?->business_name ?? 'Mitra tidak ditemukan' }}

                </h5>

                <small class="text-muted">

                    Order #BRS{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}

                </small>

            </div>


            <!-- =================================================
                 STATUS PESANAN
            ================================================== -->

            <div>

                @if($order->payment_status === 'belum_bayar')

                    <span class="status-badge bg-warning text-dark">

                        <i class="bi bi-credit-card me-1"></i>

                        Menunggu Pembayaran

                    </span>


                @elseif($order->payment_status === 'gagal')

                    <span class="status-badge bg-danger text-white">

                        <i class="bi bi-x-circle-fill me-1"></i>

                        Pembayaran Gagal

                    </span>


                @else

                    @switch($order->status)

                        @case('pending')

                            <span class="status-badge bg-info text-white">

                                <i class="bi bi-hourglass-split me-1"></i>

                                Menunggu Konfirmasi Mitra

                            </span>

                        @break


                        @case('diterima')

                            <span class="status-badge bg-success text-white">

                                <i class="bi bi-check-circle-fill me-1"></i>

                                Mitra Menerima Pesanan

                            </span>

                        @break


                        @case('menuju_lokasi')

                            <span class="status-badge bg-primary text-white">

                                <i class="bi bi-truck me-1"></i>

                                Mitra Menuju Lokasi

                            </span>

                        @break


                        @case('dikerjakan')

                            <span class="status-badge bg-info text-white">

                                <i class="bi bi-tools me-1"></i>

                                Sedang Dikerjakan

                            </span>

                        @break


                        @case('menunggu_konfirmasi')

                            <span class="status-badge bg-warning text-dark">

                                <i class="bi bi-person-check me-1"></i>

                                Menunggu Konfirmasi Anda

                            </span>

                        @break


                        @case('komplain')

                            <span class="status-badge bg-danger text-white">

                                <i class="bi bi-exclamation-triangle-fill me-1"></i>

                                Komplain Diproses

                            </span>

                        @break


                        @case('selesai')

                            <span class="status-badge bg-success text-white">

                                <i class="bi bi-check-circle-fill me-1"></i>

                                Pesanan Selesai

                            </span>

                        @break


                        @case('dibatalkan')

                            <span class="status-badge bg-danger text-white">

                                <i class="bi bi-x-circle-fill me-1"></i>

                                Pesanan Dibatalkan

                            </span>

                        @break


                        @default

                            <span class="status-badge bg-secondary text-white">

                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}

                            </span>

                    @endswitch

                @endif

            </div>

        </div>


        <!-- =====================================================
             ALERT MENUNGGU PEMBAYARAN
        ====================================================== -->

        @if($order->payment_status === 'belum_bayar')

            <div class="px-4">

                <div class="alert alert-warning rounded-4 mt-4">

                    <h5 class="fw-bold mb-2">

                        <i class="bi bi-credit-card-fill me-2"></i>

                        Menunggu Pembayaran

                    </h5>

                    <p class="mb-0">

                        Pesanan Anda telah dibuat.

                        Silakan lakukan pembayaran agar
                        mitra dapat menerima pesanan Anda.

                    </p>

                </div>

            </div>

        @endif


        <!-- =====================================================
             BODY
        ====================================================== -->

        <div class="order-body">


            <!-- =================================================
                 JADWAL
            ================================================== -->

            <div class="row">

                <div class="col-md-6">

                    <div class="d-flex mb-3 align-items-center">

                        <div class="info-icon">

                            <i class="bi bi-calendar-event"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Jadwal
                            </small>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}

                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="d-flex mb-3 align-items-center">

                        <div class="info-icon">

                            <i class="bi bi-clock"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Jam
                            </small>

                            <div class="fw-semibold">

                                {{ substr($order->jam, 0, 5) }} WIB

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <hr>


            <!-- =================================================
                 LAYANAN
            ================================================== -->

            <h6 class="fw-bold mb-3">

                Layanan yang Dipesan

            </h6>


            @foreach($order->items as $item)

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <div class="fw-semibold">

                            {{ $item->service->name }}

                        </div>

                        <small class="text-muted">

                            Qty: {{ $item->qty }}

                        </small>

                    </div>


                    <div class="fw-bold text-primary">

                        Rp
                        {{ number_format(
                            $item->price * $item->qty,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                </div>

            @endforeach


            <hr>


            <!-- =================================================
                 TOTAL + STATUS PAYMENT
            ================================================== -->

            <div class="total-box">


                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Total Pesanan
                    </span>

                    <strong class="text-primary">

                        Rp
                        {{ number_format(
                            $order->total_price,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>


                <div class="d-flex justify-content-between align-items-center">

                    <span>
                        Status Pembayaran
                    </span>


                    {{-- =================================================
                         PENTING:
                         Gunakan orders.payment_status sebagai sumber utama
                    ================================================== --}}

                    @if($order->payment_status === 'lunas')

                        <span class="badge bg-success">

                            <i class="bi bi-check-circle-fill me-1"></i>

                            Pembayaran Berhasil

                        </span>


                    @elseif($order->payment_status === 'belum_bayar')

                        <span class="badge bg-warning text-dark">

                            <i class="bi bi-clock me-1"></i>

                            Menunggu Pembayaran

                        </span>


                    @elseif($order->payment_status === 'gagal')

                        <span class="badge bg-danger">

                            <i class="bi bi-x-circle-fill me-1"></i>

                            Pembayaran Gagal

                        </span>


                    @else

                        <span class="badge bg-secondary">

                            {{ ucfirst(
                                str_replace(
                                    '_',
                                    ' ',
                                    $order->payment_status
                                )
                            ) }}

                        </span>

                    @endif

                </div>

            </div>


            <!-- =================================================
                 INFO DANA DITAHAN
            ================================================== -->

            @if(
                $order->payment_status === 'lunas' &&
                $order->status !== 'selesai' &&
                $order->status !== 'dibatalkan'
            )

                <div class="alert alert-warning rounded-4 mt-3 mb-0">

                    <i class="bi bi-shield-lock-fill me-2"></i>

                    Pembayaran pelanggan telah berhasil diterima.

                    Dana disimpan sementara oleh
                    <b>Beres.in</b> dan akan diteruskan ke
                    saldo mitra setelah pekerjaan selesai
                    serta dikonfirmasi pelanggan, atau otomatis
                    setelah 3 hari apabila tidak ada komplain.

                </div>

            @endif


            <!-- =================================================
                 TIMELINE
            ================================================== -->

            <div class="progress-order">


                {{-- DIBUAT --}}

                <div class="step finish">

                    <div class="step-circle">

                        <i class="bi bi-bag-check"></i>

                    </div>

                    <div class="step-title">
                        Dibuat
                    </div>

                </div>


                {{-- PEMBAYARAN --}}

                <div class="step
                    {{ $order->payment_status === 'lunas'
                        ? 'finish'
                        : ($order->payment_status === 'belum_bayar'
                            ? 'active'
                            : '')
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-credit-card"></i>

                    </div>

                    <div class="step-title">
                        Pembayaran
                    </div>

                </div>


                {{-- DITERIMA --}}

                <div class="step
                    {{
                        in_array(
                            $order->status,
                            [
                                'diterima',
                                'menuju_lokasi',
                                'dikerjakan',
                                'menunggu_konfirmasi',
                                'komplain',
                                'selesai'
                            ]
                        )
                        ? 'finish'
                        : ''
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-hand-thumbs-up"></i>

                    </div>

                    <div class="step-title">
                        Diterima
                    </div>

                </div>


                {{-- MENUJU --}}

                <div class="step
                    {{
                        in_array(
                            $order->status,
                            [
                                'menuju_lokasi',
                                'dikerjakan',
                                'menunggu_konfirmasi',
                                'komplain',
                                'selesai'
                            ]
                        )
                        ? 'finish'
                        : ''
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-truck"></i>

                    </div>

                    <div class="step-title">
                        Menuju
                    </div>

                </div>


                {{-- DIKERJAKAN --}}

                <div class="step
                    {{
                        in_array(
                            $order->status,
                            [
                                'dikerjakan',
                                'menunggu_konfirmasi',
                                'komplain',
                                'selesai'
                            ]
                        )
                        ? 'finish'
                        : ''
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-tools"></i>

                    </div>

                    <div class="step-title">
                        Dikerjakan
                    </div>

                </div>


                {{-- KONFIRMASI --}}

                <div class="step
                    {{
                        in_array(
                            $order->status,
                            [
                                'menunggu_konfirmasi',
                                'komplain',
                                'selesai'
                            ]
                        )
                        ? 'finish'
                        : ''
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-person-check"></i>

                    </div>

                    <div class="step-title">
                        Konfirmasi
                    </div>

                </div>


                {{-- SELESAI --}}

                <div class="step
                    {{ $order->status === 'selesai'
                        ? 'finish'
                        : ''
                    }}">

                    <div class="step-circle">

                        <i class="bi bi-star-fill"></i>

                    </div>

                    <div class="step-title">
                        Selesai
                    </div>

                </div>

            </div>


      <!-- =================================================
     ORDER DIBATALKAN / KOMPLAIN / REFUND
================================================== -->

@if($order->status === 'dibatalkan')

    {{-- TRANSAKSI DIKOMPLAIN --}}
    @if($order->customer_confirmation === 'complain')

        <div class="alert alert-danger rounded-4 mt-3 mb-2">

            <div class="d-flex align-items-start">

                <div class="me-3">
                    <div
                        class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:45px;height:45px;"
                    >
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    </div>
                </div>

                <div>

                    <h6 class="fw-bold mb-1">
                        Transaksi Ini Telah Dikomplain
                    </h6>

                    <p class="mb-0">
                        Pesanan ini telah dibatalkan dan proses komplain
                        pelanggan telah disetujui oleh admin.
                    </p>

                </div>

            </div>

        </div>

        {{-- REFUND BERHASIL --}}
        @if(
            $order->refund &&
            $order->refund->status === 'success' &&
            $order->refund->refund_method === 'balance'
        )

            <div class="alert alert-success rounded-4 mt-2 mb-0">

                <div class="d-flex align-items-start">

                    <div class="me-3">
                        <div
                            class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:45px;height:45px;"
                        >
                            <i class="bi bi-wallet2 fs-5"></i>
                        </div>
                    </div>

                    <div>

                        <h6 class="fw-bold mb-1">
                            Dana Telah Dikembalikan
                        </h6>

                        <p class="mb-1">
                            Refund sebesar
                            <strong>
                                Rp {{ number_format($order->refund->amount, 0, ',', '.') }}
                            </strong>
                            telah dikembalikan ke saldo Beres.in kamu.
                        </p>

                        <small class="text-muted">
                            Saldo dapat digunakan untuk pembayaran pesanan berikutnya.
                        </small>

                    </div>

                </div>

            </div>

        @else

            {{-- KOMPLAIN SUDAH DISETUJUI, REFUND BELUM SELESAI --}}
            <div class="alert alert-warning rounded-4 mt-2 mb-0">

                <i class="bi bi-clock-history me-2"></i>

                Refund untuk transaksi ini sedang diproses.

            </div>

        @endif

    @else

        {{-- PEMBATALAN BIASA --}}
        <div class="alert alert-danger rounded-4 mt-3 mb-0">

            <i class="bi bi-x-circle-fill me-2"></i>

            Pesanan telah dibatalkan.

        </div>

    @endif

@endif


            <!-- =================================================
                 KONFIRMASI PENYELESAIAN
            ================================================== -->

            @if($order->status === 'menunggu_konfirmasi')

                <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light">

                    <div class="card-body">

                        <div class="d-flex align-items-start">

                            <div class="me-3">

                                <div
                                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;"
                                >

                                    <i class="bi bi-check2-circle fs-4"></i>

                                </div>

                            </div>


                            <div class="flex-grow-1">

                                <h5 class="fw-bold mb-2">

                                    Mitra telah menyelesaikan pekerjaan

                                </h5>


                                <p class="text-muted mb-3" style="font-size:13px;">

                                    Silakan periksa hasil pekerjaan.

                                    Jika pekerjaan sudah selesai sesuai
                                    harapan, tekan tombol
                                    <b>Konfirmasi Selesai</b>.

                                    Apabila terdapat kendala,
                                    silakan ajukan komplain.

                                </p>


                                <div
                                    class="alert alert-warning mb-3 py-2 px-3"
                                    style="font-size:12px;"
                                >

                                    <i class="bi bi-clock-history me-2"></i>

                                    Jika tidak ada konfirmasi selama
                                    <b>3 hari</b>, sistem akan otomatis
                                    menyelesaikan pesanan dan dana akan
                                    diteruskan ke saldo mitra.

                                </div>


                                <div class="d-flex flex-wrap gap-2">

                                    <form
                                        action="{{ route('orders.confirm', $order->id) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            class="btn btn-success rounded-pill px-4 btn-sm"
                                        >

                                            <i class="bi bi-check-circle-fill me-2"></i>

                                            Konfirmasi Selesai

                                        </button>

                                    </form>


                                    <a
                                        href="{{ route('complaint.create', $order->id) }}"
                                        class="btn btn-outline-danger rounded-pill btn-sm"
                                    >

                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                                        Ajukan Komplain

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endif


            <!-- =================================================
                 KOMPLAIN
            ================================================== -->

            @if($order->status === 'komplain')

                <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light">

                    <div class="card-body">

                        <div class="d-flex align-items-start">

                            <div class="me-3">

                                <div
                                    class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center"
                                    style="width:50px;height:50px;"
                                >

                                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>

                                </div>

                            </div>


                            <div class="flex-grow-1">

                                <h5 class="fw-bold mb-1">

                                    Komplain Sedang Diproses

                                </h5>


                                <p class="text-muted mb-3" style="font-size:13px;">

                                    Komplain Anda telah berhasil dikirim.

                                    Admin sedang meninjau laporan Anda.

                                </p>


                                <div
                                    class="alert alert-warning mb-0 py-2 px-3"
                                    style="font-size:12px;"
                                >

                                    <i class="bi bi-shield-lock-fill me-2"></i>

                                    Dana pembayaran masih ditahan oleh
                                    <strong>Beres.in</strong>
                                    sampai proses komplain selesai.

                                </div>


                                @if($order->complaint)

                                    <a
                                        href="{{ route(
                                            'complaint.show',
                                            $order->complaint->id
                                        ) }}"
                                        class="btn btn-outline-danger rounded-pill mt-3"
                                    >

                                        <i class="bi bi-file-earmark-text"></i>

                                        Lihat Detail Komplain

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endif

        </div>


        <!-- =====================================================
             FOOTER
        ====================================================== -->

        <div class="order-footer d-flex justify-content-end align-items-center gap-2 flex-wrap">


            <!-- DETAIL -->

            <a
                href="{{ route('pelanggan.orders.show', $order->id) }}"
                class="btn btn-outline-primary btn-detail"
            >

                <i class="bi bi-eye-fill me-2"></i>

                Detail Pesanan

            </a>


            <!-- =================================================
                 BELUM BAYAR
            ================================================== -->

            @if($order->payment_status === 'belum_bayar')

                <a
                    href="{{ route('payment.show', $order->id) }}"
                    class="btn btn-success rounded-pill px-4"
                >

                    <i class="bi bi-credit-card-fill me-1"></i>

                    Bayar Sekarang

                </a>


                <a
                    href="/orders/cancel/{{ $order->id }}"
                    class="btn btn-danger rounded-pill px-4"
                >

                    <i class="bi bi-x-circle me-1"></i>

                    Batalkan

                </a>


            <!-- =================================================
                 SUDAH LUNAS
            ================================================== -->

            @elseif($order->payment_status === 'lunas')

                @if($order->status === 'pending')

                    <span class="badge bg-info rounded-pill px-3 py-2">

                        <i class="bi bi-hourglass-split me-1"></i>

                        Menunggu Mitra menerima pesanan

                    </span>

                @elseif($order->status === 'diterima')

                    <span class="badge bg-success rounded-pill px-3 py-2">

                        <i class="bi bi-check-circle-fill me-1"></i>

                        Pesanan diterima mitra

                    </span>

                @elseif($order->status === 'menuju_lokasi')

                    <span class="badge bg-primary rounded-pill px-3 py-2">

                        <i class="bi bi-truck me-1"></i>

                        Mitra menuju lokasi

                    </span>

                @elseif($order->status === 'dikerjakan')

                    <span class="badge bg-info rounded-pill px-3 py-2">

                        <i class="bi bi-tools me-1"></i>

                        Sedang dikerjakan

                    </span>

                @elseif($order->status === 'menunggu_konfirmasi')

                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                        <i class="bi bi-person-check me-1"></i>

                        Menunggu konfirmasi Anda

                    </span>

                @elseif($order->status === 'selesai')

                    <span class="badge bg-success rounded-pill px-3 py-2">

                        <i class="bi bi-check-circle-fill me-1"></i>

                        Pesanan selesai

                    </span>

                @endif


            <!-- =================================================
                 PEMBAYARAN GAGAL
            ================================================== -->

            @elseif($order->payment_status === 'gagal')

                <span class="badge bg-danger rounded-pill px-3 py-2">

                    <i class="bi bi-x-circle-fill me-1"></i>

                    Pembayaran gagal

                </span>

            @endif

        </div>

    </div>

    @empty


    <!-- =========================================================
         KOSONG
    ========================================================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body text-center py-5">

            <i
                class="bi bi-bag-x"
                style="font-size:70px;color:#cbd5e1;"
            ></i>

            <h4 class="fw-bold mt-4">

                Belum Ada Pesanan

            </h4>

            <p class="text-muted">

                Yuk mulai pesan layanan terbaik di Beres.in.

            </p>

            <a
                href="/pelanggan"
                class="btn btn-primary rounded-pill px-4"
            >

                Cari Layanan

            </a>

        </div>

    </div>

    @endforelse

</div>

@endsection

