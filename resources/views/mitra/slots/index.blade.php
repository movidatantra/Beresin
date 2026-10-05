@extends('layouts.mitra')

@section('content')

<style>

body{
    background:#f5f7fb;
}

.schedule-header{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

    border-radius:25px;

    color:white;

    overflow:hidden;

}

.schedule-header .card-body{

    padding:35px;

}

.stat-card{

    border:none;

    border-radius:20px;

    transition:.3s;

    box-shadow:0 8px 25px rgba(0,0,0,.06);

}

.stat-card:hover{

    transform:translateY(-5px);

}

.stat-icon{

    width:60px;

    height:60px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:25px;

    color:white;

}

.filter-btn{

    border-radius:50px;

    padding:8px 20px;

}

.order-card{

    border:none;

    border-radius:20px;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

}

.badge-status{

    font-size:13px;

    padding:10px 16px;

    border-radius:30px;

}

.time-text{

    font-size:28px;

    font-weight:bold;

    color:#2563eb;

}

.customer-box{

    background:#f8f9fa;

    border-radius:15px;

    padding:15px;

}

</style>

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="card schedule-header border-0 mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h2 class="fw-bold mb-2">

                        <i class="bi bi-calendar-check-fill"></i>

                        Jadwal Kerja Mitra

                    </h2>

                    <p class="mb-0">

                        Kelola semua pesanan pelanggan dalam satu halaman.

                    </p>

                    <small>

                        {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}

                    </small>

                </div>

                <div class="col-lg-4 text-end">

                    <i class="bi bi-calendar-week"
                       style="font-size:80px;opacity:.25"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-primary">

                            <i class="bi bi-calendar2-check"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">

                                Total Jadwal

                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $orders->count() }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-warning">

                            <i class="bi bi-hourglass-split"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">

                                Pending

                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $orders->where('status','pending')->count() }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-info">

                            <i class="bi bi-tools"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">

                                Sedang Dikerjakan

                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $orders->whereIn('status',['diterima','menuju_lokasi','dikerjakan'])->count() }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="stat-icon bg-success">

                            <i class="bi bi-check-circle"></i>

                        </div>

                        <div class="ms-3">

                            <small class="text-muted">

                                Selesai

                            </small>

                            <h3 class="fw-bold mb-0">

                                {{ $orders->where('status','selesai')->count() }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- FILTER --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <button class="btn btn-primary filter-btn">
    Semua
</button>

<button class="btn btn-outline-primary filter-btn">
    Pending
</button>

<button class="btn btn-outline-primary filter-btn">
    Diterima
</button>

<button class="btn btn-outline-primary filter-btn">
    Menuju Lokasi
</button>

<button class="btn btn-outline-primary filter-btn">
    Dikerjakan
</button>

<button class="btn btn-outline-primary filter-btn">
    Selesai
</button>

            </div>

        </div>

    </div>

   

    {{-- DAFTAR ORDER --}}
    <div class="row">
        @forelse($orders as $order)
        {{-- Tambahkan data-status pada parent untuk mempermudah filter JavaScript --}}
        <div class="col-lg-6 mb-4 order-item-container" data-status="{{ str_replace('_', ' ', strtolower($order->status)) }}">
            <div class="card order-card h-100">
                <div class="card-body p-4">
                    
                    {{-- HEADER CARD --}}
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="time-text">
                                <i class="bi bi-clock-history"></i>
                                {{ substr($order->jam,0,5) }}
                            </div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}
                            </small>
                        </div>
                        <div>
                            {{-- Pindah status ke satu standar badge agar JavaScript tidak error --}}
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning badge-status">Pending</span>
                                @break
                                @case('diterima')
                                    <span class="badge bg-primary badge-status">Diterima</span>
                                @break
                                @case('menuju_lokasi')
                                    <span class="badge bg-info badge-status">Menuju Lokasi</span>
                                @break
                                @case('dikerjakan')
                                    <span class="badge bg-secondary badge-status">Dikerjakan</span>
                                @break
                                @case('selesai')
                                    <span class="badge bg-success badge-status">Selesai</span>
                                @break
                                @case('ditolak')
                                    <span class="badge bg-danger badge-status">Ditolak</span>
                                @break
                            @endswitch
                        </div>
                    </div>
                    
                    <hr>
                    
                    {{-- LAYANAN --}}
                    <h5 class="fw-bold">
                        <i class="bi bi-tools text-primary"></i>
                        {{ $order->service?->name ?? 'Layanan tidak ditemukan' }}
                    </h5>
                    
                    {{-- PELANGGAN & HUBUNGI (Ala Pinhome) --}}
                    <div class="customer-box mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=2563eb&color=fff"
                                     class="rounded-circle" width="50" height="50">
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-0">{{ $order->user->name }}</h6>
                                    <small class="text-muted">Pelanggan</small>
                                </div>
                            </div>
                            {{-- Tombol Chat WhatsApp jika pesanan aktif --}}
                            @if(in_array($order->status, ['diterima', 'menuju_lokasi', 'dikerjakan']))
                                <a href="https://wa.me/{{ $order->user->phone ?? '' }}?text=Halo%20{{ urlencode($order->user->name) }},%20saya%20mitra%20yang%20akan%20mengerjakan%20pesanan%20Anda." 
                                   target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                    <i class="bi bi-whatsapp"></i> Chat
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        {{-- ALAMAT & NAVIGASI G-MAPS --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong>
                                    <i class="bi bi-geo-alt-fill text-danger"></i> Alamat
                                </strong>
                                @if(in_array($order->status, ['diterima', 'menuju_lokasi']))
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->address) }}" 
                                       target="_blank" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold">
                                        <i class="bi bi-signpost-2"></i> Petunjuk Jalan
                                    </a>
                                @endif
                            </div>
                            <p class="mb-0 text-secondary mt-1">{{ $order->address }}</p>
                        </div>
                        
                        @if($order->note)
                        <div class="mb-3">
                            <strong><i class="bi bi-chat-left-text text-success"></i> Catatan</strong>
                            <p class="mb-0 text-secondary mt-1">{{ $order->note }}</p>
                        </div>
                        @endif
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <strong><i class="bi bi-wallet2 text-primary"></i> Pembayaran</strong>
                                <div class="text-secondary">{{ ucfirst(str_replace('_',' ',$order->payment_method)) }}</div>
                            </div>
                            <div class="col-6">
                                <strong><i class="bi bi-cash-stack text-success"></i> Total Pendapatan</strong>
                                <div class="fw-bold text-dark">Rp {{ number_format($order->total_price,0,',','.') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    {{-- TOMBOL AKSI DENGAN FORM POST/PATCH (Lebih Aman) --}}
                    <form action="/orders/status/{{ $order->id }}" method="POST">
                        @csrf
                        @method('PATCH') {{-- Atau gunakan POST tergantung route Anda --}}
                        
                        @if($order->status == 'pending')
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="submit" name="status" value="ditolak" class="btn btn-outline-danger rounded-pill w-100">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" name="status" value="diterima" class="btn btn-primary rounded-pill w-100">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                </div>
                            </div>
                        
                        @elseif($order->status == 'diterima')
                            <button type="submit" name="status" value="menuju_lokasi" class="btn btn-info rounded-pill text-white w-100">
                                <i class="bi bi-geo-alt"></i> Mulai Menuju Lokasi Pelanggan
                            </button>
                        
                        @elseif($order->status == 'menuju_lokasi')
                            <button type="submit" name="status" value="dikerjakan" class="btn btn-secondary rounded-pill w-100">
                                <i class="bi bi-tools"></i> Saya Sudah Sampai & Mulai Kerja
                            </button>
                        
                        @elseif($order->status == 'dikerjakan')
                            <button type="submit" name="status" value="selesai" class="btn btn-success rounded-pill w-100">
                                <i class="bi bi-check2-all"></i> Pekerjaan Selesai
                            </button>
                        
                        @elseif($order->status == 'selesai')
                            <div class="alert alert-success text-center mb-0 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill"></i> Selesai dikerjakan
                            </div>
                        
                        @elseif($order->status == 'ditolak')
                            <div class="alert alert-danger text-center mb-0 py-2 rounded-pill">
                                <i class="bi bi-x-circle-fill"></i> Pesanan ditolak
                            </div>
                        @endif
                    </form>
                    
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body text-center py-5">
                    <i class="bi bi-calendar-x display-1 text-secondary"></i>
                    <h3 class="mt-3">Belum Ada Jadwal Hari Ini</h3>
                    <p class="text-muted">Pesanan pelanggan akan muncul otomatis di sini.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    // Perbaikan Filter Status berbasis data-status atribut agar lebih akurat & anti-error
    const buttons = document.querySelectorAll(".filter-btn");
    const cards = document.querySelectorAll(".order-item-container");

    buttons.forEach(btn => {
        btn.addEventListener("click", function(){
            buttons.forEach(b => {
                b.classList.remove("btn-primary");
                b.classList.add("btn-outline-primary");
            });

            this.classList.remove("btn-outline-primary");
            this.classList.add("btn-primary");

            let filter = this.innerText.trim().toLowerCase();

            cards.forEach(card => {
                let status = card.getAttribute("data-status");

                if(filter === "semua"){
                    card.style.display = "block";
                } else {
                    // Cek kecocokan teks filter dengan status item data-status
                    if(status === filter) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                }
            });
        });
    });
});
</script>
@endsection