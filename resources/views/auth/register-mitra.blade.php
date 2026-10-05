<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register Mitra Beres.in</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

          <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>

        body{

            background:#f4f7fb;

            font-family:'Segoe UI', sans-serif;

            overflow-x:hidden;

        }

        /* =========================
           LEFT SIDE
        ========================= */

        .left-side{

            background:linear-gradient(135deg,#2563eb,#1e40af);

            min-height:100vh;

            color:white;

            padding:60px;

            position:relative;

            overflow:hidden;

        }

        .left-side::before{

            content:'';

            position:absolute;

            width:400px;

            height:400px;

            background:rgba(255,255,255,0.08);

            border-radius:50%;

            top:-100px;

            right:-100px;

        }

        .left-side::after{

            content:'';

            position:absolute;

            width:250px;

            height:250px;

            background:rgba(255,255,255,0.06);

            border-radius:50%;

            bottom:-80px;

            left:-80px;

        }

        .logo{

            font-size:40px;

            font-weight:bold;

            margin-bottom:25px;

            position:relative;

            z-index:2;

        }

        .hero-title{

            font-size:42px;

            font-weight:bold;

            line-height:1.3;

            margin-bottom:20px;

            position:relative;

            z-index:2;

        }

        .hero-text{

            color:rgba(255,255,255,0.85);

            font-size:17px;

            margin-bottom:40px;

            position:relative;

            z-index:2;

        }

        .feature-box{

            background:rgba(255,255,255,0.1);

            border:1px solid rgba(255,255,255,0.15);

            padding:18px 20px;

            border-radius:20px;

            margin-bottom:18px;

            display:flex;

            align-items:center;

            gap:15px;

            backdrop-filter:blur(10px);

            position:relative;

            z-index:2;

        }

        .feature-icon{

            width:50px;

            height:50px;

            border-radius:15px;

            background:white;

            color:#2563eb;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:22px;

        }

        /* =========================
           RIGHT SIDE
        ========================= */

        .right-side{

            padding:50px;

        }

        .register-card{

            border:none;

            border-radius:30px;

            box-shadow:0 10px 40px rgba(0,0,0,0.08);

        }

        .form-title{

            font-size:32px;

            font-weight:bold;

            margin-bottom:10px;

        }

        .form-subtitle{

            color:#6b7280;

            margin-bottom:35px;

        }

        .form-control,
        .form-select{

            border-radius:16px;

            padding:14px 18px;

            border:1px solid #dbeafe;

        }

        .form-control:focus,
        .form-select:focus{

            box-shadow:none;

            border-color:#2563eb;

        }

        .input-group-text{

            border-radius:16px 0 0 16px;

            background:#eff6ff;

            border:1px solid #dbeafe;

            color:#2563eb;

        }

        textarea{

            resize:none;

        }

        .btn-register{

            background:#2563eb;

            border:none;

            color:white;

            padding:15px;

            border-radius:16px;

            font-weight:600;

            transition:0.3s;

        }

        .btn-register:hover{

            background:#1d4ed8;

        }

        .login-link{

            text-decoration:none;

            color:#2563eb;

            font-weight:600;

        }

        /* MOBILE */

        @media(max-width:992px){

            .left-side{

                min-height:auto;

                padding:40px 30px;

            }

            .hero-title{

                font-size:32px;

            }

            .right-side{

                padding:25px;

            }
            

        }

        .is-invalid{
    border:2px solid #dc3545 !important;
    background:#fff5f5;
}

.error-text{
    color:#dc3545;
    font-size:14px;
    margin-top:5px;
}

    </style>

</head>
<body>

<div class="container-fluid">

    <div class="row">

        <!-- LEFT -->

        <div class="col-lg-5 left-side d-flex flex-column justify-content-center">

            <div class="logo">

                Beres.in

            </div>

            <div class="hero-title">

                Jadi Mitra Profesional Bersama Beres.in 🚀

            </div>

            <div class="hero-text">

                Kelola layanan jasa rumah tangga dengan lebih modern,
                praktis, dan terpercaya.

            </div>

            <!-- FEATURES -->

            <div class="feature-box">

                <div class="feature-icon">

                    <i class="bi bi-phone"></i>

                </div>

                <div>

                    <div class="fw-bold">

                        Order Online

                    </div>

                    <small>

                        Terima pesanan langsung dari pelanggan

                    </small>

                </div>

            </div>

            <div class="feature-box">

                <div class="feature-icon">

                    <i class="bi bi-star-fill"></i>

                </div>

                <div>

                    <div class="fw-bold">

                        Rating & Review

                    </div>

                    <small>

                        Bangun reputasi layanan profesional

                    </small>

                </div>

            </div>

            <div class="feature-box">

                <div class="feature-icon">

                    <i class="bi bi-graph-up-arrow"></i>

                </div>

                <div>

                    <div class="fw-bold">

                        Tingkatkan Penghasilan

                    </div>

                    <small>

                        Perluas jangkauan bisnis jasa Anda

                    </small>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-7 right-side d-flex align-items-center">

            <div class="card register-card w-100">

                <div class="card-body p-4 p-lg-5">

                    <div class="form-title">

                        Register Mitra

                    </div>

                    <div class="form-subtitle">
                        @if(session('error'))

<div class="alert alert-danger">

    <i class="bi bi-exclamation-circle"></i>

    {{ session('error') }}

</div>

@endif

                        Lengkapi data untuk bergabung menjadi mitra Beres.in

                    </div>

                    <form id="registerForm"
                    action="/register-mitra"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="row">
<!---INFORMASI AKUN--->
<div class="card shadow-sm border-1 mb-4">

    <div class="card-body">

        <h5 class="fw-bold text-primary mb-4">
            <i class="bi bi-person-circle"></i>
            Informasi Akun
        </h5>

        <!-- NAMA -->



                            <div class="col-md-20 mb-4">

                                <label class="fw-semibold mb-2">

                                    Nama Lengkap

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-person"></i>

                                    </span>

                                    <input type="text"
       name="name"
       value="{{ old('name') }}"
       class="form-control"  required>

                                </div>

                            </div>

                            

                            <!-- EMAIL -->

                            <div class="col-md-20 mb-4">

                                <label class="fw-semibold mb-2">

                                    Email

                                </label>

                                <div class="input-group">

    <span class="input-group-text">
        <i class="bi bi-envelope"></i>
    </span>

    <input type="email"
       id="email"
       name="email"
       value="{{ old('email') }}"
       class="form-control"  required>

    <button type="button"
            class="btn btn-outline-primary"
            id="verifyEmail">

        Verifikasi

    </button>

</div>

<small id="emailStatus"></small>
                                

                            </div>









                            

                            <!-- PHONE -->

                            <div class="col-md-20 mb-4">

                                <label class="fw-semibold mb-2">

                                    Nomor HP

                                </label>

                                
                                <div class="input-group">

    <span class="input-group-text">
        <i class="bi bi-whatsapp"></i>
    </span>

   <input type="text"
       id="phone"
       name="phone"
       value="{{ old('phone') }}"
       class="form-control" required>

    <button type="button"
            class="btn btn-outline-success"
            id="verifyPhone">

        Verifikasi

    </button>

</div>

<small id="phoneStatus"></small>

                            </div>

                            <!-- PASSWORD -->

                            <div class="col-md-20 mb-4">

                                <label class="fw-semibold mb-2">

                                    Password

                                </label>

                                <input type="password"
       id="password"
       name="password"
       minlength="8"
       class="form-control"  required>

<small id="passwordError"
       class="text-danger d-none">

Password minimal 8 karakter

</small>

                            </div>

                            <!-- KONFIRMASI -->

                            <div class="col-md-20 mb-4">

                                <label class="fw-semibold mb-2">

                                    Konfirmasi Password

                                </label>

                                <input type="password"
       id="password_confirmation"
       name="password_confirmation"
       class="form-control"  required>

<small id="confirmError"
       class="text-danger d-none">

Konfirmasi password tidak sama

</small>

                            </div>

                        </div>

    </div>

</div>

<!----INFORMASI PRIBADI---------->
<div class="card shadow-sm border-1 mb-4">

    <div class="card-body">

        <h5 class="fw-bold text-primary mb-4">
            <i class="bi bi-geo-alt-fill"></i>
            Informasi Pribadi
        </h5>

       <!---NIK--->
                            <div class="col-md-20 mb-4">
    <label class="fw-semibold mb-2">
        NIK
    </label>

    <input type="text"
       id="nik"
       name="nik"
       value="{{ old('nik') }}"
       maxlength="16"       
       class="form-control"
       placeholder="Masukkan NIK"  required>

<small id="nikError"
       class="text-danger d-none">
    NIK harus 16 digit angka
</small>
</div>

<!------FOTO KTP--->

                        <div class="mb-4">
    <label class="fw-semibold mb-2">
        Foto KTP
    </label>

    <input type="file"
            id="_ktp_photo"
           name="ktp_photo"
           accept="image/*"
           class="form-control">

           <div class="alert alert-info mt-2">

    Pastikan:
    <ul class="mb-0">
        <li>KTP terlihat utuh</li>
        <li>Data terbaca jelas</li>
        <li>Tidak blur</li>
        <li>Tidak terpotong</li>
    </ul>

</div>
</div>

<!-- TEMPAT & TANGGAL LAHIR -->

<div class="row">

    <div class="col-md-6 mb-4">

        <label class="fw-semibold mb-2">
            Tempat Lahir
        </label>

        <input type="text"
               name="birth_place"
               class="form-control"
               placeholder="Contoh: Tegal"
               required>

    </div>

    <div class="col-md-6 mb-4">

        <label class="fw-semibold mb-2">
            Tanggal Lahir
        </label>

        <input type="date"
               name="birth_date"
               class="form-control"
               required>

    </div>

</div>
<div class="col-12 mb-4">

    

    <div class="row">

        <div class="col-md-4 mb-3">

            <label class="fw-semibold mb-3 d-block">
        Provinsi
    </label>

            <select id="provinsi"
                    name="kd_prov"
                    class="form-select">

                <option value="">
                    Pilih Provinsi
                </option>

                @foreach($provinces as $prov)

                    <option value="{{ $prov->kd_prov }}">
                        {{ $prov->nama_prov }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-4 mb-3">

            <label class="fw-semibold mb-3 d-block">
        Kota/Kabupaten
    </label>
            <select id="kabupaten"
                    name="kd_kab"
                    class="form-select">

                <option value="">
                    Pilih Kabupaten
                </option>

            </select>

        </div>

        <div class="col-md-4 mb-3">

             <label class="fw-semibold mb-3 d-block">
        Kecamatan
    </label>

            <select id="kecamatan"
                    name="kd_kec"
                    class="form-select">

                <option value="">
                    Pilih Kecamatan
                </option>

            </select>

        </div>

    </div>

</div>

<!-- EXPERIENCE -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Pengalaman Kerja

                            </label>

                            <input type="text"
                                   name="experience"
                                   placeholder="Contoh: 3 Tahun"
                                   class="form-control"  required>

                        </div>

<!-- ALAMAT -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Alamat Rumah Lengkap

                            </label>

                            <textarea name="address"
                                      rows="3"
                                      class="form-control" required></textarea>

                        </div>

                        <!-- FOTO -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Foto Profile

                            </label>

                            <input type="file"
       id="photo_profile"
       name="photo"
       accept="image/*"
       class="form-control">

                        </div>
                        <div class="alert alert-info mt-2">

    Pastikan:
    <ul class="mb-0">
        <li>Pastikan foto menampilkan wajah dengan jelas dan menghadap ke depan</li>
        <li>Gunakan pencahayaan yang cukup agar wajah Anda terlihat jelas</li>
        <li>Jangan gunakan masker, topi, atau kacamata hitam yang menutupi wajah</li>
        <li>Pastikan foto yang anda unggah berformat JPG, JPEG, atau PNG</li>
    </ul>

</div>

    </div>

</div>




<!----USAHA--->
<div class="card shadow-sm border-2 mb-4">

    <div class="card-body">

        <h5 class="fw-bold text-primary mb-4">
            <i class="bi bi-tools"></i>
            Informasi Bidang Usaha
        </h5>

        <!-- Semua field keahlian -->

         <!-- NAMA USAHA -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Nama Usaha

                            </label>

                            <input type="text"
                                   name="business_name"
                                   class="form-control" required>

                        </div>

                        <!-- SPESIALISASI -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Spesialisasi

                            </label>

                            <select
    id="specialization"
    name="specialization"
    class="form-select">

                                <option value="AC"
    {{ old('specialization') == 'AC' ? 'selected' : '' }}>
    Service AC
</option>

<option value="Mesin Cuci"
    {{ old('specialization') == 'Mesin Cuci' ? 'selected' : '' }}>
    Service Mesin Cuci
</option>

                            </select>

                        </div>

                         <!-- GPS -->

<div class="mb-4">

    <label class="fw-semibold mb-2">

        Titik Lokasi Usaha

    </label>

    <div class="d-flex gap-2">

        <input type="text"
               id="latitude"
               name="latitude"
               placeholder="Latitude"
               readonly
               class="form-control">

        <input type="text"
               id="longitude"
               name="longitude"
               placeholder="Longitude"
               readonly
               class="form-control">

    </div>

    <button type="button"
            class="btn btn-outline-primary mt-3 rounded-pill"
            onclick="getLocation()">

        <i class="bi bi-geo-alt-fill"></i>

        Ambil Lokasi Saya

    </button>

</div>

<!-- ALAMAT -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Alamat Lengkap Tempat Usaha 

                            </label>

                            <textarea name="address"
                                      rows="3"
                                      class="form-control"></textarea>

                        </div>
                        

<!-- DESKRIPSI -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Deskripsi Jenis Usaha

                            </label>

                            <textarea name="description"
          rows="5"
          class="form-control">{{ old('description') }}</textarea>

                        </div>

   <!---------------- OPERASIONAL ---------------->

<div class="row">

    <!-- JAM BUKA -->
    <div class="col-md-6 mb-4">

        <label class="fw-semibold mb-2">
            Jam Mulai Operasional
        </label>

        <input type="time"
               name="open_time"
               class="form-control">

    </div>

    <!-- JAM TUTUP -->
    <div class="col-md-6 mb-4">

        <label class="fw-semibold mb-2">
            Jam Selesai Operasional
        </label>

        <input type="time"
               name="close_time"
               class="form-control">

    </div>

</div>


<!---------------- HARI LIBUR ---------------->

<div class="mb-4">

    <label class="fw-semibold mb-2">
        Hari Libur
    </label>

    <select
    name="holiday"
    class="form-select">

        <option value="">
            -- Pilih Hari Libur --
        </option>

        <option value="tidak_ada">
            Tidak Ada Hari Libur
        </option>

        <option value="senin">
            Senin
        </option>

        <option value="selasa">
            Selasa
        </option>

        <option value="rabu">
            Rabu
        </option>

        <option value="kamis">
            Kamis
        </option>

        <option value="jumat">
            Jumat
        </option>

        <option value="sabtu">
            Sabtu
        </option>

        <option value="minggu">
            Minggu
        </option>

    </select>

</div>


<!---------------- MEDIA SOSIAL ---------------->

<h6 class="fw-bold text-secondary mt-4 mb-3">
    <i class="bi bi-share-fill"></i>
    Media Sosial Usaha
</h6>

<!-- INSTAGRAM -->
<div class="mb-3">

    <label class="fw-semibold mb-2">
        URL Instagram
    </label>

    <input type="url"
           name="instagram_url"
           class="form-control"
           placeholder="https://instagram.com/username">

</div>

<!-- FACEBOOK -->
<div class="mb-3">

    <label class="fw-semibold mb-2">
        URL Facebook
    </label>

    <input type="url"
           name="facebook_url"
           class="form-control"
           placeholder="https://facebook.com/username">

</div>

<!-- TIKTOK -->
<div class="mb-4">

    <label class="fw-semibold mb-2">
        URL TikTok
    </label>

    <input type="url"
           name="tiktok_url"
           class="form-control"
           placeholder="https://tiktok.com/@username">

</div>


<!---------------- GARANSI JASA ---------------->

<div class="card border-primary bg-light mb-4">

    <div class="card-body">

        <div class="form-check form-switch">

            <input class="form-check-input"
                   type="checkbox"
                   id="serviceWarranty"
                   name="service_warranty"
                   value="1">

            <label class="form-check-label fw-bold"
                   for="serviceWarranty">

                Aktifkan Garansi Jasa

            </label>

        </div>

        <small class="text-muted">
            Berikan jaminan kualitas layanan kepada pelanggan.
        </small>

        <div id="warrantyInfo"
             class="alert alert-warning mt-3 d-none">

            <i class="bi bi-shield-check"></i>

            <strong>
                20% dari transaksi akan ditahan sebagai jaminan garansi
                dan akan dilepas ke mitra setelah masa garansi berakhir
                atau pelanggan tidak melakukan klaim garansi.
            </strong>

        </div>

    </div>

</div>

<!---------------- FOTO TEMPAT USAHA ---------------->

<div class="card border-0 bg-light mb-4">

    <div class="card-body">

        <h6 class="fw-bold text-secondary mb-3">
            <i class="bi bi-building"></i>
            Foto Tempat Usaha
        </h6>

        <label class="fw-semibold mb-2">
            Upload Foto Bangunan Tempat Usaha
        </label>

        <input type="file"
                id="photo_bussiness"
               name="business_photo"
               class="form-control"
               accept="image/*">

        <small class="text-muted">
            Upload foto bagian depan tempat usaha untuk meningkatkan
            kepercayaan pelanggan.
        </small>

    </div>

</div>


<!---------------- PORTOFOLIO PEKERJAAN ---------------->

<div class="card border-0 bg-light mb-4">

    <div class="card-body">

        <h6 class="fw-bold text-secondary mb-3">
            <i class="bi bi-images"></i>
            Dokumentasi Pekerjaan Sebelumnya
        </h6>

        <label class="fw-semibold mb-2">
            Upload Dokumentasi Pekerjaan
        </label>

        <input type="file"
               name="portfolio_photos[]"
               class="form-control"
               accept="image/*"
               multiple>

        <small class="text-muted">
            Upload beberapa foto hasil pekerjaan sebelumnya
            (maksimal 10 foto).
        </small>

    </div>

</div>



    </div>

</div>








                            

                            


                           
                            

                       

                        
                        

                        

                        

<!--REKENING PENARIKAN--->
<!-- INFORMASI PENCAIRAN SALDO -->

<div class="card border-1 shadow-sm mb-4">

    <div class="card-body">

        <h5 class="fw-bold text-primary mb-2">

            <i class="bi bi-wallet2"></i>
            Informasi Pencairan Saldo

        </h5>

        <p class="text-muted small mb-4">

            Saldo hasil pekerjaan akan dicairkan ke rekening yang Anda daftarkan.

        </p>

        <div class="mb-4">

    <label class="fw-semibold mb-2">

        Metode Pencairan

    </label>

    <div class="form-check">

        <input
            class="form-check-input"
            type="radio"
            name="withdraw_type"
            id="bankRadio"
            value="bank"
            checked>

        <label class="form-check-label">

            Rekening Bank

        </label>

    </div>

    <div class="form-check">

        <input
            class="form-check-input"
            type="radio"
            name="withdraw_type"
            id="ewalletRadio"
            value="ewallet">

        <label class="form-check-label">

            E-Wallet

        </label>

    </div>

</div>

        <!-- NAMA BANK -->

        <div id="bankSection">

<label class="fw-semibold">

Nama Bank

</label>

<select
    id="bank"
    name="bank_id"
    class="form-select">

<option value="">
    Pilih Bank
</option>

@foreach($banks as $bank)

<option
    value="{{ $bank->id }}"
    data-brick="{{ $bank->brick_code }}">

    {{ $bank->nama_bank }}

</option>

@endforeach

</select>

</div>


<!---E WALLET--->
<div id="ewalletSection" style="display:none;">

<label class="fw-semibold">

Nama E-Wallet

</label>

<select
    id="ewallet"
    name="ewallet_id"
    class="form-select">

    <option value="">Pilih E-Wallet</option>

    @foreach($ewallets as $ewallet)

        <option
            value="{{ $ewallet->id }}"
            data-brick="{{ $ewallet->brick_code }}">

            {{ $ewallet->nama_wallet }}

        </option>

    @endforeach

</select>

</div>
<br>
        <!-- NOMOR REKENING -->

        <div class="mb-3">

            <label class="fw-semibold mb-2">

                Nomor Rekening / Nomor HP

            </label>

            <!-- NOMOR REKENING / NOMOR HP -->

<div class="mb-3">

    

    <input
        type="text"
        name="withdraw_number"
        id="withdraw_number"
        required
        class="form-control"
        placeholder="Masukkan nomor rekening atau nomor HP">

</div>

        </div>

        <!-- NAMA PEMILIK -->

        <div class="mb-0">

            <label class="fw-semibold mb-2">

                Nama Pemilik Rekening

            </label>

           <input
    type="text"
    name="withdraw_name"
    id="withdraw_name"
    class="form-control"
    placeholder="Nama pemilik akan muncul otomatis"
    readonly
    required>

        </div>

    </div>

</div>

                        

                        <!-- BUTTON -->

                        <button class="btn btn-register w-100">

                            Daftar Sebagai Mitra

                        </button>

                    </form>

                    <!-- LOGIN -->

                    <div class="text-center mt-4">

                        Sudah punya akun?

                        <a href="/login"
                           class="login-link">

                            Login Sekarang

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>

function getLocation(){

    if(navigator.geolocation){

        navigator.geolocation.getCurrentPosition(

            function(position){

                document.getElementById('latitude').value =
                position.coords.latitude;

                document.getElementById('longitude').value =
                position.coords.longitude;

                Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Lokasi berhasil diambil',
    timer: 1500,
    showConfirmButton: false
});

            },

            function(){

                Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Gagal mengambil lokasi'
});

            }

        );

    }else{

        Swal.fire({
    icon: 'warning',
    title: 'Browser Tidak Mendukung',
    text: 'Browser Anda tidak mendukung fitur GPS'
});

    }
    

}

