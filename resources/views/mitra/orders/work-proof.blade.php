@extends('layouts.mitra')

@section('content')

<div class="container">
    <div class="card shadow border-0 rounded-4">
        
        <!-- HEADER KONDISIONAL -->
        <div class="card-header bg-white py-3">
            <h4 class="fw-bold mb-1">
                {{ isset($order->workProof) && $order->workProof ? 'Detail Bukti Pekerjaan' : 'Upload Bukti Pekerjaan' }}
            </h4>
            <small class="text-muted">
                {{ isset($order->workProof) && $order->workProof ? 'Berikut adalah bukti pekerjaan yang telah diunggah.' : 'Upload bukti bahwa pekerjaan telah selesai sebelum pelanggan melakukan konfirmasi.' }}
            </small>
        </div>

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- JIKA BUKTI SUDAH ADA (TAMPILKAN DETAIL / READ-ONLY) --}}
            @if(isset($order->workProof) && $order->workProof)
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Foto Pekerjaan</label>
                    <div>
                        @if($order->workProof->work_photo)
                            <a href="{{ asset('storage/' . $order->workProof->work_photo) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->workProof->work_photo) }}" alt="Foto Bukti" class="img-fluid rounded border" style="max-height: 300px;">
                            </a>
                        @else
                            <p class="text-muted">Belum ada foto.</p>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Video Bukti</label>
                    <div>
                        @if($order->workProof->work_video)
                            <video controls class="w-100 rounded border" style="max-height: 300px;">
                                <source src="{{ asset('storage/' . $order->workProof->work_video) }}" type="video/mp4">
                                Browser Anda tidak Mendukung Pemutaran Video.
                            </video>
                        @else
                            <p class="text-muted">Tidak ada video.</p>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Catatan Mitra</label>
                    <div class="p-3 bg-light rounded">
                        {{ $order->workProof->work_note ?? '-' }}
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Status Order Saat Ini</label>
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-2">
                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="/orders" class="btn btn-secondary">
                        Kembali ke Kelola Order
                    </a>
                </div>

            {{-- JIKA BUKTI BELUM ADA (TAMPILKAN FORM UPLOAD) --}}
            @else
                <form action="/orders/{{ $order->id }}/work-proof"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto Bukti <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               name="work_photo"
                               class="form-control"
                               accept="image/*"
                               required>
                        @error('work_photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Video Bukti (Opsional)
                        </label>
                        <input type="file"
                               name="work_video"
                               class="form-control"
                               accept="video/*">
                        @error('work_video')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Catatan Pekerjaan
                        </label>
                        <textarea name="work_note"
                                  rows="5"
                                  class="form-control"
                                  placeholder="Contoh:
- AC sudah dicuci.
- Filter dibersihkan.
- Freon dalam kondisi normal."></textarea>
                        @error('work_note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="/orders" class="btn btn-secondary me-2">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            Upload Bukti & Kirim
                        </button>
                    </div>

                </form>
            @endif

        </div>
    </div>
</div>

@endsection