<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Beres.in Customer</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        *{

            margin:0;

            padding:0;

            box-sizing:border-box;

        }

        body{

            background:#f4f7fc;

            font-family:'Poppins',sans-serif;

            min-height:100vh;

            display:flex;

            flex-direction:column;

        }

        a{

            text-decoration:none;

        }

        /*==============================
            NAVBAR
        ==============================*/

        .navbar-custom{

            background:rgba(255,255,255,.85);

            backdrop-filter:blur(15px);

            -webkit-backdrop-filter:blur(15px);

            box-shadow:0 8px 25px rgba(0,0,0,.06);

            padding:18px 0;

            position:sticky;

            top:0;

            z-index:999;

        }

        .logo{

            font-size:30px;

            font-weight:800;

            color:#2563eb;

            letter-spacing:-1px;

        }

        .logo span{

            color:#1e40af;

        }

        /*==============================
            SEARCH
        ==============================*/

        .search-box{

            position:relative;

        }

        .search-box i{

            position:absolute;

            left:18px;

            top:50%;

            transform:translateY(-50%);

            color:#9ca3af;

        }

        .search-input{

            width:100%;

            border:none;

            outline:none;

            background:#eef2ff;

            border-radius:50px;

            padding:13px 20px 13px 50px;

            transition:.3s;

        }

        .search-input:focus{

            background:white;

            box-shadow:0 0 0 4px rgba(37,99,235,.15);

        }

        /*==============================
            ICON MENU
        ==============================*/

        .nav-icon{

            width:48px;

            height:48px;

            border-radius:50%;

            background:#eef4ff;

            color:#2563eb;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:20px;

            transition:.25s;

            position:relative;

        }

        .nav-icon:hover{

            background:#2563eb;

            color:white;

            transform:translateY(-3px);

        }

        .badge-notif{

            position:absolute;

            top:-2px;

            right:-2px;

            width:18px;

            height:18px;

            border-radius:50%;

            background:#ef4444;

            color:white;

            font-size:10px;

            display:flex;

            align-items:center;

            justify-content:center;

            font-weight:700;

        }

        /*==============================
            PROFILE
        ==============================*/

        .profile-navbar{

            width:48px;

            height:48px;

            border-radius:50%;

            overflow:hidden;

            display:flex;

            align-items:center;

            justify-content:center;

            transition:.3s;

        }

        .profile-navbar:hover{

            transform:scale(1.05);

        }

        .profile-navbar img{

            width:100%;

            height:100%;

            object-fit:cover;

            border-radius:50%;

            border:3px solid #2563eb;

        }

        .profile-initial{

            width:48px;

            height:48px;

            border-radius:50%;

            background:linear-gradient(
                135deg,
                #2563eb,
                #3b82f6
            );

            color:white;

            display:flex;

            align-items:center;

            justify-content:center;

            font-weight:700;

            font-size:18px;

        }

        main{

            flex:1;

        }

        .container-page{

            padding:35px 0;

        }
        /*==============================
            WELCOME BANNER
        ==============================*/

        .welcome-banner{

            background:linear-gradient(
                135deg,
                #2563eb,
                #3b82f6
            );

            border-radius:28px;

            padding:40px;

            color:white;

            overflow:hidden;

            position:relative;

            box-shadow:0 18px 45px rgba(37,99,235,.25);

            margin-bottom:35px;

        }

        .welcome-banner::before{

            content:'';

            position:absolute;

            width:300px;

            height:300px;

            background:rgba(255,255,255,.08);

            border-radius:50%;

            top:-120px;

            right:-80px;

        }

        .welcome-banner::after{

            content:'';

            position:absolute;

            width:220px;

            height:220px;

            background:rgba(255,255,255,.08);

            border-radius:50%;

            bottom:-100px;

            left:-80px;

        }

        .welcome-banner h2{

            font-size:34px;

            font-weight:700;

            margin-bottom:12px;

            position:relative;

            z-index:2;

        }

        .welcome-banner p{

            font-size:15px;

            opacity:.95;

            line-height:28px;

            position:relative;

            z-index:2;

        }

        .banner-icon{

            font-size:130px;

            opacity:.18;

            position:relative;

            z-index:2;

        }

        /*==============================
            CONTENT
        ==============================*/

        .content-wrapper{

            padding:35px 0 50px;

        }

        /*==============================
            FOOTER
        ==============================*/

        footer{

            margin-top:auto;

            background:white;

            border-top:1px solid #e5e7eb;

            padding:28px;

            text-align:center;

            color:#6b7280;

            font-size:14px;

        }

        /*==============================
            MOBILE
        ==============================*/

        .mobile-bottom-nav{

            display:none;

        }

        @media(max-width:991px){

            .desktop-search{

                display:none;

            }

        }

        @media(max-width:768px){

            .desktop-menu{

                display:none !important;

            }

            .welcome-banner{

                padding:30px;

            }

            .welcome-banner h2{

                font-size:27px;

            }

            .banner-icon{

                display:none;

            }

            .mobile-bottom-nav{

                display:block;

                position:fixed;

                left:0;

                bottom:0;

                width:100%;

                background:white;

                box-shadow:0 -5px 25px rgba(0,0,0,.08);

                padding:10px 0;

                z-index:999;

            }

            body{

                padding-bottom:90px;

            }

        }

    </style>