</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$('#provinsi').change(function(){

    let kd_prov = $(this).val();

    kabupatenSelect.clear();
    kabupatenSelect.clearOptions();

    kabupatenSelect.addOption({
        value: '',
        text: 'Loading...'
    });

    kabupatenSelect.setValue('');
    kabupatenSelect.refreshOptions(false);

    $.get('/kabupaten/' + kd_prov, function(data){

        kabupatenSelect.clearOptions();

        kabupatenSelect.addOption({
            value:'',
            text:'Pilih Kabupaten'
        });

        data.forEach(function(item){

            kabupatenSelect.addOption({
                value:item.kd_kab,
                text:item.nama_kab
            });

        });

        kabupatenSelect.refreshOptions(false);

    });

});

$('#kabupaten').change(function(){

    let kd_kab = $(this).val();

    kecamatanSelect.clear();
    kecamatanSelect.clearOptions();

    kecamatanSelect.addOption({
        value:'',
        text:'Loading...'
    });

    kecamatanSelect.setValue('');
    kecamatanSelect.refreshOptions(false);

    $.get('/kecamatan/' + kd_kab, function(data){

        kecamatanSelect.clearOptions();

        kecamatanSelect.addOption({
            value:'',
            text:'Pilih Kecamatan'
        });

        data.forEach(function(item){

            kecamatanSelect.addOption({
                value:item.kd_kec,
                text:item.nama_kec
            });

        });

        kecamatanSelect.refreshOptions(false);

    });

});

