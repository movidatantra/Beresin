@extends('layouts.admin')

@section('content')

<div class="container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                Detail Pencairan Saldo
            </h4>
        </div>

        <div class="card-body">

            <div class="text-center mb-4">

                @if($withdrawal->status == 'success')

                    <i class="bi bi-check-circle-fill text-success"
                       style="font-size:70px;"></i>

                    <h3 class="text-success mt-3">
                        Pencairan Berhasil
                    </h3>

                @elseif($withdrawal->status == 'processing')

                    <i class="bi bi-hourglass-split text-warning"
                       style="font-size:70px;"></i>

                    <h3 class="text-warning mt-3">
                        Sedang Diproses
                    </h3>

                @elseif($withdrawal->status == 'rejected')

                    <i class="bi bi-x-circle-fill text-danger"
                       style="font-size:70px;"></i>

                    <h3 class="text-danger mt-3">
                        Pencairan Ditolak
                    </h3>

                @else

<i class="bi bi-clock-history text-warning"
   style="font-size:70px;"></i>

<h3 class="text-warning mt-3">

    Menunggu Persetujuan

</h3>

<p class="text-muted">

    Pengajuan pencairan belum diproses.

</p>

@endif

            </div>

            <table class="table table-bordered">

                <tr>
                    <th width="35%">Nama Mitra</th>
                    <td>{{ $withdrawal->user->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Nominal Pengajuan</th>
                    <td>
                        Rp {{ number_format($withdrawal->amount,0,',','.') }}
                    </td>
                </tr>

                <tr>
                    <th>Biaya Admin</th>
                    <td>
                        Rp 2.500
                    </td>
                </tr>

                <tr>
                    <th>Nominal Diterima</th>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($withdrawal->amount-2500,0,',','.') }}
                    </td>
                </tr>

                <tr>
                    <th>Metode</th>
                    <td>
                        {{ ucfirst($withdrawal->withdraw_type) }}
                    </td>
                </tr>

                <tr>
                    <th>Bank / E-Wallet</th>
                    <td>
                        {{ $withdrawal->bank_name }}
                    </td>
                </tr>

                <tr>
                    <th>Nomor Rekening</th>
                    <td>
                        {{ $withdrawal->bank_account }}
                    </td>
                </tr>

                <tr>
                    <th>Nama Pemilik</th>
                    <td>
                        {{ $withdrawal->account_holder }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @php

                            $badge = [
                                'pending'=>'warning',
                                'menunggu'=>'warning',
                                'processing'=>'info',
                                'success'=>'success',
                                'failed'=>'danger',
                                'rejected'=>'danger'
                            ];

                        @endphp

                        <span class="badge bg-{{ $badge[$withdrawal->status] ?? 'secondary' }}">
                            {{ ucfirst($withdrawal->status) }}
                        </span>

                    </td>
                </tr>

                <tr>
                    <th>Xendit ID</th>
                    <td>
                        {{ $withdrawal->xendit_id ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>
                        {{ $withdrawal->created_at->format('d F Y H:i') }}
                    </td>
                </tr>

                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>
                        {{ $withdrawal->updated_at->format('d F Y H:i') }}
                    </td>
                </tr>

                @if($withdrawal->note)

                <tr>

                    <th>Catatan</th>

                    <td>
                        {{ $withdrawal->note }}
                    </td>

                </tr>

                @endif

            </table>

            <div class="d-flex justify-content-between mt-4">

    <a href="{{ route('admin.withdrawals.index') }}"
       class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

    @if(in_array($withdrawal->status, ['pending','menunggu']))

        <div>

            <form action="{{ route('admin.withdrawals.reject',$withdrawal->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button
                    type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Yakin ingin menolak pencairan ini?')">

                    <i class="bi bi-x-circle"></i>
                    Tolak

                </button>

            </form>

            <form action="{{ route('admin.withdrawals.approve',$withdrawal->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button
                    type="submit"
                    class="btn btn-success"
                    onclick="return confirm('Yakin ingin mencairkan saldo ini?')">

                    <i class="bi bi-check-circle"></i>
                    Cairkan

                </button>

            </form>

        </div>

    @endif

</div>

        </div>

    </div>

</div>

@endsection