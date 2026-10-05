<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Beres.in Mitra</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{

            background:#f4f7fb;

            font-family:'Segoe UI', sans-serif;

            overflow-x:hidden;

            min-height:100vh;

            display:flex;

        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar{

    width:270px;

    height:100vh;

    background:linear-gradient(
        to bottom,
        #1e40af,
        #2563eb
    );

    position:fixed;

    left:0;

    top:0;

    padding:25px 20px;

    z-index:9999;

    transition:0.3s ease;

    overflow-y:auto;

    overflow-x:hidden;

    scrollbar-width:thin;

    scrollbar-color:
        rgba(255,255,255,.4)
        transparent;

}

        /* MINI SIDEBAR */

        .sidebar.hide{

            width:90px;

        }

        /* HIDE TEXT */

        .sidebar.hide .logo-text{

            display:none;

        }

        .sidebar.hide .menu a{

            justify-content:center;

        }

        .sidebar.hide .menu a span{

            display:none;

        }

        .sidebar.hide .menu i{

            margin-right:0;

            font-size:22px;

        }

        /* =========================
           HEADER
        ========================= */

        .sidebar-header{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:40px;

        }

        .logo{

            display:flex;

            align-items:center;

            gap:10px;

            color:white;

            font-size:28px;

            font-weight:bold;

        }

        .toggle-btn{

            width:38px;

            height:38px;

            border:none;

            border-radius:50%;

            background:white;

            color:#2563eb;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:18px;

            transition:0.3s;

            flex-shrink:0;

        }

        .toggle-btn:hover{

            background:#dbeafe;

        }

        /* =========================
           MENU
        ========================= */

        .menu a{

            display:flex;

            align-items:center;

            padding:15px;

            color:white;

            text-decoration:none;

            border-radius:15px;

            margin-bottom:10px;

            transition:0.3s;

            font-weight:500;

        }

        .menu a:hover{

            background:rgba(255,255,255,0.15);

        }

        .menu i{

            margin-right:12px;

            font-size:20px;

            min-width:25px;

            text-align:center;

        }

        /* =========================
           CONTENT
        ========================= */

        .content{

            margin-left:270px;

            padding:30px;

            transition:0.3s ease;

            min-height:100vh;

            display:flex;

            flex-direction:column;

            width:100%;

        }

        /* CONTENT FULL */

        .content.full{

            margin-left:90px;

        }

        /* =========================
           OVERLAY
        ========================= */

        .overlay{

            position:fixed;

            top:0;

            left:0;

            width:100%;

            height:100%;

            background:rgba(0,0,0,0.4);

            z-index:999;

            display:none;

        }

        /* =========================
           FOOTER
        ========================= */

        .dashboard-footer{

            margin-top:40px;

            background:white;

            border-top:1px solid #e5e7eb;

            padding:18px 30px;

            display:flex;

            justify-content:space-between;

            align-items:center;

            font-size:14px;

            color:#6b7280;

            width:calc(100% + 60px);

            margin-left:-30px;

            margin-bottom:-30px;

        }

        /* =========================
           MOBILE
        ========================= */

        @media(max-width:992px){

            .sidebar{

                transform:translateX(-100%);

            }

            .sidebar.active{

                transform:translateX(0);

            }

            .overlay.active{

                display:block;

            }

            .content{

                margin-left:0;

                padding:20px;

            }

            .content.full{

                margin-left:0;

            }

        }

        @media(max-width:768px){

            .dashboard-footer{

                flex-direction:column;

                gap:10px;

                text-align:center;

            }

        }

    </style>

</head>
<body>

<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar"
     id="sidebar">

    <!-- HEADER -->

    <div class="sidebar-header">

        <div class="logo">

            <i class="bi bi-house-door-fill"></i>

            <span class="logo-text">
                Beres.in
            </span>

        </div>

        <!-- TOGGLE -->

        <button class="toggle-btn"
                onclick="toggleDesktopSidebar()">

            <i class="bi bi-list"></i>

        </button>

    </div>

    <!-- MENU -->

    <div class="menu">

        <a href="/mitra">

            <i class="bi bi-grid-fill"></i>

            <span>Dashboard</span>

        </a>

        <a href="/services">

            <i class="bi bi-tools"></i>

            <span>Daftar Layanan</span>

        </a>

        <a href="/orders">

    <i class="bi bi-cart-check-fill"></i>

    <span>Kelola Order</span>

</a>

        <a href="/booking-slots">

            <i class="bi bi-calendar-check-fill"></i>

            <span>List Booking Hari Ini</span>

        </a>

        <a href="/history-orders">

    <i class="bi bi-clock-history"></i>

    <span>Riwayat Pekerjaan</span>

</a>

<a href="/pendapatan">

    <i class="bi bi-cash-stack"></i>

    <span>Pendapatan</span>

</a>
<a href="/saldo">

    <i class="bi bi-wallet2"></i>

    <span>Saldo & Pencairan</span>

</a>
<a href="/notifikasi">

    <i class="bi bi-bell"></i>

    <span>Notifikasi</span>

</a>

        <a href="/reviews">

    <i class="bi bi-star-fill"></i>

    <span>Rating & Review</span>

</a>

        <a href="/profile-mitra">

    <i class="bi bi-person-fill"></i>

    <span>Profile Mitra</span>

</a>

<a href="{{ route('mitra.reports.index') }}">

    <i class="bi bi-file-earmark-bar-graph-fill"></i>

    <span>Laporan</span>

</a>

            

        <a href="/logout">

            <i class="bi bi-box-arrow-right"></i>

            <span>Logout</span>

        </a>

    </div>

</div>

<!-- =========================
     OVERLAY
========================= -->

<div class="overlay"
     id="overlay"
     onclick="toggleSidebar()"></div>

<!-- =========================
     CONTENT
========================= -->

<div class="content"
     id="content">

    <div class="flex-grow-1">
        @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif

        @yield('content')

    </div>

    <!-- FOOTER -->

    <footer class="dashboard-footer">

        <div>

            Copyright © 2026

            <span class="fw-bold text-primary">
                Beres.in
            </span>

            All rights reserved.

        </div>

        <div>

            Powered by
            <span class="fw-bold">
                Movida Tantra
            </span>

        </div>

    </footer>

</div>

<!-- =========================
     SCRIPT
========================= -->

<script>

    // MOBILE

    function toggleSidebar(){

        document.getElementById('sidebar')
        .classList.toggle('active');

        document.getElementById('overlay')
        .classList.toggle('active');

    }

    // DESKTOP MINI SIDEBAR

    function toggleDesktopSidebar(){

        document.getElementById('sidebar')
        .classList.toggle('hide');

        document.getElementById('content')
        .classList.toggle('full');

    }

</script>

</body>
</html>