</script>
<script>

$('#nik').on('input', function(){

    let nik = $(this).val();

    nik = nik.replace(/\D/g,'');

    $(this).val(nik);

    if(nik.length > 0 && nik.length < 16)
    {
        $('#nikError').removeClass('d-none');
    }
    else
    {
        $('#nikError').addClass('d-none');
    }

});

</script>
<script>
$('#verifyEmail').click(function(){

    $('#verifyEmail')
        .html('Mengirim...')
        .prop('disabled', true);

    $.ajax({

        url:'/send-email-otp',
        type:'POST',

        data:{
            _token:'{{ csrf_token() }}',
            email:$('#email').val()
        },

       success:function(){

    $('#verifyEmail')
        .html('Kirim Ulang OTP')
        .prop('disabled', false)
        .removeClass('btn-outline-primary')
        .addClass('btn-success');

    let modal = new bootstrap.Modal(
        document.getElementById('emailOtpModal')
    );

    modal.show();

    startEmailCountdown();

},

        error:function(){

            $('#verifyEmail')
                .html('Verifikasi')
                .prop('disabled', false);

            Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: 'OTP WhatsApp gagal dikirim',
    confirmButtonColor: '#16a34a'
});

        }

    });

});
</script>
<script>
$(document).on('click', '#checkEmailOtp', function(){

    console.log('Tombol OTP diklik');

    $.ajax({

        url:'/verify-email-otp',

        type:'POST',

        data:{
            _token:'{{ csrf_token() }}',
            otp:$('#emailOtp').val()
        },

        success:function(res){

            console.log(res);

            if(res.success)
            {

                $('#emailStatus')
                    .html('✓ Email berhasil diverifikasi')
                    .removeClass('text-danger')
                    .addClass('text-success');

                bootstrap.Modal
                    .getInstance(
                        document.getElementById('emailOtpModal')
                    )
                    .hide();

            }
            else
            {

                Swal.fire({
    icon: 'error',
    title: 'OTP Salah',
    text: 'Kode OTP email yang Anda masukkan tidak valid',
    confirmButtonColor: '#2563eb'
});

            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

            Swal.fire({
    icon:'error',
    title:'Oops...',
    text:'Terjadi kesalahan sistem'
});

        }

    });

});
</script>

<script>
    $('#verifyPhone').click(function(){

    let btn = $(this);

    btn
        .html('Mengirim...')
        .prop('disabled', true);

    $.ajax({

        url:'/send-phone-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            phone:$('#phone').val()

        },

        success:function(){

    btn
        .html('Kirim Ulang OTP')
        .prop('disabled', false)
        .removeClass('btn-outline-success')
        .addClass('btn-success');

    let modal = new bootstrap.Modal(

        document.getElementById(
            'phoneOtpModal'
        )

    );

    modal.show();

    startPhoneCountdown();

},

        error:function(){

            btn
                .html('Verifikasi')
                .prop('disabled', false);

            Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: 'OTP email gagal dikirim',
    confirmButtonColor: '#2563eb'
});

        }

    });

});

