@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold">Detail Verifikasi Mitra</h3>
        <small class="text-muted">Periksa seluruh data mitra sebelum melakukan verifikasi.</small>
    </div>
    <a href="{{ route('admin.mitra') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left" style="font-size: 1rem !important; vertical-align: middle;"></i> Kembali
</a>
</div>

<div class="row">
    <!-- KIRI -->
    <div class="col-lg-4">
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body text-center">
                @if($mitra->photo)
                    <img src="{{ asset('storage/'.$mitra->photo) }}" class="rounded-circle shadow" width="130" height="130" style="object-fit:cover">
                @else
                    <i class="bi bi-person-circle text-primary" style="font-size:120px"></i>
                @endif
                <h4 class="mt-3">{{ $mitra->name }}</h4>
                <p class="text-muted">{{ $mitra->email }}</p>
                <span class="badge bg-warning">Menunggu Verifikasi</span>
            </div>
        </div>

        <!-- STATUS -->
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-white">
                <h5 class="fw-bold">Status Akun</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Email</th>
                        <td>
                            @if($mitra->email_verified)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Belum</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>WhatsApp</th>
                        <td>
                            @if($mitra->phone_verified)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Belum</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($mitra->is_online)
                                <span class="badge bg-success">Online</span>
                            @else
                                <span class="badge bg-secondary">Offline</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- KANAN -->
    <div class="col-lg-8">
        <!-- DATA PRIBADI -->
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-header bg-white">
                <h5 class="fw-bold">Data Pribadi</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Nama Lengkap</th>
                        <td>{{ $mitra->name }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $mitra->nik }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $mitra->email }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>{{ $mitra->phone }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>{{ $mitra->birth_place }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ optional($mitra->birth_date)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $mitra->address }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- DATA USAHA -->
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-white">
                <h5 class="fw-bold">Data Usaha</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Nama Usaha</th>
                        <td>{{ $mitra->business_name }}</td>
                    </tr>
                    <tr>
                        <th>Area Operasional</th>
                        <td>{{ $mitra->business_area }}</td>
                    </tr>
                    <tr>
                        <th>Spesialisasi</th>
                        <td>{{ $mitra->specialization }}</td>
                    </tr>
                    <tr>
                        <th>Pengalaman</th>
                        <td>{{ $mitra->experience }}</td>
                    </tr>
                    <tr>
                        <th>Jam Operasional</th>
                        <td>{{ $mitra->open_time }} - {{ $mitra->close_time }}</td>
                    </tr>
                    <tr>
                        <th>Hari Libur</th>
                        <td>{{ $mitra->holiday }}</td>
                    </tr>
                    <tr>
                        <th>Garansi</th>
                        <td>
                            @if($mitra->service_warranty)
                                <span class="badge bg-success">Ada</span>
                            @else
                                <span class="badge bg-danger">Tidak Ada</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DOKUMEN PENDUKUNG -->
<div class="card border-0 shadow rounded-4 mt-4">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-folder2-open text-primary"></i> Dokumen Pendukung Mitra
        </h5>
    </div>
    <div class="card-body">
        <h5 class="fw-bold mb-3">📄 Foto KTP</h5>
        @if($mitra->ktp_photo)
            <div class="text-center mb-5">
                <img src="{{ asset('storage/'.$mitra->ktp_photo) }}" class="img-fluid rounded shadow" style="max-height:350px;cursor:pointer" data-bs-toggle="modal" data-bs-target="#ktpModal">
            </div>
        @else
            <div class="alert alert-warning">Foto KTP belum tersedia.</div>
        @endif

        <h5 class="fw-bold mb-3">🏪 Foto Tempat Usaha</h5>
        @if($mitra->business_photo)
            <div class="text-center mb-5">
                <img src="{{ asset('storage/'.$mitra->business_photo) }}" class="img-fluid rounded shadow" style="max-height:350px;cursor:pointer" data-bs-toggle="modal" data-bs-target="#usahaModal">
            </div>
        @else
            <div class="alert alert-warning">Foto usaha belum tersedia.</div>
        @endif

        <h5 class="fw-bold mb-3">🖼 Portofolio Pekerjaan</h5>
        <div class="row">
            @php
                $photos = [];
                if($mitra->portfolio_photos){
                    $photos = is_array($mitra->portfolio_photos)
                        ? $mitra->portfolio_photos
                        : json_decode($mitra->portfolio_photos, true);
                }
            @endphp

            @if(!empty($photos))
                @foreach($photos as $photo)
                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                        <img src="{{ asset('storage/'.$photo) }}" class="img-fluid rounded shadow portfolio-img" style="height:180px;width:100%;object-fit:cover;cursor:pointer" data-image="{{ asset('storage/'.$photo) }}">
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-secondary">Belum ada portofolio.</div>
                </div>
            @endif
        </div>

        <h5 class="fw-bold mt-4 mb-3">📝 Deskripsi Pekerjaan</h5>
        <div class="border rounded-4 p-4 bg-light">
            @if($mitra->description)
                {{ $mitra->description }}
            @else
                <span class="text-muted">Belum ada deskripsi pekerjaan.</span>
            @endif
        </div>

        <h5 class="fw-bold mt-4 mb-3">📍 Lokasi Usaha</h5>
        @if($mitra->latitude && $mitra->longitude)
            <iframe width="100%" height="350" style="border:0" loading="lazy" allowfullscreen src="https://maps.google.com/maps?q={{ $mitra->latitude }},{{ $mitra->longitude }}&z=15&output=embed"></iframe>
        @else
            <div class="alert alert-warning">Lokasi belum tersedia.</div>
        @endif

        <h5 class="fw-bold mt-4 mb-3">💳 Rekening Pencairan</h5>
        <table class="table table-bordered">
            <tr>
                <th width="30%">Metode</th>
                <td>{{ ucfirst($mitra->withdraw_type) }}</td>
            </tr>
            <tr>
                <th>Bank / E-Wallet</th>
                <td>
                    @if($mitra->withdraw_type == 'bank')
                        {{ optional($mitra->bank)->nama_bank }}
                    @else
                        {{ optional($mitra->ewallet)->nama_wallet }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nomor</th>
                <td>{{ $mitra->withdraw_number }}</td>
            </tr>
            <tr>
                <th>Atas Nama</th>
                <td>{{ $mitra->withdraw_name }}</td>
            </tr>
        </table>

        <h5 class="fw-bold mt-4 mb-3">📱 Media Sosial</h5>
        <table class="table table-bordered">
            <tr>
                <th width="30%">Instagram</th>
                <td>{{ $mitra->instagram_url ?: '-' }}</td>
            </tr>
            <tr>
                <th>Facebook</th>
                <td>{{ $mitra->facebook_url ?: '-' }}</td>
            </tr>
            <tr>
                <th>TikTok</th>
                <td>{{ $mitra->tiktok_url ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<!-- CHECKLIST VERIFIKASI -->
<div class="card border-0 shadow rounded-4 mt-4">
    <div class="card-header bg-white">
        <h5 class="fw-bold">
            <i class="bi bi-check2-square text-success"></i> Checklist Verifikasi
        </h5>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <td>Foto Profil</td>
                <td>
                    @if($mitra->photo)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Foto KTP</td>
                <td>
                    @if($mitra->ktp_photo)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Foto Tempat Usaha</td>
                <td>
                    @if($mitra->business_photo)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Portofolio</td>
                <td>
                    @if($mitra->portfolio_photos)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>
                    @if($mitra->latitude && $mitra->longitude)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Rekening</td>
                <td>
                    @if($mitra->withdraw_number)
                        <span class="badge bg-success">Lengkap</span>
                    @else
                        <span class="badge bg-danger">Belum Ada</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- TOMBOL AKSI -->
<form action="{{ route('admin.mitra.approve', $mitra->id) }}" method="POST">
    @csrf
    <button class="btn btn-success btn-lg w-100 mt-4">
        <i class="bi bi-check-circle-fill"></i> Approve Mitra
    </button>
</form>

<button class="btn btn-danger btn-lg w-100 mt-3" data-bs-toggle="modal" data-bs-target="#rejectModal">
    <i class="bi bi-x-circle-fill"></i> Reject Mitra
</button>

<!-- MODALS -->
<div class="modal fade" id="ktpModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Foto KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/'.$mitra->ktp_photo) }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="usahaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Foto Tempat Usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/'.$mitra->business_photo) }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="portfolioModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Preview Portofolio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewPortfolio" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.mitra.reject', $mitra->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Penolakan Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Masukkan Alasan Penolakan</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" required placeholder="Contoh: Foto KTP tidak jelas atau tidak sesuai."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Mitra</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.portfolio-img').forEach(function(img){
    img.onclick = function(){
        document.getElementById('previewPortfolio').src = this.dataset.image;
        new bootstrap.Modal(document.getElementById('portfolioModal')).show();
    }
});
</script>

@endsection