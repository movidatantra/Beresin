<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Pendapatan</title>

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

        .subtitle{

            text-align:center;

            margin-bottom:20px;

        }

        table{

            width:100%;

            border-collapse:collapse;

        }

        th,td{

            border:1px solid #000;

            padding:8px;

            font-size:11px;

        }

        th{

            background:#2563eb;

            color:white;

        }

        .right{

            text-align:right;

        }

        .center{

            text-align:center;

        }

        .summary{

            margin-bottom:20px;

        }

    </style>

</head>

<body>

<h2>

    LAPORAN PENDAPATAN BERES.IN

</h2>

<div class="subtitle">

    Dicetak :

    {{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }}

    WIB

</div>

<table class="summary">

<tr>

    <td width="30%"><strong>Total Pendapatan</strong></td>

    <td>

        Rp {{ number_format($totalIncome,0,',','.') }}

    </td>

</tr>

<tr>

    <td><strong>Total Transaksi</strong></td>

    <td>

        {{ $orders->count() }}

    </td>

</tr>

</table>

<table>

<thead>

<tr>

    <th>No</th>

    <th>Tanggal</th>

    <th>Pelanggan</th>

    <th>Mitra</th>

    <th>Metode</th>

    <th>Status</th>

    <th>Total</th>

</tr>

</thead>

<tbody>

@foreach($orders as $no=>$order)

<tr>

    <td class="center">

        {{ $no+1 }}

    </td>

    <td>

        {{ \Carbon\Carbon::parse($order->jadwal)->format('d-m-Y') }}

    </td>

    <td>

        {{ $order->user->name ?? '-' }}

    </td>

    <td>

        {{ $order->mitra->business_name ?? '-' }}

    </td>

    <td class="center">

        {{ $order->payment_method }}

    </td>

    <td class="center">

        {{ ucfirst($order->status) }}

    </td>

    <td class="right">

        Rp {{ number_format($order->total_price,0,',','.') }}

    </td>

</tr>

@endforeach

</tbody>

<tfoot>

<tr>

    <th colspan="6" class="right">

        TOTAL

    </th>

    <th class="right">

        Rp {{ number_format($totalIncome,0,',','.') }}

    </th>

</tr>

</tfoot>

</table>

</body>

</html>