<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Pembayaran Customer</title>

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

        h4{

            text-align:center;

            margin-top:5px;

            margin-bottom:20px;

            color:#555;

        }

        .info{

            margin-bottom:20px;

        }

        .info p{

            margin:4px 0;

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

        .summary{

            margin-top:25px;

            width:45%;

            float:right;

        }

        .summary td{

            padding:8px;

        }

    </style>

</head>

<body>

<h2>

BERES.IN

</h2>

<h4>

LAPORAN PEMBAYARAN CUSTOMER

</h4>

<div class="info">

<p>

<b>Nama Customer :</b>

{{ auth()->user()->name }}

</p>

<p>

<b>Tanggal Cetak :</b>

{{ now()->format('d-m-Y H:i') }}

</p>

</div>
<table>

    <thead>

        <tr>

            <th width="5%">No</th>

            <th width="15%">Invoice</th>

            <th width="12%">Tanggal</th>

            <th width="20%">Mitra</th>

            <th width="18%">Layanan</th>

            <th width="12%">Metode</th>

            <th width="10%">Status</th>

            <th width="15%">Total</th>

        </tr>

    </thead>

    <tbody>

        @forelse($payments as $no => $payment)

        <tr>

            <td class="center">

                {{ $no + 1 }}

            </td>

            <td>

                {{ $payment->invoice_number ?? '-' }}

            </td>

            <td class="center">

                {{ \Carbon\Carbon::parse($payment->jadwal)->format('d-m-Y') }}

            </td>

            <td>

                {{ $payment->mitra->business_name ?? $payment->mitra->name ?? '-' }}

            </td>

            <td>

                {{ $payment->service->name ?? '-' }}

            </td>

            <td class="center">

                {{ ucfirst($payment->payment_method) }}

            </td>

            <td class="center">

                @if($payment->payment_status=='lunas')

                    Lunas

                @else

                    Belum Bayar

                @endif

            </td>

            <td class="right">

                Rp {{ number_format($payment->total_price,0,',','.') }}

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="8" class="center">

                Tidak ada data pembayaran.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<br><br>

<table class="summary">

    <tr>

        <td>

            <b>Total Pengeluaran</b>

        </td>

        <td class="right">

            Rp {{ number_format($totalPayment,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>

            <b>Sudah Dibayar</b>

        </td>

        <td class="right">

            {{ $paid }}

        </td>

    </tr>

    <tr>

        <td>

            <b>Belum Dibayar</b>

        </td>

        <td class="right">

            {{ $unpaid }}

        </td>

    </tr>

    <tr>

        <td>

            <b>Total Transaksi</b>

        </td>

        <td class="right">

            {{ $totalTransaction }}

        </td>

    </tr>

</table>

<div style="clear:both;"></div>

<br><br><br>

<table style="border:none; width:100%;">

    <tr>

        <td style="border:none; width:60%;"></td>

        <td style="border:none; text-align:center;">

            Tegal,

            {{ now()->format('d F Y') }}

            <br><br><br><br><br>

            <b>

                {{ auth()->user()->name }}

            </b>

            <br>

            Customer Beres.in

        </td>

    </tr>

</table>

</body>

</html>