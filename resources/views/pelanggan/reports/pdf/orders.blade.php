<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Pesanan Customer</title>

    <style>

        body{

            font-family: DejaVu Sans;

            font-size:12px;

        }

        h2{

            text-align:center;

            margin-bottom:5px;

        }

        h4{

            text-align:center;

            margin-top:0;

            margin-bottom:20px;

        }

        table{

            width:100%;

            border-collapse:collapse;

        }

        th{

            background:#2563eb;

            color:white;

            border:1px solid #000;

            padding:8px;

        }

        td{

            border:1px solid #000;

            padding:6px;

        }

        .center{

            text-align:center;

        }

    </style>

</head>

<body>

<h2>

BERES.IN

</h2>

<h4>

LAPORAN PESANAN CUSTOMER

</h4>

<p>

<b>Nama Customer :</b>

{{ auth()->user()->name }}

</p>

<p>

<b>Tanggal Cetak :</b>

{{ now()->format('d-m-Y H:i') }}

</p>

<table>

<thead>

<tr>

<th>No</th>

<th>Invoice</th>

<th>Tanggal</th>

<th>Mitra</th>

<th>Layanan</th>

<th>Status</th>

<th>Pembayaran</th>

<th>Total</th>

</tr>

</thead>

<tbody>

@forelse($orders as $no => $order)

<tr>

<td class="center">

{{ $no+1 }}

</td>

<td>

{{ $order->invoice_number }}

</td>

<td>

{{ $order->jadwal }}

</td>

<td>

{{ $order->mitra->business_name ?? '-' }}

</td>

<td>

{{ $order->service->name ?? '-' }}

</td>

<td>

{{ ucfirst($order->status) }}

</td>

<td>

{{ ucfirst($order->payment_status) }}

</td>

<td>

Rp {{ number_format($order->total_price,0,',','.') }}

</td>

</tr>

@empty

<tr>

<td colspan="8" class="center">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

<br>

<table>

<tr>

<td>

<b>Total Pesanan</b>

</td>

<td>

{{ $totalOrder }}

</td>

</tr>

<tr>

<td>

<b>Pesanan Selesai</b>

</td>

<td>

{{ $completedOrder }}

</td>

</tr>

<tr>

<td>

<b>Pending</b>

</td>

<td>

{{ $pendingOrder }}

</td>

</tr>

<tr>

<td>

<b>Dibatalkan</b>

</td>

<td>

{{ $cancelledOrder }}

</td>

</tr>

</table>

</body>

</html>