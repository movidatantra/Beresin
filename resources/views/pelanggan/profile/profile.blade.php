@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="row g-4">

        <!-- SIDEBAR -->
        <!-- SIDEBAR -->

<div class="col-lg-3">

    @include('pelanggan.profile.sidebar')

</div>

        <!-- CONTENT -->
        <div class="col-lg-9">

            <div class="card profile-card">

                <div class="card-body p-5">

                    <h2 class="fw-bold mb-1">

                        Profil Saya

                    </h2>

                    <p class="text-muted mb-4">

                        Kelola informasi profil Anda untuk menjaga keamanan akun.

                    </p>

                    <hr>

                    @if(session('success'))

                        <div class="alert alert-success rounded-4">

                            {{ session('success') }}

                        </div>

                    @endif

                    @if(session('error'))
                    @if($errors->any())

    <div class="alert alert-danger rounded-4">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

                        <div class="alert alert-danger rounded-4">

                            {{ session('error') }}

                        </div>

                    @endif

                    <form
                        action="/profile-pelanggan"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <!-- FORM KIRI -->
                            <div class="col-lg-8">

                                <!-- NAMA -->

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">

                                        Nama Lengkap

                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ Auth::user()->name }}"
                                        class="form-control profile-input">

                                </div>

                                <!-- EMAIL -->

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">

                                        Email

                                    </label>

                                    <div class="d-flex align-items-center gap-3">

                                        <input
                                            type="text"
                                            class="form-control profile-input"
                                            value="{{ Auth::user()->email }}"
                                             disabled>

                                        <span class="verified-badge">

                                            <i class="bi bi-patch-check-fill"></i>

                                            Terverifikasi

                                        </span>

                                    </div>

                                </div>

                                <!-- NOMOR HP -->

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">

                                        Nomor WhatsApp

                                    </label>

                                    <div class="d-flex align-items-center gap-3">

                                        <input
                                            type="text"
                                            class="form-control profile-input"
                                            value="{{ Auth::user()->phone }}"
                                            disabled>

                                        <span class="verified-badge">

                                            <i class="bi bi-patch-check-fill"></i>

                                            Terverifikasi

                                        </span>

                                    </div>

                                </div>

                                <!-- ALAMAT -->

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">

                                        Alamat

                                    </label>

                                    <textarea
                                        name="address"
                                        rows="4"
                                        class="form-control profile-input">{{ Auth::user()->address }}</textarea>

                                </div>

                                <!-- TOMBOL -->

                                <button
                                    class="btn btn-save">

                                    <i class="bi bi-check-circle-fill me-2"></i>

                                    Simpan Perubahan

                                </button>

                            </div>
                                                        <!-- FOTO PROFIL -->
                            <div class="col-lg-4">

                                <div class="photo-section text-center">

                                    @if(Auth::user()->photo)

                                        <img
                                            id="preview"
                                            src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                                            class="profile-photo mb-4">

                                    @else

                                        <img
                                            id="preview"
                                            src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                            class="profile-photo mb-4">

                                    @endif

                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        class="form-control upload-input">

                                    <small class="text-muted d-block mt-3">

                                        Ukuran gambar maksimal 2 MB
                                        <br>

                                        Format JPG, JPEG, PNG

                                    </small>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>



<script>

document
.getElementById('photo')
.addEventListener('change',function(e){

    if(!e.target.files.length)
    {
        return;
    }

    let reader = new FileReader();

    reader.onload = function(event){

        document
        .getElementById('preview')
        .src = event.target.result;

    }

    reader.readAsDataURL(
        e.target.files[0]
    );

});

</script>
@include('pelanggan.profile.style')
@endsection