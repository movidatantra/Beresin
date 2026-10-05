@extends('layouts.admin')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between mb-4">

            <h3 class="fw-bold">

                Verifikasi Mitra

            </h3>

            <span class="badge bg-warning">

                {{ $mitras->count() }} Pending

            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Foto</th>

                        <th>Nama</th>

                        <th>Usaha</th>

                        <th>Area</th>

                        <th>Spesialisasi</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($mitras as $mitra)

                    <tr>

                        <td>

                            <img
                                src="{{ asset('uploads/profile/'.$mitra->photo) }}"
                                width="60"
                                height="60"
                                class="rounded-circle">

                        </td>

                        <td>

                            <strong>

                                {{ $mitra->name }}

                            </strong>

                            <br>

                            <small>

                                {{ $mitra->email }}

                            </small>

                        </td>

                        <td>

                            {{ $mitra->business_name }}

                        </td>

                        <td>

                            {{ $mitra->business_area }}

                        </td>

                        <td>

                            {{ $mitra->specialization }}

                        </td>

                       <td>

    <a
        href="{{ route('admin.mitra.detail',$mitra->id) }}"
        class="btn btn-primary btn-sm">

        <i class="bi bi-eye-fill"></i>

        Detail

    </a>

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center">

                            Tidak ada mitra yang menunggu verifikasi

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection