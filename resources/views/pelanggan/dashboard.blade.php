@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <!-- =========================
         HERO SECTION
    ========================== -->

    <div class="hero-section mb-5">

        <div class="row align-items-center">

            <!-- LEFT -->

            <div class="col-lg-7">

                <span class="badge-hero mb-3">

                    #1 Home Service Marketplace

                </span>

                <h1 class="hero-title">

                    Solusi Home Service
                    Modern Untuk Rumah Anda

                </h1>

                <p class="hero-desc">

                    Temukan layanan profesional seperti
                    service AC, laundry, cleaning,
                    dan perbaikan rumah dengan mudah.

                </p>

                <!-- SEARCH -->

                <form action="/pelanggan"
                      method="GET"
                      class="search-box">

                    <i class="bi bi-search"></i>

                    <input type="text"
                           name="search"
                           placeholder="Cari layanan terbaik...">

                    <button>

                        Cari

                    </button>

                </form>

                <!-- STATS -->

                <div class="hero-stats">

                    <div class="stat-box">

                        <h4>500+</h4>

                        <span>Mitra</span>

                    </div>

                    <div class="stat-box">

                        <h4>2K+</h4>

                        <span>Order</span>

                    </div>

                    <div class="stat-box">

                        <h4>4.9</h4>

                        <span>Rating</span>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-5 text-center">

                <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png"
                     class="hero-image">

            </div>

        </div>

    </div>

    <!-- =========================
         CATEGORY
    ========================== -->

    <div class="mb-5">

        <div class="section-title">

            <h2>Kategori Layanan</h2>

            <p>Pilih layanan sesuai kebutuhan rumah Anda</p>

        </div>

        <div class="row g-4">

    <div class="col-lg-3 col-md-4 col-6">

        <a
    href="/category/Service AC"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-primary-subtle">

            ❄️

        </div>

        <h5>

            Service AC

        </h5>

    </div>

</a>

    </div>
    

    <div class="col-lg-3 col-md-4 col-6">

        <a
    href="/category/Service Pompa Air"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-info-subtle">

            💧

        </div>

        <h5>

            Service Pompa Air

        </h5>

    </div>

</a>

    </div>

    <div class="col-lg-3 col-md-4 col-6">

        <a
    href="/category/Service Mesin Cuci"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-success-subtle">

            🧺

        </div>

        <h5>

            Service Mesin Cuci

        </h5>

    </div>

</a>

    </div>

    <div class="col-lg-3 col-md-4 col-6">

        <a
    href="/category/Sofa Cleaning"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-warning-subtle">

            🛋️

        </div>

        <h5>

            Sofa Cleaning

        </h5>

    </div>

</a>

    </div>

    <div class="col-lg-3 col-md-4 col-6">

       <a
    href="/category/Cuci Kasur"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-danger-subtle">

            🛏️

        </div>

        <h5>

            Cuci Kasur

        </h5>

    </div>

</a>

    </div>

    <div class="col-lg-3 col-md-4 col-6">

       <a
    href="/category/Cuci Karpet"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-secondary-subtle">

            🧼

        </div>

        <h5>

            Cuci Karpet

        </h5>

    </div>

</a>

    </div>

    <div class="col-lg-3 col-md-4 col-6">

        <a
    href="/category/Laundry"
    class="text-decoration-none text-dark">

    <div class="category-card">

        <div class="category-icon bg-success-subtle">

            👕

        </div>

        <h5>

            Laundry

        </h5>

    </div>

</a>

    </div>

</div>

    </div>

    <!-- =========================
     ARTIKEL
========================= -->

<div class="mb-4">

    <div class="section-title">

        <h2>Tips & Artikel Rumah</h2>

        <p>Informasi dan tips perawatan rumah tangga</p>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-4">

        <div class="article-card">

            <img
                src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800"
                class="article-image">

            <div class="article-body">

                <span class="article-category">

                    Service AC

                </span>

                <h4>

                    5 Tips Merawat AC Agar Tetap Dingin dan Hemat Listrik

                </h4>

                <p>

                    Pelajari cara sederhana merawat AC
                    agar tetap awet dan tidak boros listrik.

                </p>

                <a href="#"
                   class="btn-article">

                    Baca Selengkapnya

                </a>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="article-card">

            <img
                src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800"
                class="article-image">

            <div class="article-body">

                <span class="article-category">

                    Cuci Sofa

                </span>

                <h4>

                    Cara Membersihkan Sofa Kain di Rumah dengan Mudah

                </h4>

                <p>

                    Tips membersihkan sofa agar tetap bersih
                    dan nyaman digunakan setiap hari.

                </p>

                <a href="#"
                   class="btn-article">

                    Baca Selengkapnya

                </a>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="article-card">

            <img
                src="https://images.unsplash.com/photo-1585704032915-c3400ca199e7?w=800"
                class="article-image">

            <div class="article-body">

                <span class="article-category">

                    Pompa Air

                </span>

                <h4>

                    Tanda-Tanda Pompa Air Rumah Harus Segera Diservis

                </h4>

                <p>

                    Kenali gejala pompa air rusak sebelum
                    kerusakan menjadi lebih parah.

                </p>

                <a href="#"
                   class="btn-article">

                    Baca Selengkapnya

                </a>

            </div>

        </div>

    </div>

</div>

    

</div>

<style>

body{

    background:#f5f7fb;

}

/* =========================
   HERO
========================= */

