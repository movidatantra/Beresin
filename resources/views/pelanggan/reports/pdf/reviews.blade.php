<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Laporan Rating & Review Customer</title>

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
            vertical-align:top;
        }

        .center{
            text-align:center;
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

LAPORAN RATING & REVIEW CUSTOMER

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

<th width="15%">Tanggal</th>

<th width="20%">Mitra</th>

<th width="20%">Layanan</th>

<th width="10%">Rating</th>

<th>Review</th>

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

{{ $review->mitra->business_name ?? $review->mitra->name ?? '-' }}

</td>

<td>

{{ $review->order->service->name ?? '-' }}

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

<td colspan="6" class="center">

Belum ada data review.

</td>

</tr>

@endforelse

</tbody>

</table>

<br><br>

<table class="summary">

<tr>

<td>

<b>Rata-rata Rating</b>

</td>

<td>

{{ number_format($averageRating,1) }}

</td>

</tr>

<tr>

<td>

<b>Total Review</b>

</td>

<td>

{{ $totalReview }}

</td>

</tr>

<tr>

<td>

<b>Rating 5</b>

</td>

<td>

{{ $rating5 }}

</td>

</tr>

<tr>

<td>

<b>Rating 4</b>

</td>

<td>

{{ $rating4 }}

</td>

</tr>

<tr>

<td>

<b>Rating 3</b>

</td>

<td>

{{ $rating3 }}

</td>

</tr>

<tr>

<td>

<b>Rating 2</b>

</td>

<td>

{{ $rating2 }}

</td>

</tr>

<tr>

<td>

<b>Rating 1</b>

</td>

<td>

{{ $rating1 }}

</td>

</tr>

</table>

<div style="clear:both;"></div>

<br><br><br>

<table style="width:100%; border:none;">

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