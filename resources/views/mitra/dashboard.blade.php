@extends('layouts.mitra')

@section('content')
<style>
    .form-check-input{
        width:70px;
        height:35px;
        cursor:pointer;
    }

    .form-check-input:checked{
        background-color:#16a34a;
        border-color:#16a34a;
    }

    .form-check-input:not(:checked){
        background-color:#dc3545;
        border-color:#dc3545;
    }
</style>

<!-- =========================
     HEADER SELAMAT DATANG
========================= -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    Halo, {{ Auth::user()->name ?? 'Mitra' }} 👋               
                </h3>
                <p class="text-muted mb-0">
                    Kelola layanan dan pesanan pelanggan dengan mudah
                </p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <h6 class="fw-bold mb-0">
                        Mitra Beres.in
                    </h6>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width:55px;height:55px;">
                    <i class="bi bi-person-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================
     CARD DASHBOARD MITRA + LONCENG NOTIFIKASI
========================= -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Dashboard Mitra</h4>
                <p class="text-muted mb-0">Monitoring seluruh aktivitas layanan Beres.in</p>
            </div>

            <!-- LONCENG NOTIFIKASI (POSISI SEPERTI ADMIN) -->
            <div class="dropdown">
                <button
                    class="btn btn-light position-relative rounded-circle shadow-sm border d-flex align-items-center justify-content-center p-0"
                    style="width:50px; height:50px;"
                    type="button"
                    id="notificationBell"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-bell-fill fs-4 text-secondary"></i>
                    @if(isset($jumlahNotifikasi) && $jumlahNotifikasi > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $jumlahNotifikasi }}
                        </span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-end shadow p-0 border-0 rounded-4 mt-2" style="width:300px">
                    <div class="p-3 border-bottom text-center">
                        <strong class="text-dark">Notifikasi</strong>
                    </div>

                    <div class="list-group list-group-flush rounded-3" style="max-height: 350px; overflow-y: auto;">
                        @forelse($notifications as $notif)
                            <a href="{{ $notif['url'] ?? '#' }}"
                               class="list-group-item list-group-item-action py-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi {{ $notif['icon'] ?? 'bi-info-circle' }} text-{{ $notif['color'] ?? 'primary' }} fs-4 me-3"></i>
                                    <div>
                                        <strong>{{ $notif['title'] }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $notif['message'] }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted small">
                                Tidak ada notifikasi
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================
     STATUS MITRA
========================= -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="mt-3">
                <h2 class="fw-bold d-block mb-2">
                    Status Mitra
                </h2>
                <form action="/mitra/toggle-status" method="POST" id="statusForm">
                    @csrf
                    <div class="form-check form-switch fs-4">
                        <input class="form-check-input"
                               type="checkbox"
                               id="statusSwitch"
                               onchange="document.getElementById('statusForm').submit()"
                               {{ Auth::user()->is_online ? 'checked' : '' }}>
                    </div>
                </form>

                @if(Auth::user()->is_online)
                    <br>
                    <small class="text-success fw-bold">🟢 Buka</small>
                @else
                    <br>
                    <small class="text-danger fw-bold">🔴 Tutup</small>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- =========================
     STATISTIK PENDAPATAN
========================= -->
<div class="row g-4 mb-4">
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <small class="text-muted">Pendapatan Hari Ini</small>
                <h3 class="fw-bold text-success">Rp {{ number_format($pendapatanHariIni) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <small class="text-muted">Pendapatan Bulan Ini</small>
                <h3 class="fw-bold text-primary">Rp {{ number_format($pendapatanBulanIni) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <small class="text-muted">Total Saldo</small>
                {{-- <h3 class="fw-bold text-info">Rp {{ number_format($saldo) }}</h3> --}}
                <h3 class="fw-bold">

Rp {{ number_format($saldoTersedia,0,',','.') }}

</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <small class="text-muted">Menunggu Pembayaran</small>
                <h3 class="fw-bold text-warning">Rp {{ number_format($menungguPembayaran) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- =========================
     COUNTBOX PESANAN
========================= -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fw-bold">{{ $totalOrder }}</h2>
                        <p class="text-muted mb-0">Total Pesanan</p>
                    </div>
                    <div class="bg-primary text-white rounded-4 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                        <i class="bi bi-cart-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fw-bold">{{ $selesai }}</h2>
                        <p class="text-muted mb-0">Pesanan Selesai</p>
                    </div>
                    <div class="bg-success text-white rounded-4 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fw-bold">{{ $pending }}</h2>
                        <p class="text-muted mb-0">Menunggu</p>
                    </div>
                    <div class="bg-warning text-white rounded-4 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                        <i class="bi bi-clock-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fw-bold">{{ $diproses }}</h2>
                        <p class="text-muted mb-0">Diproses</p>
                    </div>
                    <div class="bg-info text-white rounded-4 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                        <i class="bi bi-tools fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fw-bold">{{ $dibatalkan }}</h2>
                        <p class="text-muted mb-0">Dibatalkan</p>
                    </div>
                    <div class="bg-danger text-white rounded-4 d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
                        <i class="bi bi-x-circle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================
     TABLE PESANAN TERBARU
========================= -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Pesanan Terbaru</h4>
                <p class="text-muted mb-0">Daftar pesanan terbaru pelanggan</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4">Lihat Semua</button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>
                            @foreach($order->items as $item)
                                <div class="mb-1">
                                    {{ $item->service->name }}
                                    <small class="text-muted">(x{{ $item->qty }})</small>
                                </div>
                            @endforeach
                        </td>
                        <td>{{ $order->jadwal }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning rounded-pill">Pending</span>
                            @elseif($order->status == 'diproses')
                                <span class="badge bg-primary rounded-pill">Diproses</span>
                            @elseif($order->status == 'selesai')
                                <span class="badge bg-success rounded-pill">Selesai</span>
                            @elseif($order->status == 'dibatalkan')
                                <span class="badge bg-danger rounded-pill">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('notificationBell').addEventListener('click', function(){
    fetch("{{ route('notifications.readAll') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            let badge = document.querySelector('.badge.bg-danger');
            if(badge){
                badge.remove();
            }
        }
    });
});
</script>

@endsection