@extends('layouts.mitra')

@section('content')

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <!-- HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold">
                Kelola Order
            </h3>
            <p class="text-muted">
                Kelola pesanan pelanggan yang masuk
            </p>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="alert alert-success rounded-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Status Order</th>
                        <th>Metode Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <!-- PELANGGAN -->
                        <td>
                            <div class="fw-semibold">
                                {{ $order->user?->name }}
                            </div>
                            <small class="text-muted">
                                {{ $order->user?->phone }}
                            </small>
                        </td>

                        <!-- LAYANAN -->
                        <td width="25%">
                            @foreach($order->items as $item)
                            <div class="mb-2">
                                <strong>{{ $item->service->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    Qty {{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                                </small>
                            </div>
                            @endforeach
                        </td>

                        <!-- JADWAL -->
                        <td>
                            {{ $order->jadwal }}
                        </td>

                        <!-- STATUS ORDER -->
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-secondary">
                                    Menunggu Konfirmasi Mitra
                                </span>
                            @elseif($order->status == 'diterima')
                                <span class="badge bg-primary">
                                    Diterima
                                </span>
                            @elseif($order->status == 'menuju_lokasi')
                                <span class="badge bg-info">
                                    Menuju Lokasi
                                </span>
                            @elseif($order->status == 'dikerjakan')
                                <span class="badge bg-warning text-dark">
                                    Sedang Dikerjakan
                                </span>
                            @elseif($order->status == 'menunggu_konfirmasi')
                                <span class="badge bg-warning text-dark">
                                    Menunggu Konfirmasi Customer
                                </span>
                            @elseif($order->status == 'komplain')
                                <span class="badge bg-danger">
                                    Sedang Dikomplain
                                </span>
                            @elseif($order->status == 'selesai')
                                <span class="badge bg-success">
                                    Selesai
                                </span>
                            @elseif($order->status == 'dibatalkan')
                                <span class="badge bg-danger">
                                    Refund
                                </span>
                            @elseif($order->status == 'ditolak')
                                <span class="badge bg-danger">
                                    Pesanan Ditolak
                                </span>
                            @endif
                        </td>

                        <!-- METODE PEMBAYARAN -->
                        <td>
                            @if($order->payment_method == 'cod')
                                <span class="badge bg-secondary">COD</span>
                            @else
                                <span class="badge bg-primary">Virtual Account</span>
                            @endif
                        </td>

                        <!-- STATUS PEMBAYARAN -->
                        <td>
                            @if($order->status == 'komplain')
                                <span class="badge bg-warning rounded-pill">Dana Ditahan</span>
                            @elseif($order->payment_status == 'belum_bayar')
                                <span class="badge bg-danger rounded-pill">Belum Bayar</span>
                            @elseif($order->payment_status == 'menunggu_verifikasi')
                                <span class="badge bg-warning rounded-pill">Menunggu Verifikasi</span>
                            @elseif($order->payment_status == 'lunas')
                                <span class="badge bg-success rounded-pill">Lunas</span>
                            @elseif($order->payment_status == 'refund')
                                <span class="badge bg-info rounded-pill">Dana Direfund</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
                            @endif
                        </td>

                        <!-- KOLOM AKSI -->
                        <td>
                            @if($order->status == 'pending')
                                <div class="d-flex gap-2">
                                    <a href="/orders/status/{{ $order->id }}/diterima" class="btn btn-success btn-sm rounded-pill">Terima</a>
                                    <a href="/orders/status/{{ $order->id }}/ditolak" class="btn btn-danger btn-sm rounded-pill">Tolak</a>
                                </div>
                            @elseif($order->status == 'diterima')
                                <a href="/orders/status/{{ $order->id }}/menuju_lokasi" class="btn btn-primary btn-sm rounded-pill">Menuju Lokasi</a>
                            @elseif($order->status == 'menuju_lokasi')
                                <a href="/orders/status/{{ $order->id }}/dikerjakan" class="btn btn-warning btn-sm rounded-pill">Mulai Kerjakan</a>
                            @elseif($order->status == 'dikerjakan')
                                <a href="/orders/{{ $order->id }}/work-proof" class="btn btn-success btn-sm rounded-pill">Upload Bukti</a>
                            @elseif($order->status == 'menunggu_konfirmasi')
                                <a href="/orders/{{ $order->id }}/work-proof/detail" class="btn btn-info btn-sm rounded-pill text-white">Lihat Bukti</a>
                            @elseif($order->status == 'komplain')
                                <div class="d-grid gap-1">
                                    <a href="/orders/{{ $order->id }}/work-proof/detail" class="btn btn-info btn-sm rounded-pill text-white">Lihat Bukti</a>
                                    <a href="/mitra/complaints/{{ $order->id }}" class="btn btn-warning btn-sm rounded-pill text-dark">Lihat Komplain</a>
                                </div>
                            @elseif($order->status == 'selesai')
                                @if($order->payment_method == 'cod' && $order->payment_status != 'lunas')
                                    <a href="/payment-confirm/{{ $order->id }}" class="btn btn-success btn-sm rounded-pill mb-1">Konfirmasi Bayar</a>
                                @endif
                                <a href="/orders/{{ $order->id }}/work-proof/detail" class="btn btn-success btn-sm rounded-pill">Detail Pekerjaan</a>
                            @elseif($order->status == 'ditolak')
                                <span class="text-muted small">-</span>
                            @elseif($order->status == 'dibatalkan')
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada order masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection