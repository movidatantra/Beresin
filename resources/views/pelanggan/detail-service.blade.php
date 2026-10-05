@extends('layouts.pelanggan')

@section('content')

<style>
    .cart-action-box{

    display:flex;

    gap:15px;

    align-items:center;

}

.qty-box{

    display:flex;

    align-items:center;

    background:#f8fafc;

    border-radius:50px;

    padding:8px;

    box-shadow:
        0 4px 12px rgba(0,0,0,.05);

}

.qty-btn{

    width:40px;

    height:40px;

    border:none;

    background:#2563eb;

    color:white;

    border-radius:50%;

    transition:.3s;

}

.qty-btn:hover{

    background:#1d4ed8;

}

.qty-number{

    min-width:50px;

    text-align:center;

    font-size:22px;

    font-weight:700;

}

.cart-button{

    flex:1;

    background:#16a34a;

    color:white;

    border-radius:50px;

    text-decoration:none;

    padding:14px;

    text-align:center;

    font-weight:700;

    transition:.3s;

}

.cart-button:hover{

    background:#15803d;

    color:white;

}

.service-image{

    height:500px;

    object-fit:cover;

    border-radius:30px;

}

.info-card{

    border:none;

    border-radius:30px;

    box-shadow:
        0 10px 30px rgba(0,0,0,.05);

}

.category-badge{

    background:#dbeafe;

    color:#2563eb;

    padding:10px 20px;

    border-radius:50px;

    font-weight:600;

}

.rating-badge{

    background:#fef3c7;

    color:#f59e0b;

    padding:6px 14px;

    border-radius:50px;

    font-size:14px;

    font-weight:700;

}

.price-box{

    background:#f8fafc;

    padding:25px;

    border-radius:20px;

}

.price{

    color:#2563eb;

    font-size:40px;

    font-weight:800;

}

.btn-book{

    background:#2563eb;

    color:white;

    border-radius:50px;

    padding:15px;

    font-weight:700;

    text-decoration:none;

    text-align:center;

    transition:.3s;

}

.btn-book:hover{

    background:#1d4ed8;

    color:white;

}

.btn-back{

    border-radius:50px;

}

</style>

<div class="container py-5">

    <div class="row g-5">

        <!-- FOTO -->

        <div class="col-lg-6">

            @if($service->image)

            <img
                src="{{ asset('uploads/'.$service->image) }}"
                class="w-100 service-image">

            @else

            <img
                src="https://placehold.co/700x500"
                class="w-100 service-image">

            @endif

        </div>


        <!-- DETAIL -->

        <div class="col-lg-6">

            <div class="card info-card">

                <div class="card-body p-5">

                    <!-- CATEGORY -->

                    <span class="category-badge">

                        {{ $service->category }}

                    </span>


                    <!-- TITLE -->

                    <h1 class="fw-bold mt-4 mb-3">

                        {{ $service->name }}

                    </h1>


                    <!-- RATING -->

        <span class="rating-badge">
    ⭐ {{ number_format($service->mitra->reviews_avg_rating ?? 0, 1) }}
    ({{ $service->mitra->reviews_count ?? 0 }})
</span>


                    <hr class="my-4">


                    <!-- MITRA -->

                    <div class="mb-3">

                        <i class="bi bi-shop me-2 text-primary"></i>

                        <strong>

                            {{ $service->mitra?->business_name }}

                        </strong>

                    </div>
                    


                    <!-- AREA -->

                    <div class="mb-3">

                        <i class="bi bi-geo-alt me-2 text-danger"></i>

                        {{ $service->mitra?->address }}

                    </div>


                    <!-- JAM OPERASIONAL -->

                    <div class="mb-3">

                        <i class="bi bi-clock me-2 text-success"></i>

                        {{ $service->mitra?->open_time }}

                        -

                        {{ $service->mitra?->close_time }}

                    </div>
<!-- HARI OPERASIONAL -->

<div class="mb-4">

    <i class="bi bi-calendar-week me-2 text-warning"></i>

    <strong>Hari Operasional:</strong>

    @if($service->mitra?->holiday == 'tidak_ada')

        Setiap Hari

    @elseif($service->mitra?->holiday == 'minggu')

        Senin - Sabtu

    @elseif($service->mitra?->holiday == 'sabtu')

        Minggu - Jumat

    @elseif($service->mitra?->holiday == 'sabtu,minggu')

        Senin - Jumat

    @else

        Libur {{ ucfirst($service->mitra?->holiday) }}

    @endif

