@extends('layouts.admin')

@section('title','Detail Refund')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                Detail Refund

            </h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Invoice</th>
                    <td>{{ $refund->order->invoice_number }}</td>
                </tr>

                <tr>
                    <th>Pelanggan</th>
                    <td>{{ $refund->complaint->user->name }}</td>
                </tr>

                <tr>
                    <th>Nominal Refund</th>
                    <td>
                        Rp {{ number_format($refund->amount,0,',','.') }}
                    </td>
                </tr>

                <tr>
                    <th>Metode Refund</th>
                    <td>
                        {{ strtoupper($refund->refund_method) }}
                    </td>
                </tr>

                <tr>
                    <th>Status Refund</th>

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

                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>{{ $refund->reason }}</td>
                </tr>

                <tr>
                    <th>Refund Key</th>
                    <td>{{ $refund->refund_key ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Diproses Oleh</th>
                    <td>

                        {{ optional($refund->admin)->name ?? '-' }}

                    </td>
                </tr>

                <tr>
                    <th>Waktu Refund</th>
                    <td>

                        {{ $refund->refunded_at ?? '-' }}

                    </td>
                </tr>

            </table>

            <div class="mt-4">

                <a href="{{ route('admin.refunds') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

                @if($refund->status=='pending')

                    <form
                        action="{{ route('admin.refunds.process',$refund->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        <button
                            class="btn btn-success"
                            onclick="return confirm('Yakin memproses refund ini?')">

                            Proses Refund

                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection