<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Daftar Pelanggan | Beres.in
    </title>

    <!-- BOOTSTRAP -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- BOOTSTRAP ICON -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SWEET ALERT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        

        body{

            min-height:100vh;

            background:
                linear-gradient(
                    135deg,
                    #1e40af,
                    #2563eb,
                    #60a5fa
                );

            font-family:
                'Segoe UI',
                sans-serif;

        }

        .register-card{

            border:none;

            border-radius:30px;

            overflow:hidden;

        }

        .logo{

            font-size:40px;

            font-weight:800;

            color:#2563eb;

        }

        .form-title{

            font-weight:700;

        }

        .form-subtitle{

            color:#6b7280;

            font-size:14px;

        }

        .form-control{

            border-radius:15px;

            padding:14px;

        }

        .input-group-text{

            border-radius:15px 0 0 15px;

            background:#f3f4f6;

        }

        .btn-register{

            background:#2563eb;

            color:white;

            border:none;

            border-radius:15px;

            padding:14px;

            font-weight:600;

            transition:.3s;

        }

        .btn-register:hover{

            background:#1d4ed8;

            color:white;

        }

        .photo-preview{

            width:120px;

            height:120px;

            border-radius:50%;

            object-fit:cover;

            border:4px solid #e5e7eb;

            display:none;

        }

        .upload-box{

            border:2px dashed #d1d5db;

            border-radius:20px;

            padding:20px;

            text-align:center;

            cursor:pointer;

            transition:.3s;

        }

        .upload-box:hover{

            background:#f9fafb;

        }

        .verify-success{

            color:#16a34a;

            font-weight:600;

        }

        .verify-failed{

            color:#dc2626;

            font-weight:600;

        }
        /* HILANGKAN ICON MATA BAWAAN EDGE */

input::-ms-reveal,
input::-ms-clear {
    display: none;
}
/*verifikasi / validasi*/
.is-invalid{

    border:2px solid #dc3545 !important;

    background:#fff5f5;

}


.text-danger {

    font-size: 14px;

}

    </style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card register-card shadow-lg">

                <div class="card-body p-5">

                    <!-- LOGO -->

                    <div class="text-center mb-4">

                        <div class="logo">

                            Beres.in

                        </div>

                        <h3 class="form-title mt-3">

                            Daftar Sebagai Pelanggan

                        </h3>

                        <div class="form-subtitle">

                            Lengkapi data berikut untuk membuat akun pelanggan Beres.in

                        </div>

                    </div>

                    <!-- ALERT ERROR -->

                    @if(session('error'))

                        <div class="alert alert-danger">

                            <i class="bi bi-exclamation-circle-fill"></i>

                            {{ session('error') }}

                        </div>

                    @endif


                    @if($errors->any())

                        <div class="alert alert-danger">

                            <strong>

                                Harap lengkapi data berikut:

                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>

                                        {{ $error }}

                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form
                        action="/register"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <!-- NAMA LENGKAP -->

<div class="mb-4">

    <label class="fw-semibold mb-2">

        Nama Lengkap

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-person-fill"></i>

        </span>

        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Masukkan nama lengkap">

    </div>

    @error('name')

        <div class="text-danger mt-1">

            {{ $message }}

        </div>

    @enderror

</div>


<!-- EMAIL -->

<div class="mb-4">

    <label class="fw-semibold mb-2">

        Email

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-envelope-fill"></i>

        </span>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Masukkan email">

        <button
            type="button"
            class="btn btn-outline-primary"
            id="verifyEmail">

            Verifikasi

        </button>

    </div>

    @error('email')

        <div class="text-danger mt-1">

            {{ $message }}

        </div>

    @enderror

    <small
        id="emailStatus"
        class="verify-success">

    </small>

</div>


<!-- NO HP -->