$(document).on(

    'click',

    '#checkPhoneOtp',

    function(){

        $.ajax({

            url:'/verify-phone-otp',

            type:'POST',

            data:{

                _token:'{{ csrf_token() }}',

                otp:$('#phoneOtp').val()

            },

            success:function(res){

                if(res.success)
                {

                    $('#phoneStatus')

                        .html(
                            '✓ Nomor HP berhasil diverifikasi'
                        )

                        .addClass('text-success');

                    bootstrap.Modal
                        .getInstance(
                            document.getElementById(
                                'phoneOtpModal'
                            )
                        )
                        .hide();

                }
                else
                {

                    Swal.fire({
    icon: 'error',
    title: 'OTP Salah',
    text: 'Kode OTP WhatsApp tidak valid',
    confirmButtonColor: '#16a34a'
});

                }

            }

        });

    }

);
    </script>
    <script>
        $('#password').on('input', function(){

    if($(this).val().length < 8)
    {
        $('#passwordError').removeClass('d-none');
    }
    else
    {
        $('#passwordError').addClass('d-none');
    }

});
        </script>
        <script>
            $('#password, #password_confirmation').on('keyup', function(){

    let pw = $('#password').val();

    let cpw = $('#password_confirmation').val();

    if(cpw.length > 0 && pw !== cpw)
    {
        $('#confirmError').removeClass('d-none');
    }
    else
    {
        $('#confirmError').addClass('d-none');
    }

});
            </script>

            <script>
    const warrantyCheckbox =
        document.getElementById('serviceWarranty');

    const warrantyInfo =
        document.getElementById('warrantyInfo');

    warrantyCheckbox.addEventListener('change', function () {

        if (this.checked) {
            warrantyInfo.classList.remove('d-none');
        } else {
            warrantyInfo.classList.add('d-none');
        }

    });
