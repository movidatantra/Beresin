<!DOCTYPE html>
<html>

<head>

    <title>Lupa Password | Beres.in</title>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icon -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- JQuery -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        body{

            min-height:100vh;

            background:
            linear-gradient(
                to right,
                #0f172a,
                #1e40af
            );

        }

        .forgot-card{

            border:none;

            border-radius:25px;

        }

        .logo{

            font-size:38px;

            font-weight:bold;

            color:#2563eb;

        }

        .btn-home{

            background:#2563eb;

            color:white;

            border:none;

            border-radius:12px;

            padding:12px;

        }

        .btn-home:hover{

            background:#1d4ed8;

            color:white;

        }

        .step-circle{

            width:40px;

            height:40px;

            border-radius:50%;

            background:#e5e7eb;

            color:#6b7280;

            display:flex;

            align-items:center;

            justify-content:center;

            margin:auto;

            font-weight:bold;

        }

        .step-active{

            background:#2563eb;

            color:white;

        }

        .password-toggle{

            cursor:pointer;

        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card forgot-card shadow-lg">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <div class="logo">

                            🔐 Beres.in

                        </div>

                        <h4 class="mt-3">

                            Lupa Password

                        </h4>

                    </div>

                    <!-- STEP -->

                    <div class="row text-center mb-5">

                        <div class="col">

                            <div
                                id="circle1"
                                class="step-circle step-active">

                                1

                            </div>

                            <small>Email</small>

                        </div>

                        <div class="col">

                            <div
                                id="circle2"
                                class="step-circle">

                                2

                            </div>

                            <small>OTP</small>

                        </div>

                        <div class="col">

                            <div
                                id="circle3"
                                class="step-circle">

                                3

                            </div>

                            <small>Password</small>

                        </div>

                    </div>

                    <!-- ======================
                         STEP 1 EMAIL
                    ======================= -->

                    <div id="step1">

                        <label class="fw-semibold mb-2">

                            Email

                        </label>

                        <div class="input-group mb-4">

                            <span class="input-group-text">

                                <i class="bi bi-envelope-fill"></i>

                            </span>

                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                placeholder="Masukkan email">

                        </div>

                        <button
                            id="sendOtp"
                            class="btn btn-home w-100">

                            Kirim OTP

                        </button>

                    </div>

                    <!-- ======================
                         STEP 2 OTP
                    ======================= -->

                    <div
                        id="step2"
                        style="display:none;">

                        <label class="fw-semibold mb-2">

                            Kode OTP

                        </label>

                        <div class="input-group mb-4">

                            <span class="input-group-text">

                                <i class="bi bi-shield-lock-fill"></i>

                            </span>

                            <input
                                type="text"
                                id="otp"
                                class="form-control"
                                placeholder="Masukkan OTP">

                        </div>

                        <button
                            id="verifyOtp"
                            class="btn btn-success w-100">

                            Verifikasi OTP

                        </button>

                    </div>

                    <!-- ======================
                         STEP 3 PASSWORD
                    ======================= -->

                    <div
                        id="step3"
                        style="display:none;">

                        <form
                            action="/reset-password"
                            method="POST">

                            @csrf

                            <div class="mb-3">

                                <label class="fw-semibold mb-2">

                                    Password Baru

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-lock-fill"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="Minimal 8 karakter">

                                    <span
                                        class="input-group-text password-toggle"
                                        onclick="togglePassword('password')">

                                        <i class="bi bi-eye"></i>

                                    </span>

                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="fw-semibold mb-2">

                                    Konfirmasi Password

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-lock-fill"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control"
                                        placeholder="Ulangi password">

                                    <span
                                        class="input-group-text password-toggle"
                                        onclick="togglePassword('password_confirmation')">

                                        <i class="bi bi-eye"></i>

                                    </span>

                                </div>

                            </div>

                            <button
                                class="btn btn-home w-100">

                                Reset Password

                            </button>

                        </form>

                    </div>

                    <div class="text-center mt-4">

                        <a
                            href="/login"
                            class="text-decoration-none">

                            ← Kembali ke Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(id)
{
    let input =
        document.getElementById(id);

    input.type =
        input.type === 'password'
        ? 'text'
        : 'password';
}


// ======================
// KIRIM OTP
// ======================

$('#sendOtp').click(function(){

    let btn = $(this);

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Mengirim...
    `);

    btn.prop('disabled',true);

    $.post(

        '/send-reset-otp',

        {

            _token:'{{ csrf_token() }}',

            email:$('#email').val()

        },

        function(res){

            btn.html('Kirim OTP');

            btn.prop('disabled',false);

            if(res.success)
            {
                Swal.fire({

                    icon:'success',

                    title:'Berhasil',

                    text:'OTP berhasil dikirim'

                });

                $('#step1').hide();

                $('#step2').fadeIn();

                $('#circle1')
                .removeClass('step-active');

                $('#circle2')
                .addClass('step-active');
            }
            else
            {
                Swal.fire({

                    icon:'error',

                    title:'Gagal',

                    text:res.message

                });
            }

        }

    );

});


// ======================
// VERIFIKASI OTP
// ======================

$('#verifyOtp').click(function(){

    $.post(

        '/verify-reset-otp',

        {

            _token:'{{ csrf_token() }}',

            otp:$('#otp').val()

        },

        function(res){

            if(res.success)
            {
                Swal.fire({

                    icon:'success',

                    title:'OTP Berhasil',

                    text:'Silakan buat password baru'

                });

                $('#step2').hide();

                $('#step3').fadeIn();

                $('#circle2')
                .removeClass('step-active');

                $('#circle3')
                .addClass('step-active');
            }
            else
            {
                Swal.fire({

                    icon:'error',

                    title:'OTP Salah',

                    text:res.message

                });
            }

        }

    );

});

</script>

</body>
</html>