<div class="mb-4">

    <label class="fw-semibold mb-2">

        Nomor WhatsApp

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-whatsapp"></i>

        </span>

        <input
            type="text"
            id="phone"
            name="phone"
            value="{{ old('phone') }}"
            class="form-control @error('phone') is-invalid @enderror"
            placeholder="08xxxxxxxxxx">

        <button
            type="button"
            class="btn btn-outline-success"
            id="verifyPhone">

            Verifikasi

        </button>

    </div>

    @error('phone')

        <div class="text-danger mt-1">

            {{ $message }}

        </div>

    @enderror

    <small
        id="phoneStatus"
        class="verify-success">

    </small>

</div>


<!-- FOTO PROFIL -->

<div class="mb-4">

    <label class="fw-semibold mb-3">

        Foto Profil (Opsional)

    </label>

    <div
        class="upload-box"
        onclick="document.getElementById('photo').click()">

        <img
            src=""
            id="photoPreview"
            class="photo-preview mb-3">

        <div id="uploadText">

            <i
                class="bi bi-camera-fill"
                style="font-size:40px;color:#9ca3af">
            </i>

            <div class="mt-2">

                Klik untuk upload foto profil

            </div>

        </div>

    </div>

    <input
        type="file"
        id="photo"
        name="photo"
        class="d-none"
        accept="image/*">

</div>


<!-- PASSWORD -->

<!-- PASSWORD -->

<div class="mb-4">

    <label class="fw-semibold mb-2">

        Password

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-lock-fill"></i>

        </span>

        <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Minimal 8 karakter">

        <button
            type="button"
            class="btn btn-outline-secondary"
            onclick="togglePassword('password')">

            <i class="bi bi-eye"></i>

        </button>

    </div>

    @error('password')

        <div class="text-danger mt-1">

            {{ $message }}

        </div>

    @enderror

</div>




<!-- KONFIRMASI PASSWORD -->

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
            id="password_confirmation"
            name="password_confirmation"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Ulangi password">

        <button
            type="button"
            class="btn btn-outline-secondary"
            onclick="togglePassword('password_confirmation')">

            <i class="bi bi-eye"></i>

        </button>

    </div>

</div>


<!-- BUTTON -->

<button
    type="submit"
    class="btn btn-register w-100">

    <i class="bi bi-person-plus-fill"></i>

    Daftar Sekarang

</button>


<p class="text-center mt-4 mb-0">

    Sudah punya akun?

    <a
        href="/login"
        class="fw-bold text-decoration-none">

        Login

    </a>

</p>

</form>

<!-- MODAL EMAIL OTP -->

<div class="modal fade"
     id="emailOtpModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">

                <h5 class="fw-bold">
                    Verifikasi Email
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <i class="bi bi-envelope-check-fill text-primary"
                   style="font-size:60px">
                </i>

                <p class="mt-3 text-muted">

                    Kode OTP telah dikirim ke email Anda

                </p>

                <input
                    type="text"
                    id="emailOtp"
                    class="form-control text-center"
                    maxlength="6"
                    placeholder="Masukkan 6 digit OTP">

                <div class="mt-3">

                    <small
                        id="emailCountdown"
                        class="text-secondary">

                        Kirim ulang dalam 60 detik

                    </small>

                </div>

                <button
                    type="button"
                    id="resendEmailOtp"
                    class="btn btn-link mt-2"
                    style="display:none;">

                    Kirim Ulang OTP

                </button>

            </div>

            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn btn-primary w-100"
                    id="checkEmailOtp">

                    Verifikasi OTP

                </button>

            </div>

        </div>

    </div>

</div>
<!-- MODAL WHATSAPP OTP -->

<!-- MODAL WHATSAPP OTP -->

<div class="modal fade"
     id="phoneOtpModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-0">

                <h5 class="fw-bold">

                    Verifikasi WhatsApp

                </h5>

                <button
                    type="button"
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

                    <small
                        id="phoneCountdown"
                        class="text-secondary">

                        Kirim ulang dalam 60 detik

                    </small>

                </div>

                <button
                    type="button"
                    id="resendPhoneOtp"
                    class="btn btn-link mt-2"
                    style="display:none;">

                    Kirim Ulang OTP

                </button>

            </div>

            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn btn-success w-100"
                    id="checkPhoneOtp">

                    Verifikasi OTP

                </button>

            </div>

        </div>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

