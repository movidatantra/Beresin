@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-grid-fill text-primary"></i>
                Tambah Kategori Layanan
            </h3>
            <p class="text-muted mb-0">
                Tambahkan kategori layanan baru yang akan digunakan pada aplikasi Beres.in.
            </p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i>
                Form Tambah Kategori
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('categories.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <!-- Nama -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Contoh : AC"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="aktif">Aktif</option>

                            <option value="nonaktif">Nonaktif</option>

                        </select>

                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12 mb-3">

                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control"
                            placeholder="Masukkan deskripsi kategori...">{{ old('description') }}</textarea>

                    </div>

                    <!-- Upload Icon -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Icon Kategori
                        </label>

                        <input
                            type="file"
                            name="icon"
                            class="form-control"
                            accept="image/*"
                            onchange="previewImage(event)">

                        <small class="text-muted">
                            Format: JPG, PNG, JPEG
                        </small>

                    </div>

                    <!-- Preview -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Preview
                        </label>

                        <div class="border rounded p-3 text-center">

                            <img
                                id="preview"
                                src="https://placehold.co/150x150?text=Preview"
                                class="img-fluid rounded"
                                style="max-height:150px;">

                        </div>

                    </div>

                </div>

                <hr>

                <div class="text-end">

                    <a href="{{ route('categories.index') }}"
                       class="btn btn-outline-secondary">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>

                        Simpan Kategori

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

function previewImage(event)
{
    const reader = new FileReader();

    reader.onload = function(){

        document.getElementById('preview').src = reader.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

</script>

@endsection