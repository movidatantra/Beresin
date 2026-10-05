<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Pendapatan Mitra</title>

    <style>

        body{

            font-family: DejaVu Sans;

            font-size:12px;

        }

        h2{

            text-align:center;

            margin-bottom:0;

        }

        p{

            text-align:center;

            margin-top:5px;

            color:#666;

        }

        table{

            width:100%;

            border-collapse:collapse;

            margin-top:20px;

        }

        th{

            background:#2563eb;

            color:white;

            padding:8px;

            border:1px solid #ddd;

        }

        td{

            padding:8px;

            border:1px solid #ddd;

        }

        .right{

            text-align:right;

        }

        .summary{

            margin-top:20px;

            margin-bottom:20px;

        }

    </style>

</head>

<body>

<h2>

LAPORAN PENDAPATAN MITRA

</h2>

<p>

Tanggal Cetak :
{{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }} WIB

</p>

<div class="summary">

<b>Total Pendapatan :</b>

Rp {{ number_format($totalIncome,0,',','.') }}

<br>

<b>Total Order :</b>

{{ $totalOrder }}

<br>

<b>Order Selesai :</b>

{{ $completedOrder }}

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Layanan</th>

<th>Metode</th>

<th>Status</th>

<th>Total</th>

</tr>

</thead>

<tbody>

@foreach($orders as $no => $order)

<tr>

<td>

{{ $no+1 }}

</td>

<td>

{{ \Carbon\Carbon::parse($order->jadwal)->format('d-m-Y') }}

</td>

<td>

{{ $order->user->name ?? '-' }}

</td>

<td>

{{ $order->service->name ?? '-' }}

</td>

<td>

{{ $order->payment_method }}

</td>

<td>

{{ ucfirst($order->status) }}

</td>

<td class="right">

Rp {{ number_format($order->total_price,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>