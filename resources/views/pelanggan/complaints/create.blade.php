@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow rounded-4">

        <div class="card-header bg-danger text-white rounded-top-4">

            <h4 class="mb-0">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Ajukan Komplain
            </h4>

        </div>

        <div class="card-body">

            <div class="mb-4">

                <h5 class="fw-bold">

                    Order
                    {{ $order->invoice_number }}

                </h5>

                <p class="mb-1">

                    <strong>Mitra :</strong>

                    {{ $order->mitra->business_name }}

                </p>

                <p class="mb-0">

                    <strong>Jadwal :</strong>

                    {{ $order->jadwal }}

                    {{ substr($order->jam,0,5) }}

                </p>

            </div>

            <form
                action="{{ route('complaint.store',$order->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                {{-- Form akan kita isi pada Part 4 --}}
                @csrf

{{-- Kategori --}}
<div class="mb-4">

    <label class="form-label fw-bold">

        Kategori Komplain
        <span class="text-danger">*</span>

    </label>

    <select
        name="category"
        class="form-select rounded-3"
        required>

        <option value="">
            -- Pilih Kategori --
        </option>

        <option value="Pekerjaan belum selesai">
            Pekerjaan belum selesai
        </option>

        <option value="Hasil tidak sesuai">
            Hasil tidak sesuai
        </option>

        <option value="Mitra tidak datang">
            Mitra tidak datang
        </option>

        <option value="Mitra terlambat">
            Mitra terlambat
        </option>

        <option value="Kerusakan bertambah">
            Kerusakan bertambah
        </option>

        <option value="Lainnya">
            Lainnya
        </option>

    </select>

</div>

{{-- Judul --}}
<div class="mb-4">

    <label class="form-label fw-bold">

        Judul Komplain
        <span class="text-danger">*</span>

    </label>

    <input
        type="text"
        name="subject"
        class="form-control rounded-3"
        maxlength="255"
        required>

</div>

{{-- Deskripsi --}}
<div class="mb-4">

    <label class="form-label fw-bold">

        Deskripsi Komplain
        <span class="text-danger">*</span>

    </label>

    <textarea
        name="complaint"
        rows="6"
        class="form-control rounded-3"
        placeholder="Jelaskan masalah yang terjadi..."
        required></textarea>

</div>

{{-- Upload Foto --}}
<div class="mb-4">

    <label class="form-label fw-bold">

        Upload Foto Bukti

    </label>

    <input
        type="file"
        name="photo"
        class="form-control"
        accept="image/*">

    <small class="text-muted">

        JPG, PNG, JPEG maksimal 2 MB.

    </small>

</div>

{{-- Upload Video --}}
<div class="mb-4">

    <label class="form-label fw-bold">

        Upload Video (Opsional)

    </label>

    <input
        type="file"
        name="video"
        class="form-control"
        accept="video/*">

    <small class="text-muted">

        MP4 maksimal 20 MB.

    </small>

</div>

<hr class="my-4">

<h5 class="fw-bold mb-3">
    Rekening Pengembalian Dana
</h5>

<div class="mb-3">

    <label class="form-label fw-bold">

        Metode Refund
        <span class="text-danger">*</span>

    </label>

    <select
        name="refund_type"
        id="refund_type"
        class="form-select"
        required>

        <option value="">-- Pilih Metode --</option>

        <option value="bank">
            Transfer Bank
        </option>

        <option value="ewallet">
            E-Wallet
        </option>

    </select>

</div>
<div id="bank_area" style="display:none;">

    <div class="mb-3">

        <label class="form-label">

            Nama Bank

        </label>

        <select
            name="bank_id"
            class="form-select">

            <option value="">

                -- Pilih Bank --

            </option>

            @foreach($banks as $bank)

                <option value="{{ $bank->id }}">

                    {{ $bank->nama_bank }}

                </option>

            @endforeach

        </select>

    </div>

</div>
<div id="ewallet_area" style="display:none;">

    <div class="mb-3">

        <label class="form-label">

            E-Wallet

        </label>

        <select
            name="ewallet_id"
            class="form-select">

            <option value="">

                -- Pilih E-Wallet --

            </option>

            @foreach($ewallets as $wallet)

                <option value="{{ $wallet->id }}">

                    {{ $wallet->nama_wallet }}

                </option>

            @endforeach

        </select>

    </div>

</div>
<div class="mb-3">

    <label class="form-label">

        Nomor Rekening / Nomor HP

    </label>

    <input
        type="text"
        name="account_number"
        class="form-control"
        required>

</div>
<div class="mb-4">

    <label class="form-label">

        Nama Pemilik Rekening

    </label>

    <input
        type="text"
        name="account_holder"
        class="form-control"
        required>

</div>

<div class="d-flex justify-content-end gap-2">

    <a
        href="/my-orders"
        class="btn btn-secondary rounded-pill">

        Batal

    </a>

    <button
        type="submit"
        class="btn btn-danger rounded-pill px-4">

        <i class="bi bi-send-fill me-2"></i>

        Kirim Komplain

    </button>

</div>

            </form>

        </div>

    </div>

</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const refundType = document.getElementById('refund_type');
    const bankArea = document.getElementById('bank_area');
    const ewalletArea = document.getElementById('ewallet_area');

    if (!refundType) return;

    refundType.addEventListener('change', function () {

        bankArea.style.display = 'none';
        ewalletArea.style.display = 'none';

        if (this.value === 'bank') {
            bankArea.style.display = 'block';
        } else if (this.value === 'ewallet') {
            ewalletArea.style.display = 'block';
        }

    });

});
</script>