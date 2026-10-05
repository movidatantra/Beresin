@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            Detail Pelanggan
        </h3>
        <small class="text-muted">
            Informasi lengkap pelanggan Beres.in
        </small>
    </div>
    <a href="{{ route('admin.kelola-pengguna.pelanggan') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left" style="font-size: 1rem !important;"></i>
    Kembali
</a>
</div>

<div class="row">
    <!-- KOLOM KIRI: PROFIL & AKSI -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow rounded-4 h-100">
            <div class="card-body text-center d-flex flex-column justify-content-between">
                <div>
                    @if($customer->photo)
                        <img src="{{ asset('storage/'.$customer->photo) }}"
                             class="rounded-circle shadow"
                             width="120"
                             height="120"
                             style="object-fit:cover;">
                    @else
                        <i class="bi bi-person-circle text-primary" style="font-size:110px"></i>
                    @endif

                    <h4 class="mt-3 fw-bold">
                        {{ $customer->name }}
                    </h4>
                    <p class="text-muted mb-3">
                        Pelanggan Beres.in
                    </p>

                    @if($customer->status=='active')
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    @else
                        <span class="badge bg-danger">
                            Suspended
                        </span>
                    @endif

                    <hr>

                    <table class="table table-borderless text-start mb-4">
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $customer->address }}</td>
                        </tr>
                        <tr>
                            <th>Bergabung</th>
                            <td>
                                {{ $customer->created_at->format('d F Y') }}
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Bagian Tombol Aksi berada di bawah kartu profil -->
                <div class="d-grid gap-2 mt-auto">
                    @php
                        $wa = preg_replace('/^0/', '62', $customer->phone);
                    @endphp
                    <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i>
                        Hubungi WhatsApp
                    </a>

                    @if($customer->status=='active')
                        <form action="{{ route('admin.kelola-pengguna.pelanggan.suspend',$customer->id) }}"
      method="POST">

    @csrf

    <button class="btn btn-danger w-100">

        <i class="bi bi-person-x-fill"></i>

        Suspend Akun

    </button>

</form>
                    @else
                        <form action="{{ route('admin.kelola-pengguna.pelanggan.activate',$customer->id) }}"
      method="POST">

    @csrf

    <button class="btn btn-primary w-100">

        <i class="bi bi-person-check-fill"></i>

        Aktifkan Akun

    </button>

</form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: STATISTIK & REKAP ORDER -->
    <div class="col-lg-8 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-fill fs-2 text-primary"></i>
                        <h3 class="mt-2 fw-bold">
                            {{ $totalOrder }}
                        </h3>
                        <small class="text-muted">
                            Total Order
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-fill fs-2 text-warning"></i>
                        <h3 class="mt-2 fw-bold">
                            {{ $orderPending }}
                        </h3>
                        <small class="text-muted">
                            Pending
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-gear-fill fs-2 text-info"></i>
                        <h3 class="mt-2 fw-bold">
                            {{ $processOrder }}
                        </h3>
                        <small class="text-muted">
                            Diproses
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill fs-2 text-success"></i>
                        <h3 class="mt-2 fw-bold">
                            {{ $orderSelesai }}
                        </h3>
                        <small class="text-muted">
                            Order Selesai
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 fs-2 text-danger"></i>
                        <h4 class="mt-2 fw-bold text-danger">
                            Rp {{ number_format($totalPengeluaran,0,',','.') }}
                        </h4>
                        <small class="text-muted">
                            Total Pengeluaran
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow rounded-4 mt-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            <i class="bi bi-cart-check-fill text-primary"></i>

            Riwayat Pemesanan

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">
            <div class="row mb-3">

    <div class="col-md-4 ms-auto">

        <input
            type="text"
            id="searchOrder"
            class="form-control"
            placeholder="Cari invoice, layanan atau mitra...">

    </div>

</div>

            <table 
            
    id="orderTable"
    class="table table-hover align-middle">
            

                <thead class="table-light">

                    <tr>

                        <th>Invoice</th>

                        <th>Layanan</th>

                        <th>Mitra</th>

                        <th>Jadwal</th>

                        <th>Status</th>

                        <th>Pembayaran</th>

                        <th>Total</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr>

                        <td>

                            @if($order->invoice_number)

                                {{ $order->invoice_number }}

                            @else

                                ORD-{{ str_pad($order->id,6,'0',STR_PAD_LEFT) }}

                            @endif

                        </td>

                        <td>

                            @foreach($order->items as $item)

    <span class="badge bg-primary">

        {{ $item->service->name }}

    </span>

