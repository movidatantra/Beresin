@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Detail Komplain
            </h3>
            <p class="text-muted mb-0">
                Lihat informasi komplain dari pelanggan dan berikan tanggapan.
            </p>
        </div>

        <a href="/orders" class="btn btn-outline-secondary rounded-pill">
            ← Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success rounded-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">

        {{-- INFORMASI ORDER --}}
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-primary text-white rounded-top-4">
                    <strong>Informasi Order</strong>
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <td>No Order</td>
                            <td class="fw-bold">
                                {{ $complaint->order->invoice_number }}
                            </td>
                        </tr>

                        <tr>
                            <td>Pelanggan</td>
                            <td class="fw-bold">
                                {{ $complaint->user->name }}
                            </td>
                        </tr>

                        <tr>
                            <td>Kategori</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $complaint->category }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>

                                @if($complaint->status=='pending')

                                <span class="badge bg-warning text-dark">
                                    Menunggu Tanggapan
                                </span>

                                @elseif($complaint->status=='review')

                                <span class="badge bg-primary">
                                    Sedang Ditinjau Admin
                                </span>

                                @elseif($complaint->status=='approved')

                                <span class="badge bg-success">
                                    Refund Disetujui
                                </span>

                                @elseif($complaint->status=='rejected')

                                <span class="badge bg-danger">
                                    Komplain Ditolak
                                </span>

                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- DETAIL KOMPLAIN --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-danger text-white rounded-top-4">
                    <strong>Komplain Pelanggan</strong>
                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <label class="fw-bold">
                            Subjek
                        </label>

                        <div class="border rounded-3 p-3 bg-light">

                            {{ $complaint->subject }}

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="fw-bold">
                            Isi Komplain
                        </label>

                        <div class="alert alert-warning rounded-4">

                            {{ $complaint->complaint }}

                        </div>

                    </div>

                    @if($complaint->photo)

                    <div class="mb-4">

                        <label class="fw-bold d-block mb-2">
                            Foto Bukti
                        </label>

                        <img
                            src="{{ asset('uploads/complaints/photos/'.$complaint->photo) }}"
                            class="img-fluid rounded shadow-sm border">

                    </div>

                    @endif

                    @if($complaint->video)

                    <div class="mb-4">

                        <label class="fw-bold d-block mb-2">
                            Video Bukti
                        </label>

                        <video controls class="w-100 rounded shadow-sm">

                            <source src="{{ asset('storage/'.$complaint->video) }}">

                        </video>

                    </div>

                    @endif

                    <hr>

                    <form action="{{ route('mitra.complaints.response',$complaint->order_id) }}"
                          method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="fw-bold mb-2">

                                Tanggapan Mitra

                            </label>

                            <textarea
                                name="mitra_response"
                                rows="6"
                                class="form-control rounded-3"
                                placeholder="Tuliskan penjelasan atau klarifikasi terkait komplain pelanggan...">{{ old('mitra_response',$complaint->mitra_response) }}</textarea>

                        </div>

                        <div class="text-end">

                            <button class="btn btn-primary rounded-pill px-4">

                                Kirim Tanggapan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection