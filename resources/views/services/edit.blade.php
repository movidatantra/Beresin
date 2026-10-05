@extends('layouts.mitra')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>

                <h3 class="fw-bold mb-1">

                    Edit Layanan

                </h3>

                <p class="text-muted mb-0">

                    Perbarui data layanan jasa

                </p>

            </div>

            <a href="/services"
               class="btn btn-light border rounded-pill px-4">

                Kembali

            </a>

        </div>

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

        <form action="/services/{{ $service->id }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- NAMA -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Nama Layanan

                </label>

                <input type="text"
                       name="name"
                       value="{{ $service->name }}"
                       class="form-control form-control-lg rounded-4">

            </div>

            <!-- KATEGORI -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Kategori

                </label>

                <select name="category"
                        class="form-control form-control-lg rounded-4">

                    <option value="AC"
                        {{ $service->category == 'AC' ? 'selected' : '' }}>

                        AC

                    </option>

                    <option value="Cleaning"
                        {{ $service->category == 'Cleaning' ? 'selected' : '' }}>

                        Cleaning

                    </option>

                    <option value="Laundry"
                        {{ $service->category == 'Laundry' ? 'selected' : '' }}>

                        Laundry

                    </option>

                    <option value="Elektronik"
                        {{ $service->category == 'Elektronik' ? 'selected' : '' }}>

                        Elektronik

                    </option>

                </select>

            </div>

            <!-- HARGA -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Harga Layanan

                </label>

                <input type="number"
                       name="price"
                       value="{{ $service->price }}"
                       class="form-control form-control-lg rounded-4">

            </div>

            <!-- DURASI -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Estimasi Pengerjaan

                </label>

                <input type="text"
                       name="duration"
                       value="{{ $service->duration }}"
                       class="form-control form-control-lg rounded-4">

            </div>

            <!-- STATUS -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Status Layanan

                </label>

                <select name="status"
                        class="form-control form-control-lg rounded-4">

                    <option value="aktif"
                        {{ $service->status == 'aktif' ? 'selected' : '' }}>

                        Aktif

                    </option>

                    <option value="nonaktif"
                        {{ $service->status == 'nonaktif' ? 'selected' : '' }}>

                        Nonaktif

                    </option>

                </select>

            </div>

            <!-- IMAGE -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Gambar Layanan

                </label>

                <input type="file"
                       name="image"
                       class="form-control rounded-4">

                <!-- PREVIEW -->

                @if($service->image)

                    <img src="{{ asset('uploads/'.$service->image) }}"
                         width="120"
                         class="mt-3 rounded-4 shadow-sm">

                @endif

            </div>

            <!-- DESKRIPSI -->

            <div class="mb-4">

                <label class="fw-semibold mb-2">

                    Deskripsi Layanan

                </label>

                <textarea name="description"
                          rows="5"
                          class="form-control rounded-4">{{ $service->description }}</textarea>

            </div>

            <!-- BUTTON -->

            <button class="btn btn-primary rounded-pill px-5 py-2">

                Update Layanan

            </button>

        </form>

    </div>

</div>

@endsection