</script>


<!-- MODAL OTP EMAIL -->
<!-- MODAL OTP EMAIL -->

<div class="modal fade"
     id="emailOtpModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">

                <h5 class="fw-bold">

                    Verifikasi Email

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <i class="bi bi-envelope-check-fill
                          text-primary"
                   style="font-size:60px">
                </i>

                <p class="mt-3 text-muted">

                    Kode OTP telah dikirim ke email Anda

                </p>

                <input type="text"
                       id="emailOtp"
                       class="form-control text-center"
                       maxlength="6"
                       placeholder="Masukkan 6 digit OTP">

                <div class="mt-3">

                    <small id="emailCountdown"
       class="text-muted">

    Kirim ulang OTP dalam 60 detik

</small>

<br>

<button
    type="button"
    id="resendEmailOtp"
    class="btn btn-link d-none">

    Kirim Ulang OTP

</button>

                </div>

            </div>

            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-primary w-100"
                        id="checkEmailOtp">

                    Verifikasi OTP

                </button>

            </div>

        </div>

    </div>

</div>


<!-- MODAL OTP WHATSAPP -->

<div class="modal fade"
     id="phoneOtpModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">

                <h5 class="fw-bold">

                    Verifikasi WhatsApp

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <i class="bi bi-whatsapp text-success"
                   style="font-size:60px">
                </i>

                <p class="mt-3 text-muted">

                    Kode OTP telah dikirim ke WhatsApp Anda

                </p>
                <input
    type="text"
    id="phoneOtp"
    class="form-control text-center"
    maxlength="6"
    placeholder="Masukkan 6 digit OTP">

                <div class="mt-3">

    <small id="phoneCountdown"
           class="text-muted">

        Kirim ulang OTP dalam 60 detik

    </small>

