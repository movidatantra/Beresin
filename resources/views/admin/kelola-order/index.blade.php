@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Kelola Order</h3>
        <small class="text-muted">Seluruh transaksi pelanggan Beres.in</small>
    </div>
</div>

<!-- Baris Card Statistik Lama & Baru -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card shadow border-0">
            <div class="card-body">
                <small class="text-muted">Total Order</small>
                <h3 class="mb-0 fw-bold">{{ $totalOrder }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow border-0">
            <div class="card-body">
                <small class="text-muted">Hari Ini</small>
                <h3 class="mb-0 fw-bold">{{ $todayOrder }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow border-0">
            <div class="card-body">
                <small class="text-muted">Diproses</small>
                <h3 class="mb-0 fw-bold">{{ $processOrder }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow border-0">
            <div class="card-body">
                <small class="text-muted">Selesai</small>
                <h3 class="mb-0 fw-bold">{{ $completedOrder }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow border-0">
            <div class="card-body">
                <small class="text-muted">Dibatalkan</small>
                <h3 class="mb-0 fw-bold">{{ $cancelOrder }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Card Statistik Pendapatan Tambahan (Ikut Filter) -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow border-0 bg-light">
            <div class="card-body">
                <small class="text-muted">Total Pendapatan Mitra</small>
                <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($totalMitraIncome ?? 0, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow border-0 bg-light">
            <div class="card-body">
                <small class="text-muted">Total Pendapatan Admin</small>
                <h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($totalAdminIncome ?? 0, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow rounded-4 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders') }}">
            <div class="row g-3">
                <div class="col-lg-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari invoice, pelanggan, mitra" value="{{ request('search') }}">
                </div>
                
                <div class="col-lg-2">
                    <select name="status" class="form-select">
                        <option value="">Status Order</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="menuju_lokasi" {{ request('status') == 'menuju_lokasi' ? 'selected' : '' }}>Menuju Lokasi</option>
                        <option value="dikerjakan" {{ request('status') == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <select name="payment" class="form-select">
                        <option value="">Pembayaran</option>
                        <option value="belum_bayar" {{ request('payment') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="menunggu_verifikasi" {{ request('payment') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="lunas" {{ request('payment') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <select name="method" class="form-select">
                        <option value="">Metode</option>
                        <option value="COD" {{ request('method') == 'COD' ? 'selected' : '' }}>COD</option>
                        <option value="Transfer" {{ request('method') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="QRIS" {{ request('method') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <select name="sort" class="form-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Harga Terendah</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-lg-3">
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Mitra</th>
                        <th>Jadwal</th>
                        <th>Biaya Jasa</th>
                        <th>Biaya Admin</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark">{{ $order->invoice_number }}</span>
                        </td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>{{ $order->mitra->business_name ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}
                            <br>
                            <small class="text-muted">{{ $order->jam }}</small>
                        </td>
                        <td>
                            Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                        </td>
                        <td>
                            Rp {{ number_format($order->service_fee, 0, ',', '.') }}
                        </td>
                        <td class="fw-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @php
                                $statusColor = match($order->status) {
                                    'pending' => 'warning',
                                    'diterima', 'menuju_lokasi', 'dikerjakan' => 'info',
                                    'selesai' => 'success',
                                    'dibatalkan' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $paymentColor = match($order->payment_status) {
                                    'belum_bayar' => 'danger',
                                    'menunggu_verifikasi' => 'warning',
                                    'lunas' => 'success',
                                    'default' => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $paymentColor }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye-fill"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            Belum ada order.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection