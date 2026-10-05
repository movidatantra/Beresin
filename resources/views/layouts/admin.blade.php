
<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Beres.in</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f7fb;
            font-family:'Segoe UI',sans-serif;
            overflow-x:hidden;
            min-height:100vh;
            display:flex;
        }

        /* SIDEBAR */

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

            transition:.3s;

            overflow-y:auto;
        }

        .sidebar.hide{
            width:90px;
        }

        .sidebar.hide .logo-text{
            display:none;
        }

        .sidebar.hide .menu span{
            display:none;
        }

        .sidebar.hide .menu a{
            justify-content:center;
        }

        .sidebar.hide .menu i{
            margin-right:0;
            font-size:22px;
        }
        

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
        }

        .menu a{

            display:flex;

            align-items:center;

            padding:15px;

            color:white;

            text-decoration:none;

            border-radius:15px;

            margin-bottom:10px;

            transition:.3s;

            font-weight:500;
        }

        .menu a:hover{

            background:rgba(255,255,255,.15);

        }

        .menu i{

            margin-right:12px;

            font-size:20px;

            min-width:25px;
        }

        /* CONTENT */

        .content{

    margin-left:270px;

    width:100%;

    min-height:100vh;

    padding:30px;

    transition:.3s;

    display:flex;

    flex-direction:column;
}

.content.full{

    margin-left:90px;
}

        /* TOPBAR */

        .topbar{

            background:white;

            border-radius:20px;

            padding:20px 25px;

            margin-bottom:25px;

            box-shadow:0 2px 10px rgba(0,0,0,.05);

            display:flex;

            justify-content:space-between;

            align-items:center;
        }

        .topbar h4{
            margin:0;
            font-weight:700;
        }

        .topbar small{
            color:#6b7280;
        }

        /* ALERT */

        .alert{
            border:none;
            border-radius:15px;
        }

        /* FOOTER */

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
        /* MOBILE */

        @media(max-width:992px){

            .sidebar{
                transform:translateX(-100%);
            }

            .sidebar.active{
                transform:translateX(0);
            }

            .content{
                margin-left:0;
                padding:20px;
            }

            .content.full{
                margin-left:0;
            }

        }

    </style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar"
     id="sidebar">

    <div class="sidebar-header">

        <div class="logo">

            <i class="bi bi-shield-check"></i>

            <span class="logo-text">

                Beres.in

            </span>

        </div>

        <button class="toggle-btn"
                onclick="toggleDesktopSidebar()">

            <i class="bi bi-list"></i>

        </button>

    </div>

    <div class="menu">

    <!-- DASHBOARD -->
    <a href="{{ url('/admin') }}">
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>

    <!-- ========================= -->
    <!-- KELOLA PENGGUNA -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        KELOLA PENGGUNA
    </div>

    <a href="{{ url('/admin/customers') }}">
        <i class="bi bi-people-fill"></i>
        <span>Pelanggan</span>
    </a>

    <a href="{{ url('/admin/manage-mitra') }}">
        <i class="bi bi-shop"></i>
        <span>Mitra</span>
    </a>

    {{-- <a href="{{ url('/admin/admins') }}">
        <i class="bi bi-person-badge-fill"></i>
        <span>Admin</span>
    </a> --}}

    <!-- ========================= -->
    <!-- VERIFIKASI -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        VERIFIKASI
    </div>

    <a href="{{ url('/admin/mitra') }}">
        <i class="bi bi-person-check-fill"></i>
        <span>Verifikasi Mitra</span>
    </a>

    <!-- ========================= -->
    <!-- TRANSAKSI -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        TRANSAKSI
    </div>

  <a href="{{ route('admin.orders') }}">

    <i class="bi bi-box-seam-fill"></i>

    <span>Kelola Order</span>

</a>

    <li class="nav-item">

    <a href="{{ route('admin.pembayaran') }}"
       class="nav-link">

        <i class="bi bi-credit-card-fill"></i>

        <span>Pembayaran</span>

    </a>

</li>

    <a href="{{ route('admin.refunds') }}" class="nav-link">
        <i class="bi bi-arrow-counterclockwise"></i>
        <span>Data Refund</span>
    </a>

    <a href="{{ url('/admin/withdrawals') }}">
        <i class="bi bi-cash-stack"></i>
        <span>Pencairan Saldo</span>
    </a>

    <!-- ========================= -->
    <!-- LAYANAN -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        LAYANAN
    </div>

  

    <li class="nav-item">
    <a href="{{ route('categories.index') }}" class="nav-link">
        <i class="bi bi-grid"></i>
        <span>Kelola Kategori</span>
    </a>
</li>

    <!-- ========================= -->
    <!-- FEEDBACK -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        FEEDBACK
    </div>

    <li class="nav-item">

<a
href="{{ route('admin.reviews') }}"
class="nav-link">

<i class="bi bi-star-fill"></i>

<span>

Ulasan

</span>

</a>

</li>

    <a href="{{ url('/admin/complaints') }}">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>Komplain Pelanggan</span>
    </a>

    <!-- ========================= -->
    <!-- LAPORAN -->
    <!-- ========================= -->

    <div class="text-white-50 small mt-3 mb-2 ps-2">
        LAPORAN
    </div>

    <a href="{{ url('/admin/reports') }}">
        <i class="bi bi-bar-chart-fill"></i>
        <span>Laporan</span>
    </a>

    <!-- ========================= -->
    <!-- SISTEM -->
    <!-- ========================= -->

    {{-- <div class="text-white-50 small mt-3 mb-2 ps-2">
        SISTEM
    </div>

    <a href="{{ url('/admin/notifications') }}">
        <i class="bi bi-bell-fill"></i>
        <span>Notifikasi</span>
    </a>

    <a href="{{ url('/admin/settings') }}">
        <i class="bi bi-gear-fill"></i>
        <span>Pengaturan</span>
    </a> --}}

    <hr class="text-white">

    <a href="{{ url('/logout') }}">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>

</div>

</div>

<!-- CONTENT -->

<div class="content"
     id="content">

    <div class="topbar">

        <div>

            <h4>

                Halo Administrator 👋

            </h4>

            <small>

                Kelola seluruh aktivitas Beres.in

            </small>

        </div>

        <span class="badge bg-primary fs-6 p-2">

            Admin Panel

        </span>

    </div>

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

    <div class="flex-grow-1">

        @yield('content')

    </div>

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

<script>

function toggleDesktopSidebar(){

    document.getElementById('sidebar')
    .classList.toggle('hide');

    document.getElementById('content')
    .classList.toggle('full');

}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