let emailVerified = false;

let phoneVerified = false;

let emailTimer;

let phoneTimer;
function startEmailCountdown(){

    let timeLeft = 60;

    $('#resendEmailOtp').hide();

    $('#emailCountdown')
        .show()
        .text('Kirim ulang dalam 60 detik');

    clearInterval(emailTimer);

    emailTimer = setInterval(function(){

        timeLeft--;

        $('#emailCountdown')
            .text(
                'Kirim ulang dalam ' +
                timeLeft +
                ' detik'
            );

        if(timeLeft <= 0)
        {
            clearInterval(emailTimer);

            $('#emailCountdown').hide();

            $('#resendEmailOtp').show();
        }

    },1000);

}
function startPhoneCountdown(){

    let timeLeft = 60;

    $('#resendPhoneOtp').hide();

    $('#phoneCountdown')
        .show()
        .text('Kirim ulang dalam 60 detik');

    phoneTimer = setInterval(function(){

        timeLeft--;

        $('#phoneCountdown')
            .text(
                'Kirim ulang dalam '
                + timeLeft +
                ' detik'
            );

        if(timeLeft <= 0)
        {
            clearInterval(phoneTimer);

            $('#phoneCountdown').hide();

            $('#resendPhoneOtp').show();
        }

    },1000);

}


/*
|--------------------------------------------------------------------------
| PREVIEW FOTO
|--------------------------------------------------------------------------
*/

$('#photo').change(function(){

    let file = this.files[0];

    if(file)
    {
        let reader = new FileReader();

        reader.onload = function(e){

            $('#photoPreview')
                .attr('src', e.target.result)
                .show();

            $('#uploadText').hide();

        }

        reader.readAsDataURL(file);
    }

});


/*
|--------------------------------------------------------------------------
| SHOW PASSWORD
|--------------------------------------------------------------------------
*/

function togglePassword(id)
{
    let input = document.getElementById(id);

    input.type =
        input.type === 'password'
        ? 'text'
        : 'password';
}


/*
|--------------------------------------------------------------------------
| EMAIL OTP
|--------------------------------------------------------------------------
*/

$('#verifyEmail').click(function(){

    let email = $('#email').val();

    let btn = $(this);

    if(email == '')
    {
        Swal.fire(
            'Oops',
            'Masukkan email terlebih dahulu',
            'warning'
        );

        return;
    }

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Mengirim...
    `);

    btn.prop('disabled', true);

    $.ajax({

        url:'/send-email-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            email:email

        },

        success:function(){

    btn.html('Kirim Ulang OTP');

    btn.prop('disabled', false);

    const modal =
        new bootstrap.Modal(
            document.getElementById(
                'emailOtpModal'
            )
        );

    modal.show();

    startEmailCountdown();

},

        error:function(){

            btn.html('Verifikasi');

            btn.prop('disabled', false);

            Swal.fire(
                'Gagal',
                'Tidak bisa mengirim OTP',
                'error'
            );

        }

    });

});


$(document).on(
    'click',
    '#checkEmailOtp',
    function(){

        $.ajax({

            url:'/verify-email-otp',

            type:'POST',

            data:{

                _token:'{{ csrf_token() }}',

                otp:$('#emailOtp').val()

            },

            success:function(res){

                if(res.success)
{
    emailVerified = true;

    $('#emailStatus')
        .html(
            '✓ Email berhasil diverifikasi'
        );

    const modal =
        bootstrap.Modal.getInstance(
            document.getElementById(
                'emailOtpModal'
            )
        );

    modal.hide();

    setTimeout(function(){

        $('.modal-backdrop').remove();

        $('body')
            .removeClass('modal-open')
            .css('overflow','auto')
            .css('padding-right','0');

    },300);

}
                else
                {
                    Swal.fire(
                        'Gagal',
                        'OTP email salah',
                        'error'
                    );
                }

            }

        });

    }
);


/*
|--------------------------------------------------------------------------
| WHATSAPP OTP
|--------------------------------------------------------------------------
*/

$('#verifyPhone').click(function(){

    let phone = $('#phone').val();

    let btn = $(this);

    if(phone == '')
    {
        Swal.fire(
            'Oops',
            'Masukkan nomor WhatsApp terlebih dahulu',
            'warning'
        );

        return;
    }

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Mengirim...
    `);

    btn.prop('disabled', true);

    $.ajax({

        url:'/send-phone-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            phone:phone

        },

        success:function(){

    btn.html('Kirim Ulang OTP');

    btn.prop('disabled', false);

    const modal =
        new bootstrap.Modal(
            document.getElementById(
                'phoneOtpModal'
            )
        );

    modal.show();

    startPhoneCountdown();

},

        error:function(){

            btn.html('Verifikasi');

            btn.prop('disabled', false);

            Swal.fire(
                'Gagal',
                'Tidak bisa mengirim OTP',
                'error'
            );

        }

    });

});