</div>

                    <!-- GARANSI -->

                    <div class="mb-4">

                        <i class="bi bi-shield-check me-2 text-info"></i>

                        @if($service->mitra?->service_warranty)

                            Garansi Layanan Tersedia

                        @else

                            Tidak Ada Garansi

                        @endif

                    </div>


                    <!-- HARGA -->

                    <div class="price-box mb-4">

                        <small class="text-muted">

                            Mulai dari

                        </small>

                        <div class="price">

                            Rp {{ number_format($service->price) }}

                        </div>

                    </div>


                    <!-- DURASI -->

                    <div class="mb-4">

                        <h5 class="fw-bold">

                            Durasi Pengerjaan

                        </h5>

                        <p class="text-muted">

                            {{ $service->duration }}

                        </p>

                    </div>


                    <!-- DESKRIPSI -->

                    <div class="mb-5">

                        <h5 class="fw-bold">

                            Deskripsi Layanan

                        </h5>

                        <p class="text-muted">

                            {{ $service->description }}

                        </p>

                    </div>


                    <!-- BUTTON -->

                    <!-- BUTTON -->

<div class="mt-4">

    <!-- KEMBALI -->

    <a
        href="/category/{{ $service->category }}"
        class="btn btn-light
               border
               rounded-pill
               px-4
               py-2
               mb-4">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>


    @if($qty == 0)

        <button
            id="btn-cart"
            class="btn-book
                   w-100
                   border-0">

            <i class="bi bi-cart-plus-fill me-2"></i>

            Masukkan Keranjang

        </button>

    @else

        <div class="cart-action-box">

            <div class="qty-box">

                <button
                    id="minus-btn"
                    class="qty-btn">

                    <i class="bi bi-dash"></i>

                </button>

                <span class="qty-number">

                    {{ $qty }}

                </span>

                <button
                    id="plus-btn"
                    class="qty-btn">

                    <i class="bi bi-plus"></i>

                </button>

            </div>


            <a
                href="/cart"
                class="cart-button">

                <i class="bi bi-cart-check-fill me-2"></i>

                Keranjang ({{ $qty }})

            </a>

        </div>

    @endif

</div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let qty = {{ $qty }};

const serviceId = {{ $service->id }};

function addCart(){

    fetch('/cart/add/' + serviceId, {

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':
            '{{ csrf_token() }}'
        }

    })
    .then(res=>res.json())
    .then(data=>{

        location.reload();

    });

}

function minusCart(){

    fetch('/cart/decrease/' + serviceId, {

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':
            '{{ csrf_token() }}'
        }

    })
    .then(res=>res.json())
    .then(data=>{

        location.reload();

    });

}

if(document.getElementById('btn-cart')){

    document
    .getElementById('btn-cart')
    .onclick = addCart;

}

if(document.getElementById('plus-btn')){

    document
    .getElementById('plus-btn')
    .onclick = addCart;

}

if(document.getElementById('minus-btn')){

    document
    .getElementById('minus-btn')
    .onclick = minusCart;

}

</script>
<script>

const serviceId = {{ $service->id }};

function addCart()
{
    fetch('/cart/add/' + serviceId, {

        method: 'POST',

        headers: {

            'X-CSRF-TOKEN':
            '{{ csrf_token() }}',

            'Accept':
            'application/json'

        }

    })

    .then(response => response.json())

    .then(data => {

        location.reload();

    });
}


function minusCart()
{
    fetch('/cart/decrease/' + serviceId, {

        method: 'POST',

        headers: {

            'X-CSRF-TOKEN':
            '{{ csrf_token() }}',

            'Accept':
            'application/json'

        }

    })

    .then(response => response.json())

    .then(data => {

        location.reload();

    });
}


if(document.getElementById('btn-cart'))
{
    document
        .getElementById('btn-cart')
        .addEventListener(
            'click',
            addCart
        );
}


if(document.getElementById('plus-btn'))
{
    document
        .getElementById('plus-btn')
        .addEventListener(
            'click',
            addCart
        );
}


if(document.getElementById('minus-btn'))
{
    document
        .getElementById('minus-btn')
        .addEventListener(
            'click',
            minusCart
        );
}

</script>


@endsection