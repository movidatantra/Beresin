@extends('layouts.mitra')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>

                <h3 class="fw-bold mb-1">

                    Daftar Layanan

                </h3>

                <p class="text-muted mb-0">

                    Kelola layanan yang tersedia di Beres.in

                </p>

            </div>

            <a href="/services/create"
               class="btn btn-primary rounded-pill px-4">

                <i class="bi bi-plus-circle"></i>

                Tambah Layanan

            </a>

        </div>

        <!-- SUCCESS -->

        @if(session('success'))

            <div class="alert alert-success rounded-4">

                {{ session('success') }}

            </div>

        @endif

        <!-- TABLE -->

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>

                        <th>Gambar</th>

                        <th>Layanan</th>

                        <th>Kategori</th>

                        <th>Harga</th>

                        <th>Estimasi Waktu</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($services as $service)

                    <tr>

                        <!-- NO -->

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <!-- IMAGE -->

                        <td>

                            <img src="{{ asset('uploads/'.$service->image) }}"
                                 width="70"
                                 height="70"
                                 style="object-fit:cover;border-radius:15px;">

                        </td>

                        <!-- NAME -->

                        <td>

                            <div class="fw-semibold">

                                {{ $service->name }}

                            </div>

                            <small class="text-muted">

                                {{ Str::limit($service->description, 40) }}

                            </small>

                        </td>

                        <!-- CATEGORY -->

                        <td>

                            <span class="badge bg-primary rounded-pill">

                                {{ $service->category }}

                            </span>

                        </td>

                        <!-- PRICE -->

                        <td>

                            Rp {{ number_format($service->price) }}

                        </td>

                        <!-- DURATION -->

                        <td>

                            {{ $service->duration }}

                        </td>

                        <!-- STATUS -->

                        <td>

                            @if($service->status == 'aktif')

                                <span class="badge bg-success rounded-pill">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-danger rounded-pill">

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        <!-- ACTION -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- EDIT -->

                                <a href="/services/{{ $service->id }}/edit"
                                   class="btn btn-warning btn-sm rounded-pill">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <!-- DELETE -->

                                <form action="/services/{{ $service->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm rounded-pill">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-5 text-muted">

                            Belum ada layanan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection