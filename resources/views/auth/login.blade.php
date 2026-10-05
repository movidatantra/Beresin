<!DOCTYPE html>
<html>

<head>

    <title>Login Beres.in</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: linear-gradient(
                to right,
                #0f172a,
                #1e3a8a
            );
            height:100vh;
        }

        .card{
            border:none;
            border-radius:20px;
        }

        .logo{
            font-size:35px;
            font-weight:bold;
            color:#1e3a8a;
        }

        .btn-home{
            background:#1e3a8a;
            color:white;
        }

        .btn-home:hover{
            background:#172554;
            color:white;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow-lg">

                <div class="card-body p-5">

                    <h2 class="text-center logo mb-3">

                        🔐 Beres.in

                    </h2>

                    <p class="text-center text-muted mb-4">

                        Login Akun

                    </p>

                    {{-- ALERT ERROR --}}

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

                    {{-- ALERT SUCCESS --}}

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

                    {{-- VALIDATION ERROR --}}

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)

                                    <li>

                                        {{ $error }}

                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="/login" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="text-end mb-3">

    <a href="/forgot-password"
       class="text-decoration-none">

        Lupa Password?

    </a>

</div>

                        <button class="btn btn-home w-100">

                            Login

                        </button>

                    </form>

                    <div class="text-center my-3">

                        <span class="text-muted">

                            atau

                        </span>

                    </div>

                    <a href="/auth/google"
                       class="btn btn-light border w-100 d-flex align-items-center justify-content-center gap-2">

                        <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png"
                             width="20">

                        Login dengan Google

                    </a>

                    <p class="text-center mt-4">

                        Belum punya akun?

                        <a href="/register">

                            Register Pelanggan

                        </a>

                    </p>

                    <p class="text-center">

                        Daftar sebagai Mitra?

                        <a href="/register-mitra">

                            Register Mitra

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>