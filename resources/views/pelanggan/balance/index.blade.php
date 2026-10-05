@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            Saldo Saya
        </h3>

        <small class="text-muted">
            Kelola saldo dan lihat riwayat transaksi Anda
        </small>
    </div>


    {{-- CARD SALDO --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">
                        Saldo Beres.in
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">

                        Rp
                        {{ number_format(
                            $balance->balance,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                </div>

                <div
                    class="rounded-circle bg-primary bg-opacity-10
                           d-flex align-items-center justify-content-center"
                    style="width:60px;height:60px;"
                >

                    <i class="bi bi-wallet2 text-primary fs-3"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- RIWAYAT --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Riwayat Saldo
            </h5>


            @forelse($transactions as $transaction)

                <div class="d-flex justify-content-between
                            align-items-center py-3 border-bottom">

                    <div>

                        <div class="fw-semibold">

                            {{ ucfirst($transaction->type) }}

                        </div>

                        <small class="text-muted">

                            {{ $transaction->description ?? '-' }}

                        </small>

                        <br>

                        <small class="text-muted">

                            {{ $transaction->created_at->format('d M Y H:i') }}

                        </small>

                    </div>


                    <div class="text-end">

                        @if(in_array(
                            $transaction->type,
                            ['refund', 'topup']
                        ))

                            <div class="fw-bold text-success">

                                + Rp
                                {{ number_format(
                                    $transaction->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                        @else

                            <div class="fw-bold text-danger">

                                - Rp
                                {{ number_format(
                                    $transaction->amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                        @endif


                        <small class="text-muted">

                            Saldo:
                            Rp
                            {{ number_format(
                                $transaction->balance_after,
                                0,
                                ',',
                                '.'
                            ) }}

                        </small>

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-wallet2 fs-1 text-muted"></i>

                    <p class="text-muted mt-3 mb-0">

                        Belum ada transaksi saldo.

                    </p>

                </div>

            @endforelse


            <div class="mt-4">

                {{ $transactions
                    ->appends(request()->query())
                    ->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

@endsection