<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Rating & Review Mitra</title>

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

        p{

            text-align:center;

            margin-top:3px;

            margin-bottom:20px;

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

            border:1px solid #ddd;

            padding:8px;

            text-align:center;

        }

        td{

            border:1px solid #ddd;

            padding:8px;

            vertical-align:top;

        }

        .center{

            text-align:center;

        }

        .summary{

            width:100%;

            margin-top:10px;

            margin-bottom:20px;

        }

        .summary td{

            border:none;

            padding:4px;

        }

        .footer{

            margin-top:40px;

            text-align:right;

        }

    </style>

</head>

<body>

<h2>

BERES.IN

</h2>

<h3 style="text-align:center; margin-top:5px;">

LAPORAN RATING & REVIEW MITRA

</h3>

<p>

Tanggal Cetak :

{{ now()->timezone('Asia/Jakarta')->format('d F Y H:i') }} WIB

</p>

<table class="summary">

<tr>

<td width="30%">

<b>Nama Mitra</b>

</td>

<td>

:

{{ auth()->user()->business_name ?? auth()->user()->name }}

</td>

</tr>

<tr>

<td>

<b>Total Review</b>

</td>

<td>

:

{{ $totalReview }}

</td>

</tr>

<tr>

<td>

<b>Rata-rata Rating</b>

</td>

<td>

:

{{ number_format($averageRating,1) }} / 5

</td>

</tr>

</table>

<table>

<thead>

<tr>

<th width="5%">

No

</th>

<th width="15%">

Tanggal

</th>

<th width="25%">

Pelanggan

</th>

<th width="10%">

Rating

</th>

<th>

Review

</th>

</tr>

</thead>

<tbody>

@forelse($reviews as $no => $review)

<tr>

<td class="center">

{{ $no+1 }}

</td>

<td class="center">

{{ $review->created_at->format('d-m-Y') }}

</td>

<td>

{{ $review->user->name ?? '-' }}

</td>

<td class="center">

{{ $review->rating }}/5

</td>

<td>

{{ $review->review ?: '-' }}

</td>

</tr>

@empty

<tr>

<td colspan="5" class="center">

Belum ada data review.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="footer">

Tegal,

{{ now()->timezone('Asia/Jakarta')->format('d F Y') }}

<br><br><br><br>

<b>

{{ auth()->user()->business_name ?? auth()->user()->name }}

</b>

</div>

</body>

</html>