@endforeach

                        </td>

                        <td>

                            {{ $order->mitra->name ?? '-' }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($order->jadwal)->format('d M Y') }}

                            <br>

                            <small class="text-muted">

                                {{ substr($order->jam,0,5) }}

                            </small>

                        </td>

                        <td>

                            @switch($order->status)

                                @case('pending')

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                    @break

                                @case('diterima')

                                    <span class="badge bg-info">

                                        Diterima

                                    </span>

                                    @break

                                @case('menuju_lokasi')

                                    <span class="badge bg-primary">

                                        Menuju Lokasi

                                    </span>

                                    @break

                                @case('dikerjakan')

                                    <span class="badge bg-secondary">

                                        Dikerjakan

                                    </span>

                                    @break

                                @case('selesai')

                                    <span class="badge bg-success">

                                        Selesai

                                    </span>

                                    @break

                                @default

                                    <span class="badge bg-danger">

                                        Dibatalkan

                                    </span>

                            @endswitch

                        </td>

                        <td>

                            @if($order->payment_status=='lunas')

                                <span class="badge bg-success">

                                    Lunas

                                </span>

                            @elseif($order->payment_status=='menunggu_verifikasi')

                                <span class="badge bg-warning">

                                    Menunggu Verifikasi

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    Belum Bayar

                                </span>

                            @endif

                        </td>

                        <td>

                            Rp {{ number_format($order->total_price,0,',','.') }}

                        </td>

                        <td>

                            <a href="{{ url('/admin/orders/'.$order->id) }}"
                               class="btn btn-primary btn-sm">

                                <i class="bi bi-eye-fill"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-5">

                            <i class="bi bi-cart-x fs-1 text-muted"></i>

                            <br>

                            Belum ada riwayat order.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $orders->links() }}

        </div>

    </div>

</div>
<div class="card border-0 shadow rounded-4 mt-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            <i class="bi bi-credit-card-fill text-success"></i>

            Riwayat Pembayaran

        </h5>

    </div>
    

    <div class="card-body">

        <div class="table-responsive">

            <div class="row mb-3">

    <div class="col-md-4 ms-auto">

        <input
            id="searchPayment"
            class="form-control"
            placeholder="Cari invoice atau metode...">

    </div>

</div>

            <table 
           
id="paymentTable"
class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Invoice</th>

                        <th>Metode</th>

                        <th>Status</th>

                        <th>Nominal</th>

                        <th>Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $payment)

                    <tr>

                        <td>

                            {{ $payment->invoice_number }}

                        </td>

                        <td>

                            {{ strtoupper($payment->payment_method ?? 'COD') }}

                        </td>

                        <td>

                            @if($payment->payment_status=='lunas')

                                <span class="badge bg-success">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Lunas

                                </span>

                            @elseif($payment->payment_status=='menunggu_verifikasi')

                                <span class="badge bg-warning">

                                    <i class="bi bi-hourglass-split"></i>

                                    Menunggu Verifikasi

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    <i class="bi bi-clock-fill"></i>

                                    Belum Bayar

                                </span>

                            @endif

                        </td>

                        <td>

                            Rp {{ number_format($payment->total_price,0,',','.') }}

                        </td>

                        <td>

                            {{ $payment->created_at->format('d M Y') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-5">

                            <i class="bi bi-credit-card fs-1 text-muted"></i>

                            <br>

                            Belum ada riwayat pembayaran.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<div class="card border-0 shadow rounded-4 mt-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            <i class="bi bi-star-fill text-warning"></i>

            Riwayat Ulasan

        </h5>

    </div>
    

    <div class="card-body"><div class="row mb-3">

    <div class="col-md-4 ms-auto">

        <input
            id="searchReview"
            class="form-control"
            placeholder="Cari nama mitra atau komentar...">

    </div>

</div>
        

        @forelse($reviews as $review)

            <div class="review-item border rounded-4 p-3 mb-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="fw-bold mb-1">

                            {{ $review->mitra->business_name ?? $review->mitra->name }}

                        </h6>

                        <small class="text-muted">

                            {{ $review->created_at->format('d F Y H:i') }}

                        </small>

                    </div>

                    <div>

                        @for($i=1;$i<=5;$i++)

                            @if($i <= $review->rating)

                                <i class="bi bi-star-fill text-warning"></i>

                            @else

                                <i class="bi bi-star text-warning"></i>

                            @endif

                        @endfor

                    </div>

                </div>

                <hr>

                <p class="mb-0">

                    {{ $review->comment ?? '-' }}

                </p>

            </div>

        @empty

            <div class="text-center py-5">

                <i class="bi bi-chat-square-text fs-1 text-muted"></i>

                <h5 class="mt-3">

                    Belum Ada Ulasan

                </h5>

                <p class="text-muted">

                    Pelanggan ini belum pernah memberikan ulasan.

                </p>

            </div>

        @endforelse

    </div>

</div>



<script>

document.getElementById('searchOrder').addEventListener('keyup',function(){

    let value=this.value.toLowerCase();

    let rows=document.querySelectorAll('#orderTable tbody tr');

    rows.forEach(function(row){

        row.style.display=row.innerText.toLowerCase().includes(value)
            ?''
            :'none';

    });

});

</script>

<script>

document.getElementById('searchPayment').addEventListener('keyup',function(){

    let value=this.value.toLowerCase();

    let rows=document.querySelectorAll('#paymentTable tbody tr');

    rows.forEach(function(row){

        row.style.display=row.innerText.toLowerCase().includes(value)
            ?''
            :'none';

    });

});

</script>

<script>

document.getElementById('searchReview').addEventListener('keyup',function(){

    let value=this.value.toLowerCase();

    let reviews=document.querySelectorAll('.review-item');

    reviews.forEach(function(item){

        item.style.display=item.innerText.toLowerCase().includes(value)
            ?''
            :'none';

    });

});

</script>
@endsection