</div>

<button
    type="button"
    id="resendPhoneOtp"
    class="btn btn-link d-none">

    Kirim Ulang OTP

</button>

            </div>

            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-success w-100"
                        id="checkPhoneOtp">

                    Verifikasi OTP

                </button>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>

const provinsiSelect = new TomSelect("#provinsi",{
    create:false
});

const kabupatenSelect = new TomSelect("#kabupaten",{
    create:false
});

const kecamatanSelect = new TomSelect("#kecamatan",{
    create:false
});

const bankSelect = new TomSelect("#bank",{
    create:false
});

const ewalletSelect = new TomSelect("#ewallet",{
    create:false
});

const specializationSelect = new TomSelect("#specialization",{
    create:false
});

const holidaySelect = new TomSelect("#holiday",{
    create:false
});

</script>



<script>

let emailTimer;
let phoneTimer;

function startEmailCountdown(){

    clearInterval(emailTimer);

    let time = 60;

    $('#resendEmailOtp').addClass('d-none');

    $('#emailCountdown')
        .removeClass('d-none')
        .text(
            'Kirim ulang OTP dalam 60 detik'
        );

    emailTimer = setInterval(function(){

        time--;

        $('#emailCountdown')
            .text(
                'Kirim ulang OTP dalam '
                + time +
                ' detik'
            );

        if(time <= 0)
        {
            clearInterval(emailTimer);

            $('#emailCountdown')
                .addClass('d-none');

            $('#resendEmailOtp')
                .removeClass('d-none');
        }

    },1000);

}