$('#resendEmailOtp').click(function(){

    let email = $('#email').val();

    let btn = $(this);

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Mengirim...
    `);

    btn.prop('disabled', true);

    $.ajax({

        url:'/send-email-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            email:email

        },

        success:function(){

            Swal.fire({

                icon:'success',

                title:'Berhasil',

                text:'OTP baru telah dikirim',

                timer:1500,

                showConfirmButton:false

            });

            btn.html('Kirim Ulang OTP');

            btn.prop('disabled', false);

            startEmailCountdown();

        }

    });

});

$('#resendPhoneOtp').click(function(){

    let phone = $('#phone').val();

    let btn = $(this);

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
        Mengirim...
    `);

    btn.prop('disabled', true);

    $.ajax({

        url:'/send-phone-otp',

        type:'POST',

        data:{

            _token:'{{ csrf_token() }}',

            phone:phone

        },

        success:function(){

            Swal.fire({

                icon:'success',

                title:'Berhasil',

                text:'OTP WhatsApp baru telah dikirim',

                timer:1500,

                showConfirmButton:false

            });

            btn.html('Kirim Ulang OTP');

            btn.prop('disabled', false);

            startPhoneCountdown();

        },

        error:function(){

            Swal.fire({

                icon:'error',

                title:'Gagal',

                text:'Tidak bisa mengirim ulang OTP'

            });

            btn.html('Kirim Ulang OTP');

            btn.prop('disabled', false);

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
    phoneVerified = true;

    $('#phoneStatus')
        .html(
            '✓ WhatsApp berhasil diverifikasi'
        );

    const modal =
        bootstrap.Modal.getInstance(
            document.getElementById(
                'phoneOtpModal'
            )
        );

    modal.hide();

    setTimeout(function(){

        $('.modal-backdrop').remove();

        $('body')
            .removeClass('modal-open')
            .css('overflow','auto')
            .css('padding-right','0');

    },300);

}
                else
                {
                    Swal.fire(
                        'Gagal',
                        'OTP WhatsApp salah',
                        'error'
                    );
                }

            }

        });

    }
);


/*
|--------------------------------------------------------------------------
| VALIDASI SEBELUM SUBMIT
|--------------------------------------------------------------------------
*/

$('form').submit(function(e){

    if(!emailVerified)
    {
        e.preventDefault();

        Swal.fire(

            'Verifikasi Email',

            'Harap verifikasi email terlebih dahulu',

            'warning'

        );

        return;
    }

    if(!phoneVerified)
    {
        e.preventDefault();

        Swal.fire(

            'Verifikasi WhatsApp',

            'Harap verifikasi nomor WhatsApp terlebih dahulu',

            'warning'

        );

        return;
    }

});


</script>

    



</div>

</div>

</div>

</div>

</div>
</body>
</html>