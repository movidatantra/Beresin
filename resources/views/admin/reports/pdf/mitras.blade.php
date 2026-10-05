<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Data Mitra</title>

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

    LAPORAN DATA MITRA BERES.IN

</h2>

<p>

    Dicetak pada :
    {{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }} WIB

</p>

<table class="summary">

<tr>

    <td width="35%">
        <strong>Total Mitra</strong>
    </td>

    <td>

        {{ $totalMitra }}

    </td>

</tr>

<tr>

    <td>

        <strong>Mitra Terverifikasi</strong>

    </td>

    <td>

        {{ $verifiedMitra }}

    </td>

</tr>

<tr>

    <td>

        <strong>Total Order</strong>

    </td>

    <td>

        {{ number_format($totalOrder) }}

    </td>

</tr>

<tr>

    <td>

        <strong>Total Pendapatan</strong>

    </td>

    <td>

        Rp {{ number_format($totalIncome,0,',','.') }}

    </td>

</tr>

</table>

<table>

<thead>

<tr>

    <th>No</th>

    <th>Nama Mitra</th>

    <th>Usaha</th>

    <th>Spesialisasi</th>

    <th>Status</th>

    <th>Order</th>

    <th>Pendapatan</th>

</tr>

</thead>

<tbody>

@forelse($mitras as $no=>$mitra)

<tr>

    <td class="center">

        {{ $no+1 }}

    </td>

    <td>

        {{ $mitra->name }}

    </td>

    <td>

        {{ $mitra->business_name }}

    </td>

    <td>

        {{ $mitra->specialization }}

    </td>

    <td class="center">

        {{ ucfirst($mitra->verification_status) }}

    </td>

    <td class="center">

        {{ $mitra->total_order }}

    </td>

    <td class="right">

        Rp {{ number_format($mitra->income,0,',','.') }}

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="center">

        Tidak ada data.

    </td>

</tr>

@endforelse

</tbody>

</table>

<br><br>

<table style="border:none; width:100%;">

<tr style="border:none;">

<td style="border:none;"></td>

<td style="border:none; text-align:center; width:220px;">

Tegal,

{{ now()->timezone('Asia/Jakarta')->format('d F Y') }}

<br><br><br><br>

<b>Administrator Beres.in</b>

</td>

</tr>

</table>

</body>

</html>