function startPhoneCountdown(){

    clearInterval(phoneTimer);

    let time = 60;

    $('#resendPhoneOtp').addClass('d-none');

    $('#phoneCountdown')
        .removeClass('d-none')
        .text(
            'Kirim ulang OTP dalam 60 detik'
        );

    phoneTimer = setInterval(function(){

        time--;

        $('#phoneCountdown')
            .text(
                'Kirim ulang OTP dalam '
                + time +
                ' detik'
            );

        if(time <= 0)
        {
            clearInterval(phoneTimer);

            $('#phoneCountdown')
                .addClass('d-none');

            $('#resendPhoneOtp')
                .removeClass('d-none');
        }

    },1000);

}

</script>
<script>

$('#resendEmailOtp').click(function(){

    $.ajax({

        url:'/send-email-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            email:$('#email').val()

        },

        success:function(){

            Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'OTP email berhasil dikirim ulang',
    timer: 2000,
    showConfirmButton: false
});

            startEmailCountdown();

        }

    });

});

</script>

<script>

$('#resendPhoneOtp').click(function(){

    $.ajax({

        url:'/send-phone-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            phone:$('#phone').val()

        },

        success:function(){

            Swal.fire({
    icon:'success',
    title:'Berhasil!',
    text:'OTP WhatsApp berhasil dikirim ulang',
    timer:2000,
    showConfirmButton:false
});

            startPhoneCountdown();

        }

    });

});

</script>
<script>

