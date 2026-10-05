@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Detail Komplain
            </h2>

            <small class="text-muted">
                {{ $complaint->complaint_number }}
            </small>

        </div>

        <div>

            @if($complaint->status == 'pending')

    <span class="badge bg-warning fs-6 px-3 py-2">
        Pending
    </span>

@elseif($complaint->status == 'waiting_mitra')

    <span class="badge bg-info fs-6 px-3 py-2">
        Menunggu Tanggapan Mitra
    </span>

@elseif($complaint->status == 'review')

    <span class="badge bg-primary fs-6 px-3 py-2">
        Sedang Ditinjau Admin
    </span>

@elseif($complaint->status == 'approved')

    <span class="badge bg-success fs-6 px-3 py-2">
        Refund Disetujui
    </span>

@elseif($complaint->status == 'rejected')

    <span class="badge bg-danger fs-6 px-3 py-2">
        Komplain Ditolak
    </span>

@elseif($complaint->status == 'resolved')

    <span class="badge bg-secondary fs-6 px-3 py-2">
        Selesai
    </span>

@endif

        </div>

    </div>

    <!-- Card Data -->
    <div class="row">

        <!-- Pelanggan -->
        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-primary text-white rounded-top-4">

                    <h5 class="mb-0">
                        <i class="bi bi-person-fill me-2"></i>
                        Data Pelanggan
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="170">Nama</th>

                            <td>{{ $complaint->user->name }}</td>

                        </tr>

                        <tr>

                            <th>Email</th>

                            <td>{{ $complaint->user->email }}</td>

                        </tr>

                        <tr>

                            <th>No HP</th>

                            <td>{{ $complaint->user->phone }}</td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <!-- Mitra -->
        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-success text-white rounded-top-4">

                    <h5 class="mb-0">
                        <i class="bi bi-shop me-2"></i>
                        Data Mitra
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="170">Nama</th>

                            <td>{{ $complaint->mitra->name }}</td>

                        </tr>

                        <tr>

                            <th>Nama Usaha</th>

                            <td>{{ $complaint->mitra->business_name }}</td>

                        </tr>

                        <tr>

                            <th>No HP</th>

                            <td>{{ $complaint->mitra->phone }}</td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>
        <!-- ========================= -->
    <!-- INFORMASI ORDER -->
    <!-- ========================= -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-dark text-white rounded-top-4">

            <h5 class="mb-0">
                <i class="bi bi-box-seam me-2"></i>
                Informasi Order
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">
                        Nomor Invoice
                    </label>

                    <h6 class="fw-bold">
                        {{ $complaint->order->invoice_number }}
                    </h6>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">
                        Status Order
                    </label>

                    <h6 class="fw-bold text-primary">
                        {{ ucfirst(str_replace('_',' ',$complaint->order->status)) }}
                    </h6>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">
                        Jadwal
                    </label>

                    <h6>

                        {{ \Carbon\Carbon::parse($complaint->order->jadwal)->translatedFormat('d F Y') }}

                    </h6>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">
                        Total Pembayaran
                    </label>

                    <h5 class="fw-bold text-success">

                        Rp {{ number_format($complaint->order->total_price,0,',','.') }}

                    </h5>

                </div>

                <div class="col-md-12">

                    <label class="text-muted small">
                        Alamat Pengerjaan
                    </label>

                    <div class="alert alert-light mb-0">

                        {{ $complaint->order->address }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- INFORMASI KOMPLAIN -->
    <!-- ========================= -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-danger text-white rounded-top-4">

            <h5 class="mb-0">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                Informasi Komplain

            </h5>

        </div>

        <div class="card-body">

            <div class="mb-3">

                <label class="text-muted small">

                    Kategori

                </label>

                <h6>

                    {{ $complaint->category }}

                </h6>

            </div>

            <div class="mb-3">

                <label class="text-muted small">

                    Judul

                </label>

                <h5 class="fw-bold">

                    {{ $complaint->subject }}

                </h5>

            </div>

            <div>

                <label class="text-muted small">

                    Deskripsi

                </label>

                <div class="alert alert-light">

                    {!! nl2br(e($complaint->complaint)) !!}

                </div>

            </div>

        </div>

    </div>
        <!-- ========================= -->
    <!-- BUKTI KOMPLAIN -->
    <!-- ========================= -->

    <div class="row">

        <!-- FOTO -->
        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-primary text-white rounded-top-4">

                    <h5 class="mb-0">

                        <i class="bi bi-image-fill me-2"></i>

                        Bukti Foto

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if($complaint->photo)

                        <img src="{{ asset('uploads/complaints/photos/'.$complaint->photo) }}"
     class="img-fluid rounded shadow"
     style="max-height:450px;">

                    @else

                        <div class="alert alert-secondary mb-0">

                            Tidak ada foto yang diunggah.

                        </div>

                    @endif

                </div>

            </div>

        </div>

        <!-- VIDEO -->
        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-danger text-white rounded-top-4">

                    <h5 class="mb-0">

                        <i class="bi bi-camera-video-fill me-2"></i>

                        Bukti Video

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if($complaint->video)

                        <video controls
                               class="w-100 rounded shadow">

                            <source src="{{ asset('uploads/complaints/videos/'.$complaint->video) }}">

                        </video>

                    @else

                        <div class="alert alert-secondary mb-0">

                            Tidak ada video yang diunggah.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- RESPON MITRA -->
    <!-- ========================= -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-success text-white rounded-top-4">

            <h5 class="mb-0">

                <i class="bi bi-chat-dots-fill me-2"></i>

                Tanggapan Mitra

            </h5>

        </div>

        <div class="card-body">

            @if($complaint->mitra_response)

                <div class="alert alert-success mb-0">

                    {!! nl2br(e($complaint->mitra_response)) !!}

                </div>

            @else

                <div class="alert alert-warning mb-0">

                    Mitra belum memberikan tanggapan.

                </div>

            @endif

        </div>

    </div>
        <!-- ========================= -->
    <!-- KEPUTUSAN ADMIN -->
    <!-- ========================= -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-dark text-white rounded-top-4">

            <h5 class="mb-0">

                <i class="bi bi-shield-check me-2"></i>

                Keputusan Admin

            </h5>

        </div>

        <div class="card-body">

           <form action="{{ route('admin.complaints.resolve',$complaint->id) }}"
      method="POST">

    @csrf

    <div class="mb-4">

        <label class="form-label fw-bold">
            Balasan Admin
        </label>

        <textarea
            name="admin_response"
            rows="6"
            class="form-control"
            placeholder="Tuliskan hasil pemeriksaan admin..."
            required>{{ old('admin_response',$complaint->admin_response) }}</textarea>

            <div class="mt-3">

    <button
        type="submit"
        name="action"
        value="save"
        class="btn btn-primary">

        <i class="bi bi-save"></i>

        Simpan Balasan Admin

    </button>

</div>

    </div>

    <hr class="my-4">
@if(in_array($complaint->status,['approved','rejected','resolved']))

<div class="alert alert-info">

    <i class="bi bi-lock-fill me-2"></i>

    Keputusan admin sudah disimpan dan tidak dapat diubah lagi.

</div>

@endif
<div class="row">
    

    <div class="col-md-6">


        

        <button
    type="submit"
    name="decision"
    value="mitra"
    class="btn btn-success w-100 py-3"
    {{ in_array($complaint->status,['approved','rejected','resolved']) ? 'disabled' : '' }}>

    <i class="bi bi-check-circle-fill me-2"></i>

    Dana Diteruskan ke Mitra

</button>

    </div>

    <div class="col-md-6">

        <button
    type="submit"
    name="decision"
    value="customer"
    class="btn btn-danger w-100 py-3"
    {{ in_array($complaint->status,['approved','rejected','resolved']) ? 'disabled' : '' }}>

    <i class="bi bi-arrow-counterclockwise me-2"></i>

    Refund ke Pelanggan

</button>

    </div>

</div>

</form>

        </div>

    </div>

</div>

@endsection