<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Pencairan Saldo</title>

    <style>

        body{

            font-family: DejaVu Sans;

            font-size:12px;

            color:#333;

        }

        h2{

            text-align:center;

            margin-bottom:0;

        }

        h3{

            text-align:center;

            margin-top:5px;

            margin-bottom:15px;

        }

        .info{

            margin-bottom:20px;

        }

        .info table{

            width:100%;

        }

        .info td{

            padding:4px;

        }

        table{

            width:100%;

            border-collapse:collapse;

        }

        th{

            background:#198754;

            color:white;

            border:1px solid #000;

            padding:8px;

            text-align:center;

        }

        td{

            border:1px solid #000;

            padding:7px;

        }

        .center{

            text-align:center;

        }

        .right{

            text-align:right;

        }

        .footer{

            margin-top:50px;

            text-align:right;

        }

    </style>

</head>

<body>

<h2>

BERES.IN

</h2>

<h3>

LAPORAN PENCAIRAN SALDO MITRA

</h3>

<div class="info">

<table>

<tr>

<td width="20%">

<b>Nama Mitra</b>

</td>

<td>

:

{{ auth()->user()->business_name ?? auth()->user()->name }}

</td>

</tr>

<tr>

<td>

<b>Tanggal Cetak</b>

</td>

<td>

:

{{ now()->format('d F Y H:i') }}

</td>

</tr>

<tr>

<td>

<b>Total Pencairan</b>

</td>

<td>

:

Rp {{ number_format($totalWithdrawal,0,',','.') }}

</td>

</tr>

<tr>

<td>

<b>Approved</b>

</td>

<td>

:

{{ $approved }}

</td>

</tr>

<tr>

<td>

<b>Pending</b>

</td>

<td>

:

{{ $pending }}

</td>

</tr>

</table>

</div>

<table>

<thead>

<tr>

<th width="5%">

No

</th>

<th width="18%">

Tanggal

</th>

<th width="20%">

Jumlah

</th>

<th width="18%">

Metode

</th>

<th>

Rekening

</th>

<th width="15%">

Status

</th>

</tr>

</thead>

<tbody>

@forelse($withdrawals as $no => $withdraw)

<tr>

<td class="center">

{{ $no+1 }}

</td>

<td class="center">

{{ $withdraw->created_at->format('d-m-Y') }}

</td>

<td class="right">

Rp {{ number_format($withdraw->amount,0,',','.') }}

</td>

<td class="center">

{{ ucfirst($withdraw->withdraw_type) }}

</td>

<td>

{{ $withdraw->bank_name }}

<br>

{{ $withdraw->account_number }}

</td>

<td class="center">

{{ ucfirst($withdraw->status) }}

</td>

</tr>

@empty

<tr>

<td colspan="6" class="center">

Belum ada data pencairan saldo.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="footer">

Tegal,

{{ now()->format('d F Y') }}

<br><br><br><br>

<b>

{{ auth()->user()->business_name ?? auth()->user()->name }}

</b>

</div>

</body>

</html>