@extends('layouts.mitra')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <!-- HEADER -->

        <div class="mb-4">

            <h3 class="fw-bold">

                Riwayat Pekerjaan

            </h3>

            <p class="text-muted">

                Daftar pekerjaan yang telah selesai

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

                        <th>Alamat</th>

                        <th>Pembayaran</th>

                        <th>Status</th>

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

                        <td>

                            {{ $order->service?->name }}

                        </td>

                        <!-- JADWAL -->

                        <td>

                            {{ $order->jadwal }}

                        </td>

                        <!-- ALAMAT -->

                        <td>

                            {{ $order->address }}

                        </td>

                        <!-- PEMBAYARAN -->

                        <td>

                            @if($order->payment_status == 'lunas')

                                <span class="badge bg-success rounded-pill">

                                    Lunas

                                </span>

                            @else

                                <span class="badge bg-warning rounded-pill">

                                    Belum Lunas

                                </span>

                            @endif

                        </td>

                        <!-- STATUS -->

                        <td>

                            <span class="badge bg-primary rounded-pill">

                                Selesai

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-5 text-muted">

                            Belum ada riwayat pekerjaan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection