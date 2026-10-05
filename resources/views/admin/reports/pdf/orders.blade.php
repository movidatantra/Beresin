<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Order</title>

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        h2{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:6px;
            text-align:left;
        }

        table th{
            background:#f2f2f2;
        }

    </style>

</head>

<body>

<h2>LAPORAN ORDER BERES.IN</h2>

<p>
Tanggal Cetak :
{{ now()->format('d-m-Y H:i') }}
</p>

<table>

<thead>

<tr>

    <th>No</th>

    <th>Kode</th>

    <th>Pelanggan</th>

    <th>Mitra</th>

    <th>Layanan</th>

    <th>Total</th>

    <th>Status</th>

</tr>

</thead>

<tbody>

@foreach($orders as $order)

<tr>

<td>{{ $loop->iteration }}</td>

<td>ORD-{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</td>

<td>{{ $order->user->name }}</td>

<td>{{ $order->mitra->name }}</td>

<td>{{ $order->service->name }}</td>

<td>Rp {{ number_format($order->total_price) }}</td>

<td>{{ ucfirst($order->status) }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>