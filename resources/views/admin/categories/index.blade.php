@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-grid-fill text-primary"></i>
                Kelola Kategori Layanan
            </h3>
            <p class="text-muted mb-0">
                Kelola seluruh kategori layanan yang tersedia pada aplikasi Beres.in.
            </p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Kategori
        </a>
    </div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle-fill"></i>

        {{ session('success') }}

        <button class="btn-close" data-bs-dismiss="alert"></button>

    </div>
@endif
    <!-- Card -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <!-- Search -->
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="row mb-4">

                    <div class="col-md-4">

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari kategori..."
                                value="{{ request('search') }}">

                        </div>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-outline-primary w-100">
                            Cari
                        </button>

                    </div>

                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">No</th>

                            <th width="100">Icon</th>

                            <th>Nama Kategori</th>

                            <th>Deskripsi</th>

                            <th width="120">Status</th>

                            <th width="170" class="text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                @if($category->icon)

                                    <img
                                        src="{{ asset('storage/'.$category->icon) }}"
                                        width="55"
                                        class="rounded shadow-sm">

                                @else

                                    <span class="badge bg-secondary">
                                        Tidak Ada
                                    </span>

                                @endif

                            </td>

                            <td class="fw-semibold">

                                {{ $category->name }}

                            </td>

                            <td>

                                {{ $category->description }}

                            </td>

                            <td>

                                @if($category->status=='aktif')

                                    <span class="badge bg-success">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <a href="{{ route('categories.edit',$category->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form
                                    action="{{ route('categories.destroy',$category->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6">

                                <div class="text-center py-5">

                                    <i class="bi bi-folder2-open display-3 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Belum Ada Kategori

                                    </h5>

                                    <p class="text-muted">

                                        Silakan tambahkan kategori layanan terlebih dahulu.

                                    </p>

                                    <a href="{{ route('categories.create') }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-circle"></i>

                                        Tambah Kategori

                                    </a>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="mt-3">

                {{-- {{ $categories->links() }} --}}
                

            </div>

        </div>

    </div>

</div>

@endsection