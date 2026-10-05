@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="row g-4">

        <!-- SIDEBAR --->
        <div class="col-lg-3">

    @include('pelanggan.profile.sidebar')

</div>

        <!-- CONTENT -->
        <div class="col-lg-9">

            <div class="card profile-card">

                <div class="card-body p-5">

                    <h2 class="fw-bold">

                        Ubah Password

                    </h2>

                    <p class="text-muted">

                        Gunakan password yang kuat untuk menjaga keamanan akun Anda.

                    </p>

                    <hr>

                    <form
                        action="/ubah-password"
                        method="POST">

                        @csrf

                        <!-- PASSWORD LAMA -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Password Lama

                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="old_password"
                                    id="old_password"
                                    class="form-control profile-input">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('old_password')">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                        </div>

                        <!-- PASSWORD BARU -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Password Baru

                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control profile-input">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('password')">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                        </div>

                        <!-- KONFIRMASI -->

                        <div class="mb-4">

                            <label class="fw-semibold mb-2">

                                Konfirmasi Password Baru

                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control profile-input">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirmation')">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                        </div>

                        <button
                            class="btn btn-save">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Simpan Password

                        </button>

                    </form>

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

    if(input.type === 'password')
    {
        input.type = 'text';
    }
    else
    {
        input.type = 'password';
    }
}

</script>
@include('pelanggan.profile.style')
@endsection