$('#registerForm').submit(function(e){

    let errors = [];

    $('.is-invalid').removeClass('is-invalid');

    function addError(selector, pesan){

        $(selector).addClass('is-invalid');

        errors.push(pesan);

    }

    // NAMA

    if($('input[name="name"]').val().trim()=='')
    {
        addError(
            'input[name="name"]',
            'Nama lengkap belum diisi'
        );
    }

    // EMAIL

    if($('#email').val().trim()=='')
    {
        addError(
            '#email',
            'Email belum diisi'
        );
    }
    else if(
        $('#emailStatus')
        .text()
        .trim()==''
    )
    {
        addError(
            '#email',
            'Email belum diverifikasi'
        );
    }

    // WHATSAPP

    if($('#phone').val().trim()=='')
    {
        addError(
            '#phone',
            'Nomor WhatsApp belum diisi'
        );
    }
    else if(
        $('#phoneStatus')
        .text()
        .trim()==''
    )
    {
        addError(
            '#phone',
            'Nomor WhatsApp belum diverifikasi'
        );
    }

    // PASSWORD

    if($('#password').val()=='')
    {
        addError(
            '#password',
            'Password belum diisi'
        );
    }

    // KONFIRMASI PASSWORD

    if($('#password_confirmation').val()=='')
    {
        addError(
            '#password_confirmation',
            'Konfirmasi password belum diisi'
        );
    }

    if(
        $('#password').val() !=
        $('#password_confirmation').val()
    )
    {
        addError(
            '#password_confirmation',
            'Konfirmasi password tidak cocok'
        );
    }

    // NIK

    if($('#nik').val().length != 16)
    {
        addError(
            '#nik',
            'NIK harus 16 digit'
        );
    }

    // FOTO PROFIL

    if($('#photo_profile')[0].files.length==0)
    {
        addError(
            '#photo_profile',
            'Foto profil belum dipilih'
        );
    }

    // FOTO KTP

    if(
        $('input[name="ktp_photo"]')[0]
        .files.length==0
    )
    {
        addError(
            'input[name="ktp_photo"]',
            'Foto KTP belum diupload'
        );
    }

    // NAMA USAHA

    if(
        $('input[name="business_name"]')
        .val()
        .trim()==''
    )
    {
        addError(
            'input[name="business_name"]',
            'Nama usaha belum diisi'
        );
    }

    // SPESIALISASI

    if(
        $('select[name="specialization"]')
        .val()==''
    )
    {
        addError(
            'select[name="specialization"]',
            'Spesialisasi belum dipilih'
        );
    }

    // LOKASI

    if($('#latitude').val()=='')
    {
        addError(
            '#latitude',
            'Lokasi usaha belum diambil'
        );
    }

    // FOTO USAHA

    if(
        $('input[name="business_photo"]')[0]
        .files.length==0
    )
    {
        addError(
            'input[name="business_photo"]',
            'Foto tempat usaha belum diupload'
        );
    }

    // PORTOFOLIO

    if(
        $('input[name="portfolio_photos[]"]')[0]
        .files.length==0
    )
    {
        addError(
            'input[name="portfolio_photos[]"]',
            'Portofolio belum diupload'
        );
    }

    // BANK

    if($('input[name="withdraw_type"]:checked').val()=='bank')
{
    if($('#bank').val()=='')
    {
        addError(
            '#bank',
            'Bank belum dipilih'
        );
    }
}
else
{
    if($('#ewallet').val()=='')
    {
        addError(
            '#ewallet',
            'E-Wallet belum dipilih'
        );
    }
}

    // REKENING

    if(
    $('input[name="withdraw_number"]')
    .val()
    .trim()==''
)
{
    addError(
        'input[name="withdraw_number"]',
        'Nomor rekening / nomor HP belum diisi'
    );
}

    // PEMILIK REKENING

    if(
    $('input[name="withdraw_name"]')
    .val()
    .trim()==''
)
{
    addError(
        'input[name="withdraw_name"]',
        'Nama pemilik belum diisi'
    );
}

    // ADA ERROR

    if(errors.length>0)
    {
        e.preventDefault();

        let html =
            '<ul style="text-align:left;">';

        errors.forEach(function(item){

            html +=
            `<li>❌ ${item}</li>`;

        });

        html += '</ul>';

        Swal.fire({

            icon:'warning',

            title:'Data Belum Lengkap',

            html:html,

            confirmButtonColor:'#2563eb'

        });

    }

});

</script>


<script>
$('input[name="withdraw_type"]').change(function(){

    $('#withdraw_name').val('');
    $('#withdraw_number').val('');

    if($(this).val()=='bank'){

        $('#bankSection').show();
        $('#ewalletSection').hide();

        $('#withdraw_number')
            .attr('placeholder','Masukkan nomor rekening');

        $('label[for="withdraw_name"]').text('Nama Pemilik Rekening');

    }else{

        $('#bankSection').hide();
        $('#ewalletSection').show();

        $('#withdraw_number')
            .attr('placeholder','Masukkan nomor HP E-Wallet');

        $('label[for="withdraw_name"]').text('Nama Pemilik Akun');

    }

});
</script>
<script>
   

let timer = null;

$('#withdraw_number').on('keyup', function () {

    clearTimeout(timer);

    let rekening = $(this).val();

    let tujuan = '';

    if ($('input[name="withdraw_type"]:checked').val() == 'bank') {

    tujuan = $('#bank option:selected').data('brick');

} else {

    tujuan = $('#ewallet option:selected').data('brick');

}

    if (rekening.length < 6 || tujuan == '') {
        return;
    }

    timer = setTimeout(function () {

        $('#withdraw_name').val('Memverifikasi...');

        $.ajax({

            url:'/cek-rekening',

            type:'POST',

            data:{

                _token:'{{ csrf_token() }}',

                bank: tujuan,

                rekening: rekening

            },

            success:function(res){

                if(res.status == 200){

                    $('#withdraw_name')
                        .removeClass('is-invalid')
                        .addClass('is-valid')
                        .val(res.data.accountName);

                }else{

                    $('#withdraw_name')
                        .removeClass('is-valid')
                        .addClass('is-invalid')
                        .val('');

                }

            },

            error:function(){

                $('#withdraw_name')
                    .removeClass('is-valid')
                    .addClass('is-invalid')
                    .val('');

            }

        });

    },700);

});
</script>
<script>
    $('#bank').on('change', function(){

    $('#withdraw_name').val('');

    $('#withdraw_number').val('');

});
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

</body>
</html>