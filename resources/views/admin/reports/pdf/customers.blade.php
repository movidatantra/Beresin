<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Data Pelanggan</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#333;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        p{
            text-align:center;
            margin-top:0;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #000;
            padding:6px;
            font-size:11px;
        }

        th{
            background:#2563eb;
            color:white;
        }

        .center{
            text-align:center;
        }

        .right{
            text-align:right;
        }

        .summary{
            margin-bottom:20px;
        }

    </style>

</head>

<body>

<h2>

    LAPORAN DATA PELANGGAN BERES.IN

</h2>

<p>

    Dicetak pada :
    {{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }} WIB

</p>

<table class="summary">

<tr>

    <td width="40%">
        <strong>Total Pelanggan</strong>
    </td>

    <td>

        {{ $totalCustomer }}

    </td>

</tr>

<tr>

    <td>

        <strong>Pelanggan Aktif</strong>

    </td>

    <td>

        {{ $activeCustomer }}

    </td>

</tr>

<tr>

    <td>

        <strong>Total Booking</strong>

    </td>

    <td>

        {{ number_format($totalBooking) }}

    </td>

</tr>

<tr>

    <td>

        <strong>Total Transaksi</strong>

    </td>

    <td>

        Rp {{ number_format($totalTransaction,0,',','.') }}

    </td>

</tr>

</table>

<table>

<thead>

<tr>

    <th>No</th>

    <th>Nama</th>

    <th>Email</th>

    <th>No HP</th>

    <th>Total Booking</th>

    <th>Total Transaksi</th>

    <th>Status</th>

</tr>

</thead>

<tbody>

@forelse($customers as $no=>$customer)

@php

$booking = \App\Models\Order::where(
'user_id',
$customer->id
)->count();

$total = \App\Models\Order::where(
'user_id',
$customer->id
)
->where('payment_status','lunas')
->sum('total_price');

@endphp

<tr>

    <td class="center">

        {{ $no+1 }}

    </td>

    <td>

        {{ $customer->name }}

    </td>

    <td>

        {{ $customer->email }}

    </td>

    <td>

        {{ $customer->phone }}

    </td>

    <td class="center">

        {{ $booking }}

    </td>

    <td class="right">

        Rp {{ number_format($total,0,',','.') }}

    </td>

    <td class="center">

        @if($booking>0)

            Aktif

        @else

            Belum Pernah Order

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="center">

        Tidak ada data pelanggan.

    </td>

</tr>

@endforelse

</tbody>

</table>

<br><br>

<table style="border:none;width:100%;">

<tr style="border:none;">

<td style="border:none;"></td>

<td style="border:none;text-align:center;width:220px;">

Tegal,

{{ now()->timezone('Asia/Jakarta')->format('d F Y') }}

<br><br><br><br>

<b>Administrator Beres.in</b>

</td>

</tr>

</table>

</body>

</html>