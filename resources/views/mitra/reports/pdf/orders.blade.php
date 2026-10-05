<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Order Mitra</title>

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

            color:#666;

            margin-top:5px;

        }

        table{

            width:100%;

            border-collapse:collapse;

            margin-top:20px;

        }

        th{

            background:#2563eb;

            color:white;

            border:1px solid #ddd;

            padding:8px;

        }

        td{

            border:1px solid #ddd;

            padding:8px;

        }

        .right{

            text-align:right;

        }

    </style>

</head>

<body>

<h2>

LAPORAN ORDER MITRA

</h2>

<p>

Tanggal Cetak :
{{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }} WIB

</p>

<table>

<thead>

<tr>

<th>No</th>

<th>Invoice</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Layanan</th>

<th>Status</th>

<th>Pembayaran</th>

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

{{ $order->invoice_number }}

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

{{ ucfirst($order->status) }}

</td>

<td>

{{ $order->payment_method }}

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