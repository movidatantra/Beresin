@extends('layouts.admin')

@section('content')

<!-- Header Section -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Detail Mitra</h3>
        <p class="text-muted small mb-0">Informasi profil, lokasi, layanan, dan performa lengkap mitra Beres.in</p>
    </div>
    <a href="{{ route('admin.kelola-pengguna.mitra') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 transition-all d-inline-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-arrow-left fs-5"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- ================= BARIS ATAS (PROFIL, MAPS vs STATISTIK, ACTIONS) ================= -->
<div class="row">
    <!-- Kolom Kiri: Profil & Maps -->
    <div class="col-lg-8 mb-4">
        <!-- Card Profil Utama -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        @if($mitra->photo)
                            <img src="{{ asset('uploads/profile/'.$mitra->photo) }}"
                                 class="rounded-circle shadow-sm border border-3 border-white"
                                 width="120"
                                 height="120"
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm border border-3 border-white" style="width: 120px; height: 120px;">
                                <i class="bi bi-person-fill text-secondary" style="font-size: 60px;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9 text-center text-md-start">
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                            <h4 class="fw-bold mb-0 text-dark">{{ $mitra->name }}</h4>
                            
                            @if($mitra->verification_status == 'verified')
                                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-pill small d-inline-flex align-items-center gap-1">
                                    <span class="p-1 bg-success rounded-circle"></span> Verified
                                </span>
                            @elseif($mitra->verification_status == 'pending')
                                <span class="badge bg-warning-subtle text-warning-emphasis px-2.5 py-1.5 rounded-pill small d-inline-flex align-items-center gap-1">
                                    <span class="p-1 bg-warning rounded-circle"></span> Pending
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded-pill small d-inline-flex align-items-center gap-1">
                                    <span class="p-1 bg-danger rounded-circle"></span> Rejected
                                </span>
                            @endif

                            @if($mitra->is_online)
                                <span class="badge bg-success px-2.5 py-1.5 rounded-pill small">Online</span>
                            @else
                                <span class="badge bg-secondary px-2.5 py-1.5 rounded-pill small">Offline</span>
                            @endif
                        </div>
                        <p class="text-muted mb-0 fs-5"><i class="bi bi-building me-1"></i> {{ $mitra->business_name }}</p>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <!-- Informasi Profil Grid -->
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block mb-1">Kontak Resmi</small>
                            <span class="d-block text-dark fw-semibold mb-2"><i class="bi bi-envelope text-primary me-2"></i>{{ $mitra->email }}</span>
                            <span class="d-block text-dark fw-semibold"><i class="bi bi-telephone text-primary me-2"></i>{{ $mitra->phone }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted d-block mb-1">Legalitas & Spesialisasi</small>
                            <span class="d-block text-dark fw-semibold mb-2"><i class="bi bi-card-heading text-primary me-2"></i>NIK: {{ $mitra->nik }}</span>
                            <span class="d-block text-dark fw-semibold"><i class="bi bi-tools text-primary me-2"></i>{{ $mitra->specialization }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1">Alamat Operasional</small>
                            <span class="text-dark fw-semibold"><i class="bi bi-geo-alt text-danger me-2"></i>{{ $mitra->address }}</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <small class="text-muted d-block mb-1">Pengalaman</small>
                            <span class="text-dark fw-bold fs-5">{{ $mitra->experience }}</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <small class="text-muted d-block mb-1">Jam Operasional</small>
                            <span class="text-dark fw-bold fs-6">{{ $mitra->open_time }} - {{ $mitra->close_time }}</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <small class="text-muted d-block mb-1">Hari Libur</small>
                            <span class="text-danger fw-bold fs-6">{{ $mitra->holiday ?? 'Tidak ada' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lokasi Maps -->
        @if($mitra->latitude && $mitra->longitude)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>Lokasi Operasional
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                        <iframe style="border:0"
                                loading="lazy"
                                allowfullscreen
                                src="https://maps.google.com/maps?q={{ $mitra->latitude }},{{ $mitra->longitude }}&z=15&output=embed">
                        </iframe>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Kolom Kanan: Statistik & Tindakan Admin -->
    <div class="col-lg-4 mb-4">
        <!-- Header Statistik -->
        <h5 class="fw-bold mb-3 text-dark d-flex align-items-center">
            <i class="bi bi-graph-up-arrow text-primary me-2"></i>
            Performa & Statistik
        </h5>
        
        <!-- Grid Statistik Box -->
        <div class="row g-3 mb-4">
            <!-- Total Order -->
            <div class="col-6 col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-3.5 d-flex align-items-center">
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 me-3">
                            <i class="bi bi-cart-check fs-3 d-flex"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Total Order</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalOrder }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col-6 col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-3.5 d-flex align-items-center">
                        <div class="p-3 bg-success-subtle text-success rounded-4 me-3">
                            <i class="bi bi-check-circle fs-3 d-flex"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Selesai</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $completedOrder }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-6 col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-3.5 d-flex align-items-center">
                        <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-4 me-3">
                            <i class="bi bi-clock-history fs-3 d-flex"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Pending</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $pendingOrder }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 transition-hover">
                    <div class="card-body p-3.5 d-flex align-items-center">
                        <div class="p-3 bg-danger-subtle text-danger rounded-4 me-3">
                            <i class="bi bi-wallet2 fs-3 d-flex"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Total Pendapatan</span>
                            <h4 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncome,0,',','.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating & Ulasan -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 transition-hover">
                    <div class="card-body p-3.5 d-flex align-items-center">
                        <div class="p-3 bg-warning-subtle text-warning rounded-4 me-3">
                            <i class="bi bi-star-fill fs-3 d-flex text-warning"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Rating Rata-rata</span>
                            <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-1">
                                {{ number_format($averageRating,1) }}
                                <span class="fs-6 text-muted fw-normal">({{ $totalReview }} Ulasan)</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol WhatsApp -->
        @php
            $wa = $mitra->phone ? preg_replace('/^0/', '62', $mitra->phone) : null;
        @endphp

        @if($wa)
            <div class="d-grid gap-2 mb-3">
                <a href="https://wa.me/{{ $wa }}"
                   target="_blank"
                   class="btn btn-success py-3 rounded-4 shadow-sm fw-bold d-flex align-items-center justify-content-center gap-2 hover-zoom">
                    <i class="bi bi-whatsapp fs-5"></i>
                    Hubungi Mitra via WhatsApp
                </a>
            </div>
        @endif

        <!-- Media Sosial -->
        @if($mitra->instagram_url || $mitra->facebook_url || $mitra->tiktok_url)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Media Sosial Usaha</h6>
                    <div class="d-flex flex-column gap-2">
                        @if($mitra->instagram_url)
                            <a href="{{ $mitra->instagram_url }}" target="_blank" class="btn btn-outline-danger w-100 py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2 transition-all">
                                <i class="bi bi-instagram fs-5"></i> <span>Instagram</span>
                            </a>
                        @endif

                        @if($mitra->facebook_url)
                            <a href="{{ $mitra->facebook_url }}" target="_blank" class="btn btn-outline-primary w-100 py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2 transition-all">
                                <i class="bi bi-facebook fs-5"></i> <span>Facebook</span>
                            </a>
                        @endif

                        @if($mitra->tiktok_url)
                            <a href="{{ $mitra->tiktok_url }}" target="_blank" class="btn btn-outline-dark w-100 py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2 transition-all">
                                <i class="bi bi-tiktok fs-5"></i> <span>TikTok</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Tombol Manajemen Status (Suspend / Aktifkan) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <h6 class="fw-bold text-dark mb-3">Tindakan Admin</h6>
                @if($mitra->status=='active')
                    <form action="{{ route('admin.kelola-pengguna.mitra.suspend',$mitra->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100 py-3 rounded-3 shadow-sm fw-bold d-flex align-items-center justify-content-center gap-2 transition-all">
                            <i class="bi bi-person-x-fill fs-5"></i>
                            Suspend Akun Mitra
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.kelola-pengguna.mitra.activate',$mitra->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100 py-3 rounded-3 shadow-sm fw-bold d-flex align-items-center justify-content-center gap-2 transition-all">
                            <i class="bi bi-person-check-fill fs-5"></i>
                            Aktifkan Akun Mitra
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div> <!-- Akhir Row Pembatas Atas -->


<!-- ================= BARIS BAWAH FULL-WIDTH (LAYANAN & RIWAYAT) ================= -->
<div class="row">
    <!-- Layanan Mitra (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-briefcase-fill text-primary me-2"></i>Layanan Ditawarkan
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4 rounded-start text-muted fw-bold small text-uppercase">Nama Layanan</th>
                                <th class="py-3 text-muted fw-bold small text-uppercase">Kategori</th>
                                <th class="py-3 px-4 rounded-end text-muted fw-bold small text-uppercase text-end">Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td class="py-3 px-4 fw-semibold text-dark">{{ $service->name }}</td>
                                    <td class="py-3"><span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-3">{{ $service->category }}</span></td>
                                    <td class="py-3 px-4 text-dark fw-bold text-end">Rp {{ number_format($service->price,0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                        Belum menyediakan layanan aktif.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Order (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-box-seam-fill text-primary me-2"></i>Riwayat Order
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Form Filter Order -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search_order" value="{{ request('search_order') }}" class="form-control" placeholder="Cari invoice atau pelanggan">
                    </div>
                    <div class="col-md-2">
                        <select name="status_order" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status_order') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diterima" {{ request('status_order') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="menuju_lokasi" {{ request('status_order') == 'menuju_lokasi' ? 'selected' : '' }}>Menuju Lokasi</option>
                            <option value="dikerjakan" {{ request('status_order') == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                            <option value="selesai" {{ request('status_order') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ request('status_order') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('admin.kelola-pengguna.mitra.show',$mitra->id) }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->invoice_number }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>
                                        @foreach($order->items as $item)
                                            <span class="badge bg-primary mb-1">{{ $item->service->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $order->jadwal }}<br>
                                        <small class="text-muted">{{ substr($order->jam,0,5) }}</small>
                                    </td>
                                    <td><span class="badge bg-info text-dark">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></td>
                                    <td>
                                        @if($order->payment_status=='lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                                    <td>
                                        <a href="{{ url('/orders/'.$order->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Belum ada order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pencairan Saldo (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">💰 Riwayat Pencairan Saldo</h5>
            </div>
            <div class="card-body p-4">
                <!-- Grid Resume Pencairan Atas -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 bg-success bg-opacity-10 rounded-3">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-success mb-1">{{ $withdrawals->where('status','berhasil')->count() }}</h3>
                                <small class="text-muted uppercase fw-semibold">Pencairan Berhasil</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-warning bg-opacity-10 rounded-3">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-warning mb-1">{{ $withdrawals->where('status','menunggu')->count() }}</h3>
                                <small class="text-muted uppercase fw-semibold">Menunggu Persetujuan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-primary bg-opacity-10 rounded-3">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-primary mb-1">Rp {{ number_format($withdrawals->sum('amount'),0,',','.') }}</h3>
                                <small class="text-muted uppercase fw-semibold">Total Dicairkan</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Filter Pencairan -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search_withdraw" value="{{ request('search_withdraw') }}" placeholder="Cari nomor pencairan">
                    </div>
                    <div class="col-md-2">
                        <select name="withdraw_status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('withdraw_status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="berhasil" {{ request('withdraw_status') == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                            <option value="ditolak" {{ request('withdraw_status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="withdraw_from" value="{{ request('withdraw_from') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="withdraw_to" value="{{ request('withdraw_to') }}" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('admin.kelola-pengguna.mitra.show',$mitra->id) }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $withdraw)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $withdraw->created_at->format('d M Y') }}</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($withdraw->amount,0,',','.') }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ strtoupper($withdraw->withdraw_type) }}</span></td>
                                    <td>
                                        <span class="fw-semibold">{{ $withdraw->withdraw_name }}</span><br>
                                        <small class="text-muted">{{ $withdraw->withdraw_number }}</small>
                                    </td>
                                    <td>
                                        @if($withdraw->status=='berhasil')
                                            <span class="badge bg-success">Berhasil</span>
                                        @elseif($withdraw->status=='menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pencairan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $withdrawals->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Pendukung Mitra (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-folder2-open text-primary me-2"></i>Dokumen Pendukung Mitra
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <!-- Foto KTP -->
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">📄 Foto KTP</h6>
                        @if($mitra->ktp_photo)
                            <div class="border rounded-4 p-3 bg-light text-center">
                                <img src="{{ asset('uploads/ktp/'.$mitra->ktp_photo) }}" class="img-fluid rounded shadow-sm" style="max-height:250px; cursor:pointer" data-bs-toggle="modal" data-bs-target="#ktpModal">
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">Foto KTP belum tersedia.</div>
                        @endif
                    </div>

                    <!-- Foto Tempat Usaha -->
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">🏪 Foto Tempat Usaha</h6>
                        @if($mitra->business_photo)
                            <div class="border rounded-4 p-3 bg-light text-center">
                                <img src="{{ asset('storage/'.$mitra->business_photo) }}" class="img-fluid rounded shadow-sm" style="max-height:250px; cursor:pointer" data-bs-toggle="modal" data-bs-target="#usahaModal">
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">Foto usaha belum tersedia.</div>
                        @endif
                    </div>
                </div>

                <!-- Portofolio Pekerjaan -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">🖼 Portofolio Pekerjaan</h6>
                    @php
                        $photos = $mitra->portfolio_photos;
                        if (is_string($photos)) { $photos = json_decode($photos, true); }
                        if (is_string($photos)) { $photos = json_decode($photos, true); }
                        $photos = is_array($photos) ? $photos : [];
                    @endphp

                    @if(count($photos))
                        <div class="row g-3">
                            @foreach($photos as $photo)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="position-relative overflow-hidden rounded-3 shadow-sm border">
                                        <img src="{{ asset('storage/'.$photo) }}" class="img-fluid portfolio-img" style="height:180px; width:100%; object-fit:cover; cursor:pointer" data-image="{{ asset('storage/'.$photo) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-secondary">Belum ada portofolio.</div>
                    @endif
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">📝 Deskripsi Pekerjaan</h6>
                    <div class="border rounded-4 p-4 bg-light text-dark">
                        @if($mitra->description)
                            {{ $mitra->description }}
                        @else
                            <span class="text-muted">Belum ada deskripsi pekerjaan.</span>
                        @endif
                    </div>
                </div>

                <!-- Garansi Layanan -->
                <div>
                    <h6 class="fw-bold mb-3">🛡 Garansi Layanan</h6>
                    @if($mitra->service_warranty)
                        <div class="alert alert-success d-inline-flex align-items-center gap-2 mb-0 w-100">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <span>Mitra memberikan garansi terhadap layanan yang dikerjakan.</span>
                        </div>
                    @else
                        <div class="alert alert-danger d-inline-flex align-items-center gap-2 mb-0 w-100">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                            <span>Mitra tidak memberikan garansi terhadap layanan.</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= INTERACTIVE MODALS ================= -->
<!-- Modal KTP -->
<div class="modal fade" id="ktpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Foto KTP Resmi</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-dark p-3 rounded-bottom">
                <img src="{{ asset('storage/'.$mitra->ktp_photo) }}" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Modal Tempat Usaha -->
<div class="modal fade" id="usahaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Foto Tempat Usaha</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-dark p-3 rounded-bottom">
                <img src="{{ asset('storage/'.$mitra->business_photo) }}" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Modal Portfolio Preview -->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Preview Portofolio</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-dark p-3 rounded-bottom">
                <img id="previewPortfolio" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow rounded-4 mt-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            <i class="bi bi-clock-history text-primary"></i>

            Aktivitas Mitra

        </h5>

    </div>

    <div class="card-body">

        <!-- Filter -->

        <!-- Filter -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <input
            type="text"
            class="form-control"
            name="search_activity"
            placeholder="Cari aktivitas..."
            value="{{ request('search_activity') }}">
    </div>

    <div class="col-md-2">
        <select name="activity_type" class="form-select">
            <option value="">Semua Jenis</option>
            <option value="register" {{ request('activity_type') == 'register' ? 'selected' : '' }}>Pendaftaran</option>
            <option value="verification" {{ request('activity_type') == 'verification' ? 'selected' : '' }}>Verifikasi</option>
            <option value="order" {{ request('activity_type') == 'order' ? 'selected' : '' }}>Order</option>
            <option value="review" {{ request('activity_type') == 'review' ? 'selected' : '' }}>Ulasan</option>
            <option value="withdraw" {{ request('activity_type') == 'withdraw' ? 'selected' : '' }}>Pencairan</option>
        </select>
    </div>

    <!-- Filter Kalender / Tanggal -->
    <div class="col-md-2">
        <input 
            type="date" 
            class="form-control" 
            name="activity_from" 
            value="{{ request('activity_from') }}"
            title="Dari Tanggal">
    </div>

    <div class="col-md-2">
        <input 
            type="date" 
            class="form-control" 
            name="activity_to" 
            value="{{ request('activity_to') }}"
            title="Sampai Tanggal">
    </div>

    <div class="col-md-1.5">
        <button class="btn btn-primary w-100">Filter</button>
    </div>

    <div class="col-md-1.5">
        <a href="{{ route('admin.kelola-pengguna.mitra.show', $mitra->id) }}" class="btn btn-secondary w-100">Reset</a>
    </div>
</form>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Waktu</th>

                        <th>Aktivitas</th>

                        <th>Jenis</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($activities as $activity)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $activity['time']->format('d M Y') }}

                            <br>

                            <small>

                                {{ $activity['time']->format('H:i') }}

                            </small>

                        </td>

                        <td>

                            <i class="bi {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>

                            {{ $activity['title'] }}

                        </td>

                        <td>

                            {{ ucfirst($activity['type']) }}

                        </td>

                        <td>
    <span class="badge bg-{{ $activity['color'] }}">
        {{ ucfirst($activity['status'] ?? '-') }}
    </span>
</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center py-5">

                            Belum ada aktivitas.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- Custom CSS Effects -->
<style>
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
    .transition-all:hover {
        transform: translateY(-1px);
    }
    .transition-hover {
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important;
    }
    .hover-zoom {
        transition: transform 0.2s ease-in-out;
    }
    .hover-zoom:hover {
        transform: scale(1.02);
    }
</style>

<!-- Script Modal Handling -->
<script>
    document.querySelectorAll('.portfolio-img').forEach(function(img){
        img.onclick = function(){
            document.getElementById('previewPortfolio').src = this.dataset.image;
            new bootstrap.Modal(document.getElementById('portfolioModal')).show();
        };
    });
</script>

@endsection