.hero-section{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

    border-radius:35px;

    padding:60px;

    color:white;

    overflow:hidden;

    position:relative;

}

.badge-hero{

    background:rgba(255,255,255,0.2);

    padding:10px 20px;

    border-radius:50px;

    display:inline-block;

    font-size:14px;

}

.hero-title{

    font-size:55px;

    font-weight:800;

    line-height:1.2;

    margin-bottom:20px;

}

.hero-desc{

    font-size:18px;

    opacity:0.9;

    margin-bottom:30px;

}

.hero-image{

    width:100%;

    max-width:380px;

}

/* =========================
   SEARCH
========================= */

.search-box{

    background:white;

    border-radius:60px;

    padding:12px;

    display:flex;

    align-items:center;

    margin-bottom:35px;

}

.search-box i{

    color:#6b7280;

    font-size:22px;

    margin:0 15px;

}

.search-box input{

    border:none;

    outline:none;

    flex:1;

    font-size:16px;

}

.search-box button{

    background:#2563eb;

    border:none;

    color:white;

    padding:14px 30px;

    border-radius:50px;

    font-weight:600;

}

/* =========================
   STATS
========================= */

.hero-stats{

    display:flex;

    gap:20px;

    flex-wrap:wrap;

}

.stat-box{

    background:rgba(255,255,255,0.15);

    backdrop-filter:blur(10px);

    padding:20px 25px;

    border-radius:20px;

    min-width:120px;

}

.stat-box h4{

    font-size:28px;

    font-weight:700;

    margin-bottom:5px;

}

/* =========================
   SECTION
========================= */

.section-title h2{

    font-weight:800;

    margin-bottom:10px;

}

.section-title p{

    color:#6b7280;

}

/* =========================
   CATEGORY
========================= */

.category-card{

    background:white;

    padding:35px;

    border-radius:25px;

    text-align:center;

    transition:0.3s;

    box-shadow:0 5px 20px rgba(0,0,0,0.05);

}
/* =========================
   ARTICLE
========================= */

.article-card{

    background:white;

    border-radius:25px;

    overflow:hidden;

    box-shadow:
        0 8px 30px rgba(0,0,0,0.05);

    transition:0.3s;

    height:100%;

}

.article-card:hover{

    transform:translateY(-6px);

}

.article-image{

    width:100%;

    height:220px;

    object-fit:cover;

}

.article-body{

    padding:25px;

}

.article-category{

    background:#dbeafe;

    color:#2563eb;

    padding:8px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:600;

}

.article-body h4{

    margin:20px 0 15px;

    font-weight:700;

    line-height:1.4;

}

.article-body p{

    color:#6b7280;

}

.btn-article{

    color:#2563eb;

    text-decoration:none;

    font-weight:700;

}

.category-card:hover{

    transform:translateY(-6px);

}

.category-icon{

    width:80px;

    height:80px;

    margin:auto;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:35px;

    margin-bottom:20px;

}

/* =========================
   SERVICE CARD
========================= */

.service-card{

    background:white;

    border-radius:30px;

    overflow:hidden;

    transition:0.3s;

    height:100%;

    box-shadow:0 8px 30px rgba(0,0,0,0.05);

    display:flex;

    flex-direction:column;

}

.service-card:hover{

    transform:translateY(-8px);

}

.service-image{

    position:relative;

    width:100%;

    height:260px;

    overflow:hidden;

    background:#f3f4f6;

}

.service-image img{

    width:100%;

    height:260px;

    object-fit:cover;

    display:block;

}

.service-overlay{

    position:absolute;

    top:20px;

    left:20px;

}

.service-overlay span{

    background:white;

    padding:8px 18px;

    border-radius:50px;

    font-size:14px;

    font-weight:600;

}

.service-body{

    padding:25px;

    flex:1;

    display:flex;

    flex-direction:column;

}

.service-body h4{

    font-weight:700;

}

.service-mitra,
.service-location{

    color:#6b7280;

    font-size:14px;

    margin-bottom:8px;

}

.service-desc{

    color:#6b7280;

    margin:20px 0;

}

.service-footer{

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.service-footer h3{

    color:#2563eb;

    font-weight:800;

}

.btn-book{

    background:#2563eb;

    color:white;

    padding:12px 22px;

    border-radius:50px;

    text-decoration:none;

    font-weight:600;

}

/* =========================
   EMPTY
========================= */

.empty-box{

    background:white;

    border-radius:30px;

    padding:80px;

    text-align:center;

}

.empty-box i{

    font-size:80px;

    color:#9ca3af;

}

/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    .hero-section{

        padding:35px;

        text-align:center;

    }

    .hero-title{

        font-size:36px;

    }

    .search-box{

        flex-direction:column;

        border-radius:25px;

        gap:15px;

    }

    .search-box button{

        width:100%;

    }

    .hero-stats{

        justify-content:center;

    }

}

</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
Swal.fire({
    title: 'Izinkan Akses Lokasi',
    text: 'Aplikasi Beres.in membutuhkan akses lokasi Anda untuk menemukan mitra terdekat.',
    icon: 'info',
    confirmButtonText: 'Izinkan',
    allowOutsideClick: false
}).then((result) => {

    if(result.isConfirmed){

        navigator.geolocation.getCurrentPosition(function(position){

            fetch("{{ route('update.location') }}",{

                method:'POST',

                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },

                body:JSON.stringify({

                    latitude:position.coords.latitude,
                    longitude:position.coords.longitude

                })

            });

        });

    }

});
</script>

@endsection