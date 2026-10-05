<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Beres.in - Home Service Marketplace</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body{
            overflow-x: hidden;
        }

        body{
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ======================
           NAVBAR
        ====================== */

        .navbar-custom{
            background: linear-gradient(to right,#1e40af,#2563eb);
            padding: 15px 40px;
        }

        .logo{
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-decoration: none;
        }

        .search-box{
            width: 100%;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            outline: none;
        }

        .menu-icon{
            color: white;
            font-size: 23px;
            margin-left: 20px;
            cursor: pointer;
        }

        /* ======================
           HERO
        ====================== */

        .hero{
            background: linear-gradient(to right,#1e40af,#3b82f6);
            border-radius: 30px;
            padding: 60px;
            margin-top: 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero h1{
            font-size: 48px;
            font-weight: bold;
            line-height: 1.3;
        }

        .hero p{
            font-size: 18px;
            margin-top: 20px;
            max-width: 600px;
        }

        .hero img{
            width: 320px;
            position: absolute;
            right: 40px;
            bottom: 0;
        }

        /* ======================
           CATEGORY
        ====================== */

        .category-card{
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }

        .category-card:hover{
            transform: translateY(-5px);
        }

        .category-icon{
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 32px;
            margin-bottom: 15px;
        }

        /* ======================
           SERVICE CARD
        ====================== */

        .service-card{
            background: white;
            border-radius: 25px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }
        .mitra-card{

    background:white;

    border-radius:25px;

    overflow:hidden;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    height:100%;

    transition:.3s;

}

.mitra-card:hover{

    transform:translateY(-8px);

}

.mitra-img{

    width:100%;

    height:250px;

    object-fit:cover;

}

.mitra-body{

    padding:25px;

}

        .service-card:hover{
            transform: translateY(-5px);
        }

        .service-image{
            height: 220px;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 70px;
        }

        .service-body{
            padding: 20px;
        }

        .rating{
            color: #f59e0b;
            font-size: 14px;
        }

        .price{
            color: #2563eb;
            font-size: 24px;
            font-weight: bold;
        }

        .btn-book{
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-book:hover{
            background: #1d4ed8;
        }


        /* ======================
   ABOUT US
====================== */

.about-section{

    padding:80px 0;

}

.about-image{

    width:100%;

    border-radius:30px;

    object-fit:cover;

    box-shadow:0 10px 30px rgba(0,0,0,.08);

}

.about-badge{

    background:#dbeafe;

    color:#2563eb;

    padding:10px 20px;

    border-radius:50px;

    display:inline-block;

    margin-bottom:20px;

    font-weight:600;

}

.about-section h2{

    font-size:42px;

    font-weight:800;

    margin-bottom:20px;

}

.about-section p{

    color:#6b7280;

    font-size:17px;

    line-height:1.8;

}

.about-stats{

    display:flex;

    gap:40px;

    margin-top:30px;

    flex-wrap:wrap;

}

.about-stats h3{

    color:#2563eb;

    font-size:32px;

    font-weight:800;

    margin-bottom:5px;

}

.about-stats span{

    color:#6b7280;

}

.section-header{

    margin-top:60px;
    margin-bottom:30px;

}

.section-header h2{

    font-size:38px;
    font-weight:800;
    color:#111827;

}

.section-header p{

    color:#6b7280;
    font-size:16px;

}
        /* ======================
           FOOTER
        ====================== */

        footer{
            background: #0f172a;
            color: white;
            margin-top: 80px;
            padding: 50px 40px;
        }

        /* ======================
           MOBILE RESPONSIVE
        ====================== */

        @media (max-width: 768px){

            /* NAVBAR */

            .navbar-custom{
                padding: 15px;
            }

            .navbar-custom .container-fluid{
                flex-direction: column;
                gap: 15px;
            }

            .logo{
                font-size: 28px;
            }

            .search-wrapper{
                width: 100% !important;
            }

            .auth-buttons{
                width: 100%;
                display: flex;
                gap: 10px;
            }

            .auth-buttons a{
                width: 100%;
            }

            /* HERO */

            .hero{
                padding: 35px 25px;
                text-align: center;
            }

            .hero h1{
                font-size: 32px;
            }

            .hero p{
                font-size: 16px;
                max-width: 100%;
            }

            .hero img{
                position: static;
                width: 220px;
                margin-top: 25px;
            }

            /* CATEGORY */

            .category-card{
                padding: 15px;
            }

            .category-icon{
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            /* SERVICE */

            .service-image{
                height: 180px;
                font-size: 55px;
            }

            .service-body{
                padding: 18px;
            }

            .price{
                font-size: 20px;
            }

            /* FOOTER */

            footer{
                padding: 35px 20px;
                text-align: center;
            }

        }

    </style>

</head>

<body>

<!-- ======================
     NAVBAR
====================== -->

<nav class="navbar navbar-custom">

    <div class="container-fluid">

        <a href="/" class="logo">
            Beres.in
        </a>

        <div class="search-wrapper w-50">

            <input type="text"
                   class="search-box"
                   placeholder="Cari layanan service rumah tangga...">

        </div>

        <div class="auth-buttons">

            <a href="/login"
               class="btn btn-light rounded-pill px-4">

                Login

            </a>

            <a href="/register"
               class="btn btn-outline-light rounded-pill px-4 ms-2">

                Register

            </a>

        </div>

    </div>

</nav>

<!-- ======================
     CONTENT
====================== -->

<div class="container">

    <!-- HERO -->

    <div class="hero">

        <h1>
            Solusi Home Service Modern
        </h1>

        <p>
            Booking layanan jasa rumah tangga kini lebih mudah,
            cepat, dan praktis bersama Beres.in
        </p>

        <a href="/login"
           class="btn btn-light btn-lg mt-4 rounded-pill px-4">

            Booking Sekarang

        </a>

    </div>


    <!-- ======================
     ABOUT US
====================== -->

<section class="about-section">

    <div class="row align-items-center">

        <div class="col-lg-6">

            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1200"
                 class="about-image">

        </div>

        <div class="col-lg-6">

            <span class="about-badge">

                Tentang Kami

            </span>

            <h2>

                Solusi Home Service
                Modern dan Terpercaya

            </h2>

            <p>

                Beres.in adalah platform marketplace jasa
                rumah tangga yang menghubungkan pelanggan
                dengan mitra profesional untuk berbagai
                kebutuhan rumah seperti service AC,
                service pompa air, service mesin cuci,
                sofa cleaning, cuci kasur, cuci karpet,
                dan laundry.

            </p>

            <p>

                Kami hadir untuk memberikan kemudahan,
                keamanan, dan kenyamanan dalam mencari
                layanan terbaik langsung dari rumah.

            </p>

            <div class="about-stats">

    <div>

        <h3>

            {{ $totalMitra }}

        </h3>

        <span>

            Mitra Aktif

        </span>

    </div>

    <div>

        <h3>

            {{ $totalOrder }}

        </h3>

        <span>

            Order Selesai

        </span>

    </div>

    <div>

        <h3>

            {{ number_format($averageRating ?? 0,1) }}★

        </h3>

        <span>

            Rating Pelanggan

        </span>

    </div>

</div>

        </div>

    </div>

</section>
    <!-- CATEGORY -->

    <h3 class="mt-5 mb-4 fw-bold">
        Kategori Layanan
    </h3>

    <div class="row g-4">

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    ❄️
                </div>

                <h6>Service AC</h6>

            </div>

        </div>

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    🛋️
                </div>

                <h6>Cuci Sofa</h6>

            </div>

        </div>

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    🧺
                </div>

                <h6>Laundry</h6>

            </div>

        </div>

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    💧
                </div>

                <h6>Pompa Air</h6>

            </div>

        </div>

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    🛏️
                </div>

                <h6>Springbed</h6>

            </div>

        </div>

        <div class="col-6 col-md-2">

            <div class="category-card">

                <div class="category-icon">
                    ⚙️
                </div>

                <h6>Mesin Cuci</h6>

            </div>

        </div>

    </div>

    <!-- POPULAR SERVICE -->

    {{-- <h3 class="mt-5 mb-4 fw-bold">
        Layanan Populer
    </h3> --}}

    <div class="section-header">

    <h2>

        Mitra Kami

    </h2>

    <p>

        Temukan mitra profesional terbaik
        untuk kebutuhan rumah Anda

    </p>

</div>

    <div class="row g-4">

        <div class="row g-4">

    @forelse($mitras as $mitra)

    <div class="col-lg-4 col-md-6">

        <div class="mitra-card">

            @if($mitra->photo)

                <img src="{{ asset('uploads/profile/'.$mitra->photo) }}"
                     class="mitra-img">

            @else

                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a"
                     class="mitra-img">

            @endif

            <div class="mitra-body">

                <h4>

                    {{ $mitra->business_name }}

                </h4>

                <span class="badge bg-primary">

                    {{ $mitra->specialization }}

                </span>

                <div class="mt-3">

                    📍 {{ $mitra->business_area }}

                </div>

                <p class="text-muted mt-3">

                    {{ Str::limit($mitra->description,100) }}

                </p>

                <a href="/login"
                   class="btn-book">

                    Lihat Profil Mitra

                </a>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12">

        <div class="alert alert-info">

            Belum ada mitra terdaftar.

        </div>

    </div>

    @endforelse

</div>

    </div>

</div>

<!-- ======================
     FOOTER
====================== -->

<footer>

    <div class="row align-items-center g-4">

        <div class="col-md-8">

            <h2 class="fw-bold">
                Gabung Menjadi Mitra Beres.in 🚀
            </h2>

            <p class="mt-3 text-light">

                Punya usaha jasa rumah tangga?

                Yuk gabung menjadi mitra Beres.in dan
                dapatkan lebih banyak pelanggan secara online.

            </p>

            <ul class="mt-4">

                <li>✔️ Kelola order lebih mudah</li>

                <li>✔️ Promosi usaha secara digital</li>

                <li>✔️ Jangkauan pelanggan lebih luas</li>

                <li>✔️ Sistem booking online modern</li>

            </ul>

        </div>

        <div class="col-md-4 text-center">

            <a href="/register-mitra"
               class="btn btn-primary btn-lg rounded-pill px-5">

                Daftar Jadi Mitra

            </a>

        </div>

    </div>

    <hr class="mt-5">

    <div class="text-center mt-4">

        © 2026 Beres.in - Home Service Marketplace

    </div>

</footer>

</body>
</html>