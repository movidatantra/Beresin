@extends('layouts.mitra')

@section('content')

<div class="row">

    <!-- =========================
         PROFILE CARD
    ========================= -->

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <!-- TOP -->

            <div class="bg-primary p-5 text-center text-white">

                <!-- FOTO -->

                @if(Auth::user()->photo)

                    <img src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                         width="130"
                         height="130"
                         class="rounded-circle shadow border border-4 border-white"
                         style="object-fit:cover;">

                @else

                    <div class="mx-auto rounded-circle bg-white text-primary d-flex align-items-center justify-content-center"
                         style="width:130px;height:130px;font-size:50px;">

                        <i class="bi bi-person-fill"></i>

                    </div>

                @endif

                <!-- NAMA -->

                <h3 class="fw-bold mt-4 mb-1">

                    {{ Auth::user()->name }}

                </h3>

                <!-- USAHA -->

                <p class="mb-3 opacity-75">

                    {{ Auth::user()->business_name }}

                </p>

                <!-- STATUS -->

                @if(Auth::user()->verification_status == 'verified')

                    <span class="badge bg-success rounded-pill px-4 py-2">

                        <i class="bi bi-patch-check-fill"></i>

                        Verified Mitra

                    </span>

                @else

                    <span class="badge bg-warning rounded-pill px-4 py-2">

                        <i class="bi bi-clock-fill"></i>

                        Pending Verification

                    </span>

                @endif

            </div>

            <!-- BODY -->

            <div class="card-body p-4">

                <div class="mb-4">

                    <small class="text-muted">

                        Spesialisasi

                    </small>

                    <div class="fw-semibold fs-5">

                        {{ Auth::user()->specialization }}

                    </div>

                </div>

                <div class="mb-4">

                    <small class="text-muted">

                        Pengalaman

                    </small>

                    <div class="fw-semibold fs-5">

                        {{ Auth::user()->experience }}

                    </div>

                </div>

                <div class="mb-4">

                    <small class="text-muted">

                        Area Operasional

                    </small>

                    <div class="fw-semibold fs-5">

                        {{ Auth::user()->business_area }}

                    </div>

                </div>

                <div class="mb-4">

                    <small class="text-muted">

                        Nomor HP

                    </small>

                    <div class="fw-semibold fs-5">

                        {{ Auth::user()->phone }}

                    </div>

                </div>

                <div>

                    <small class="text-muted">

                        Email

                    </small>

                    <div class="fw-semibold fs-6">

                        {{ Auth::user()->email }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================
         EDIT PROFILE
    ========================= -->

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4 p-lg-5">

                <!-- TITLE -->

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h3 class="fw-bold mb-1">

                            Edit Profile Mitra

                        </h3>

                        <p class="text-muted mb-0">

                            Kelola informasi profile dan usaha Anda

                        </p>

                    </div>

                </div>

                <!-- SUCCESS -->

                @if(session('success'))

                    <div class="alert alert-success rounded-4">

                        {{ session('success') }}

                    </div>

                @endif

                <!-- ERROR -->

                @if ($errors->any())

                    <div class="alert alert-danger rounded-4">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <!-- FORM -->

                <form action="/profile-mitra"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <!-- NAMA -->

                        <div class="col-md-6 mb-4">

                            <label class="fw-semibold mb-2">

                                Nama Lengkap

                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ Auth::user()->name }}"
                                   class="form-control rounded-4">

                        </div>

                        <!-- PHONE -->

                        <div class="col-md-6 mb-4">

                            <label class="fw-semibold mb-2">

                                Nomor HP

                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ Auth::user()->phone }}"
                                   class="form-control rounded-4">

                        </div>

                    </div>

                    <!-- USAHA -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Nama Usaha

                        </label>

                        <input type="text"
                               name="business_name"
                               value="{{ Auth::user()->business_name }}"
                               class="form-control rounded-4">

                    </div>

                    <!-- AREA -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Area Operasional

                        </label>

                        <input type="text"
                               name="business_area"
                               value="{{ Auth::user()->business_area }}"
                               class="form-control rounded-4">

                    </div>

                    <!-- SPESIAL -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Spesialisasi

                        </label>

                        <input type="text"
                               name="specialization"
                               value="{{ Auth::user()->specialization }}"
                               class="form-control rounded-4">

                    </div>

                    <!-- EXPERIENCE -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Pengalaman

                        </label>

                        <input type="text"
                               name="experience"
                               value="{{ Auth::user()->experience }}"
                               class="form-control rounded-4">

                    </div>

                    <!-- FOTO -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Foto Profile

                        </label>

                        <input type="file"
                               name="photo"
                               class="form-control rounded-4">

                    </div>

                    <!-- ADDRESS -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Alamat Lengkap

                        </label>

                        <textarea name="address"
                                  rows="4"
                                  class="form-control rounded-4">{{ Auth::user()->address }}</textarea>

                    </div>

                    <!-- DESCRIPTION -->

                    <div class="mb-4">

                        <label class="fw-semibold mb-2">

                            Deskripsi Mitra

                        </label>

                        <textarea name="description"
                                  rows="5"
                                  class="form-control rounded-4">{{ Auth::user()->description }}</textarea>

                    </div>

                    <!-- GPS -->

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="fw-semibold mb-2">

                                Latitude

                            </label>

                            <input type="text"
                                   id="latitude"
                                   name="latitude"
                                   value="{{ Auth::user()->latitude }}"
                                   class="form-control rounded-4">

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="fw-semibold mb-2">

                                Longitude

                            </label>

                            <input type="text"
                                   id="longitude"
                                   name="longitude"
                                   value="{{ Auth::user()->longitude }}"
                                   class="form-control rounded-4">

                        </div>

                    </div>

                    <!-- GPS BUTTON -->

                    <div class="mb-4">

                        <button type="button"
                                class="btn btn-outline-primary rounded-pill px-4"
                                onclick="getLocation()">

                            <i class="bi bi-geo-alt-fill"></i>

                            Ambil Lokasi Saya

                        </button>

                    </div>

                    <!-- MAP -->

                    @if(Auth::user()->latitude && Auth::user()->longitude)

                    <div class="mb-4">

                        <iframe
                            width="100%"
                            height="300"
                            style="border:0;border-radius:20px;"
                            loading="lazy"
                            allowfullscreen
                            src="https://maps.google.com/maps?q={{ Auth::user()->latitude }},{{ Auth::user()->longitude }}&z=15&output=embed">
                        </iframe>

                    </div>

                    @endif

                    <!-- BUTTON -->

                    <button class="btn btn-primary rounded-pill px-5 py-3">

                        <i class="bi bi-save-fill"></i>

                        Update Profile

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- GPS SCRIPT -->

<script>

function getLocation(){

    if(navigator.geolocation){

        navigator.geolocation.getCurrentPosition(

            function(position){

                document.getElementById('latitude').value =
                position.coords.latitude;

                document.getElementById('longitude').value =
                position.coords.longitude;

                alert('Lokasi berhasil diambil');

            },

            function(){

                alert('Gagal mengambil lokasi');

            }

        );

    }else{

        alert('Browser tidak mendukung GPS');

    }

}

</script>

@endsection