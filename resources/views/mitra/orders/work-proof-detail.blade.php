@extends('layouts.mitra')

@section('content')

<div class="container">
    <div class="card shadow border-0 rounded-4">
        
        <div class="card-header bg-white py-3">
            <h4 class="fw-bold mb-1">
                Detail Bukti Pekerjaan
            </h4>
            <small class="text-muted">
                Berikut adalah bukti pekerjaan yang telah diunggah untuk pesanan ini.
            </small>
        </div>

        <div class="card-body">

            <!-- FOTO BUKTI -->
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Foto Pekerjaan</label>
                <div>
                    @if($order->work_photo)
                        <a href="{{ asset('uploads/work-proof/photos/' . $order->work_photo) }}" target="_blank">
                            <img src="{{ asset('uploads/work-proof/photos/' . $order->work_photo) }}" alt="Foto Bukti" class="img-fluid rounded border" style="max-height: 350px;">
                        </a>
                    @else
                        <p class="text-muted">Belum ada foto.</p>
                    @endif
                </div>
            </div>

            <!-- VIDEO BUKTI -->
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Video Bukti</label>
                <div>
                    @if($order->work_video)
                        <video controls class="w-100 rounded border" style="max-height: 300px; max-width: 500px;">
                            <source src="{{ asset('uploads/work-proof/videos/' . $order->work_video) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>
                    @else
                        <p class="text-muted">Tidak ada video.</p>
                    @endif
                </div>
            </div>

            <!-- CATATAN MITRA -->
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Catatan Mitra</label>
                <div class="p-3 bg-light rounded border">
                    {{ $order->work_note ?? '-' }}
                </div>
            </div>

            <!-- STATUS ORDER -->
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Status Order Saat Ini</label>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-2">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>

            <!-- TOMBOL KEMBALI -->
            <div class="d-flex justify-content-end">
                <a href="/orders" class="btn btn-secondary rounded-pill px-4">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>

@endsection