</head>

<body>

<!-- =========================
     NAVBAR
========================== -->

<nav class="navbar navbar-expand-lg navbar-custom">

    <div class="container">

        <a href="/pelanggan"
           class="logo">

            Beres<span>.in</span>

        </a>

        <!-- SEARCH -->

        <div class="desktop-search flex-grow-1 mx-5">

            <form action="/pelanggan"
                  method="GET">

                <div class="search-box">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari layanan yang Anda butuhkan...">

                </div>

            </form>

        </div>

        <!-- MENU -->

        <div class="desktop-menu d-flex align-items-center gap-3">

            <a href="/pelanggan"
               class="nav-icon">

                <i class="bi bi-house-fill"></i>

            </a>

            <a href="/my-orders"
               class="nav-icon">

                <i class="bi bi-cart-check-fill"></i>

            </a>

            <a href="/notifikasi"
               class="nav-icon">

                <i class="bi bi-bell-fill"></i>

                @if(isset($notificationCount) && $notificationCount>0)

                    <span class="badge-notif">

                        {{ $notificationCount }}

                    </span>

                @endif

            </a>

            <a href="/profile-pelanggan"
               class="profile-navbar">

                @if(Auth::user()->photo)

                    <img
                        src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                        alt="Profile">

                @else

                    <div class="profile-initial">

                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                    </div>

                @endif

            </a>

            <a href="/logout"
               class="nav-icon">

                <i class="bi bi-box-arrow-right"></i>

            </a>

        </div>

    </div>

</nav>

<!-- =========================
     CONTENT
========================== -->

<main>

<div class="container content-wrapper">

    <!-- WELCOME -->

    <div class="welcome-banner">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <h2>

                    Halo,
                    {{ Auth::user()->name }}
                    👋

                </h2>

                <p>

                    Selamat datang di Beres.in. Kelola pesanan,
                    pembayaran, dan laporan aktivitas Anda dengan
                    lebih mudah melalui dashboard customer.

                </p>

            </div>

            <div class="col-lg-4 text-end">

                <i class="bi bi-house-heart-fill banner-icon"></i>

            </div>

        </div>

    </div>
        <!-- PAGE CONTENT -->

    @yield('content')

</div>

</main>

<!-- =========================
     FOOTER
========================= -->

<footer>

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6 text-md-start text-center">

                <h5 class="fw-bold text-primary mb-1">

                    Beres.in

                </h5>

                <small>

                    Solusi Home Service Modern untuk kebutuhan rumah Anda.

                </small>

            </div>

            <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">

                <small>

                    © {{ date('Y') }}

                    Beres.in.

                    All Rights Reserved.

                </small>

            </div>

        </div>

    </div>

</footer>

<!-- =========================
     MOBILE BOTTOM NAVIGATION
========================= -->

<div class="mobile-bottom-nav">

    <div class="container">

        <div class="d-flex justify-content-around align-items-center">

            <a href="/pelanggan"
               class="text-decoration-none text-center">

                <i class="bi bi-house-fill fs-4 text-primary"></i>

                <br>

                <small>Home</small>

            </a>

            <a href="/my-orders"
               class="text-decoration-none text-center">

                <i class="bi bi-cart-check-fill fs-4 text-primary"></i>

                <br>

                <small>Order</small>

            </a>

            <a href="/customer/reports"
               class="text-decoration-none text-center">

                <i class="bi bi-file-earmark-bar-graph-fill fs-4 text-primary"></i>

                <br>

                <small>Laporan</small>

            </a>

            <a href="/profile-pelanggan"
               class="text-decoration-none text-center">

                @if(Auth::user()->photo)

                    <img
                        src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                        style="
                            width:28px;
                            height:28px;
                            border-radius:50%;
                            object-fit:cover;
                            border:2px solid #2563eb;
                        ">

                    <br>

                @else

                    <i class="bi bi-person-circle fs-4 text-primary"></i>

                    <br>

                @endif

                <small>Profil</small>

            </a>

            <a href="/logout"
               class="text-decoration-none text-center">

                <i class="bi bi-box-arrow-right fs-4 text-danger"></i>

                <br>

                <small>Keluar</small>

            </a>

        </div>

    </div>

</div>

<!-- =========================
     SCRIPT
========================= -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    // Highlight menu aktif desktop

    document.querySelectorAll('.nav-icon').forEach(function(item){

        if(item.href === window.location.href){

            item.style.background='#2563eb';

            item.style.color='white';

        }

    });

</script>

</body>

</html>