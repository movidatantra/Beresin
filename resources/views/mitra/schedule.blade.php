@extends('layouts.mitra')

@section('content')

<div class="container">

    <h3 class="fw-bold mb-4">

        Jadwal Hari Ini

    </h3>

    @forelse($orders as $order)

    <div class="card shadow-sm mb-3">

        <div class="card-body">

            <h5>

                {{ substr($order->jam,0,5) }}

            </h5>

            <p>

                {{ $order->service->name }}

            </p>

            <p>

                Pelanggan :

                {{ $order->user->name }}

            </p>

            <span class="badge bg-primary">

                {{ ucfirst($order->status) }}

            </span>

        </div>

    </div>

    @empty

    <div class="alert alert-warning">

        Belum ada jadwal hari ini.

    </div>

    @endforelse

</div>

@endsection