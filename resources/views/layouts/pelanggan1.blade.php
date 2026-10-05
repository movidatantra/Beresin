<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Beres.in Pelanggan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f5f7fb;
            font-family:'Segoe UI', sans-serif;
        }

        /* ======================
           NAVBAR
        ====================== */

        .navbar-custom{
            background:white;
            padding:18px 0;
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
            position:sticky;
            top:0;
            z-index:999;
        }

        .logo{
            font-size:30px;
            font-weight:bold;
            color:#2563eb;
            text-decoration:none;
        }

        .search-input{
            border:none;
            background:#f3f4f6;
            border-radius:50px;
            padding:12px 20px;
            width:100%;
        }

        .search-input:focus{
            outline:none;
        }

        .nav-icon{
            width:45px;
            height:45px;
            background:#eff6ff;
            color:#2563eb;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
            transition:0.3s;
            text-decoration:none;
        }

        .nav-icon:hover{
            background:#2563eb;
            color:white;
        }

        /* ======================
           PROFILE PHOTO
        ====================== */

        .profile-navbar{
            width:45px;
            height:45px;
            border-radius:50%;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
        }

        .profile-navbar img{
            width:100%;
            height:100%;
            object-fit:cover;
            border-radius:50%;
            border:2px solid #2563eb;
        }

        .profile-initial{
            width:45px;
            height:45px;
            border-radius:50%;
            background:#2563eb;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:18px;
        }

        /* ======================
           CONTENT
        ====================== */

        main{
            flex:1;
        }

        /* ======================
           MOBILE MENU
        ====================== */

        .mobile-bottom-nav{
            position:fixed;
            bottom:0;
            left:0;
            width:100%;
            background:white;
            box-shadow:0 -2px 20px rgba(0,0,0,0.08);
            padding:10px 0;
            z-index:999;
            display:none;
        }

        .mobile-menu{
            display:flex;
            justify-content:space-around;
        }

        .mobile-menu a{
            text-decoration:none;
            color:#6b7280;
            font-size:13px;
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .mobile-menu i{
            font-size:22px;
            margin-bottom:4px;
        }

        .mobile-menu .active{
            color:#2563eb;
        }

        /* ======================
           FOOTER
        ====================== */

        footer{
            background:white;
            padding:25px;
            text-align:center;
            color:#6b7280;
            border-top:1px solid #eee;
        }

        @media(max-width:992px){

            .desktop-search{
                display:none;
            }

        }

        @media(max-width:768px){

            .desktop-menu{
                display:none !important;
            }

            .mobile-bottom-nav{
                display:block;
            }

            body{
                padding-bottom:80px;
            }

        }

    </style>

</head>

<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-custom">

    <div class="container">

        <a href="/pelanggan"
           class="logo">

            Beres.in

        </a>

        <!-- SEARCH -->

        <div class="desktop-search flex-grow-1 mx-4">

            <form action="/pelanggan"
                  method="GET">

                <input type="text"
                       name="search"
                       placeholder="Cari layanan..."
                       class="search-input">

            </form>

        </div>

        <!-- DESKTOP MENU -->

        <div class="desktop-menu d-flex align-items-center gap-3">

            <a href="/pelanggan"
               class="nav-icon">

                <i class="bi bi-house-fill"></i>

            </a>

            <a href="/my-orders"
               class="nav-icon">

                <i class="bi bi-cart-check-fill"></i>

            </a>

            <!-- PROFILE FOTO -->

            <a href="/profile-pelanggan"
               class="profile-navbar">

                @if(Auth::user()->photo)

                    <img src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
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

<!-- CONTENT -->

<main>

    @yield('content')

</main>

<!-- FOOTER -->

<footer>

    © 2026 Beres.in — Solusi Home Service Modern

</footer>

<!-- MOBILE MENU -->

<div class="mobile-bottom-nav">

    <div class="mobile-menu">

        <a href="/pelanggan"
           class="active">

            <i class="bi bi-house-fill"></i>

            Home

        </a>

        <a href="/my-orders">

            <i class="bi bi-cart-check-fill"></i>

            Order

        </a>

        <a href="/profile-pelanggan">

            @if(Auth::user()->photo)

                <img src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                     width="28"
                     height="28"
                     style="border-radius:50%;object-fit:cover;">

            @else

                <i class="bi bi-person-fill"></i>

            @endif

            Profile

        </a>

        <a href="/logout">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</div>

<!-- jQuery -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>


</body>
</html>