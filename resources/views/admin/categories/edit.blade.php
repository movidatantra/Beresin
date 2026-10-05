@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-pencil-square text-warning"></i>
                Edit Kategori Layanan
            </h3>
            <p class="text-muted mb-0">
                Ubah informasi kategori layanan pada aplikasi Beres.in.
            </p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="bi bi-pencil"></i>
                Form Edit Kategori
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('categories.update', $category->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

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
                            value="{{ old('name', $category->name) }}"
                            placeholder="Contoh : AC">

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

                            <option value="aktif"
                                {{ old('status', $category->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif"
                                {{ old('status', $category->status) == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>

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
                            placeholder="Masukkan deskripsi kategori...">{{ old('description', $category->description) }}</textarea>

                    </div>

                    <!-- Upload -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Ganti Icon
                        </label>

                        <input
                            type="file"
                            name="icon"
                            class="form-control"
                            accept="image/*"
                            onchange="previewImage(event)">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti icon.
                        </small>

                    </div>

                    <!-- Preview -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Preview
                        </label>

                        <div class="border rounded p-3 text-center">

                            @if($category->icon)

                                <img
                                    id="preview"
                                    src="{{ asset('storage/'.$category->icon) }}"
                                    class="img-fluid rounded"
                                    style="max-height:150px;">

                            @else

                                <img
                                    id="preview"
                                    src="https://placehold.co/150x150?text=Preview"
                                    class="img-fluid rounded"
                                    style="max-height:150px;">

                            @endif

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
                        class="btn btn-warning">

                        <i class="bi bi-save"></i>

                        Update Kategori

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

    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
    }

    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection