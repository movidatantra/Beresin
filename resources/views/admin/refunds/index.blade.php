@extends('layouts.admin')

@section('title', 'Data Refund')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">
            Data Refund
        </h4>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="50">No</th>

                            <th>Invoice</th>

                            <th>Pelanggan</th>

                            <th>Nominal</th>

                            <th>Metode</th>

                            <th>Status</th>

                            <th width="220">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($refunds as $refund)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                {{ $refund->order->invoice_number }}

                            </td>

                            <td>

                                {{ $refund->complaint->user->name }}

                            </td>

                            <td>

                                Rp {{ number_format($refund->amount,0,',','.') }}

                            </td>

                            <td>

                                {{ strtoupper($refund->refund_method) }}

                            </td>

                            <td>

                                @if($refund->status=='pending')

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                @elseif($refund->status=='success')

                                    <span class="badge bg-success">

                                        Success

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Failed

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.refunds.show',$refund->id) }}"
                                   class="btn btn-info btn-sm">

                                    Detail

                                </a>

                                @if($refund->status=='pending')

                                    <form
                                        action="{{ route('admin.refunds.process',$refund->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Proses refund sekarang?')">

                                            Proses Refund

                                        </button>

                                    </form>

                                @elseif($refund->status=='success')

                                    <button
                                        class="btn btn-secondary btn-sm"
                                        disabled>

                                        Sudah Diproses

                                    </button>

                                @else

                                    <form
                                        action="{{ route('admin.refunds.process',$refund->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button
                                            class="btn btn-danger btn-sm">

                                            Coba Lagi

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center">

                                Belum ada data refund.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection