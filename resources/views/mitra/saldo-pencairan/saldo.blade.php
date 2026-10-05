@extends('layouts.mitra')

@section('content')

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-wallet2 text-success"></i>
                Saldo & Pencairan
            </h2>
            <p class="text-muted mb-0">
                Kelola saldo usaha dan ajukan pencairan dana.
            </p>
        </div>

        <a href="{{ url()->current() }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </a>
    </div>

    <!-- ================= CARD SALDO ================= -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <small class="text-muted">Saldo Tersedia</small>
                        <h1 class="fw-bold text-success mt-2 mb-4">
                            Rp {{ number_format($saldo, 0, ',', '.') }}
                        </h1>
                    </div>
                    

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted">Total Pendapatan</small>
                                <h5 class="fw-bold text-primary mt-2 mb-0">
                                    Rp {{ number_format($totalPendapatan ?? $pendapatan ?? 0, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted">Sudah Dicairkan</small>
                                <h5 class="fw-bold text-success mt-2 mb-0">
                                    Rp {{ number_format($sudahDicairkan ?? 0, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 bg-light">
                                <small class="text-muted">Menunggu Pencairan</small>
                                <h5 class="fw-bold text-warning mt-2 mb-0">
                                    Rp {{ number_format($menunggu ?? 0, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= INFO REKENING ================= -->
        <div class="col-lg-4">
            <div class="card border-0 shadow rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Rekening Pencairan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted">Metode</small>
                        <div class="fw-bold text-capitalize">
                            {{ Auth::user()->withdraw_type ?? '-' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Bank / E-Wallet</small>
                        <div class="fw-bold">
                            @if(strtolower(Auth::user()->withdraw_type ?? '') == 'bank')
                                {{ optional(Auth::user()->bank)->nama_bank ?? Auth::user()->bank_name ?? '-' }}
                            @else
                                {{ optional(Auth::user()->ewallet)->nama_wallet ?? Auth::user()->bank_name ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Nomor Rekening</small>
                        <div class="fw-bold">
                            {{ Auth::user()->withdraw_number ?? Auth::user()->bank_account ?? '-' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Nama Pemilik</small>
                        <div class="fw-bold text-success">
                            {{ Auth::user()->withdraw_name ?? Auth::user()->account_holder ?? '-' }}
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info mt-3 mb-0 small">
                        <i class="bi bi-shield-check me-1"></i>
                        <strong>Rekening telah diverifikasi.</strong><br>
                        Untuk keamanan, perubahan data rekening dilakukan melalui Admin.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= AJUKAN PENCAIRAN ================= -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-white pt-4 px-4 pb-0 border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-cash-stack text-success me-1"></i>
                        Ajukan Pencairan Dana
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- Alert Menampilkan Pesan Error / Validasi Laravel -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Pengajuan Gagal:</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('mitra.withdraw') }}" method="POST" id="withdrawForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="amount">
                                    Nominal Pencairan
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input 
                                        type="number" 
                                        min="12500" 
                                        max="{{ (float)$saldo }}" 
                                        class="form-control @error('amount') is-invalid @enderror" 
                                        id="amount" 
                                        name="amount" 
                                        placeholder="Masukkan nominal (Min. 12.500)" 
                                        required
                                        {{ $saldo < 12500 ? 'disabled' : '' }}>
                                </div>

                                <small class="text-muted d-block mt-1">
                                    Minimal pencairan Rp12.500 (Maksimal Rp {{ number_format($saldo, 0, ',', '.') }})
                                </small>

                                <!-- Alert Validasi JS Realtime -->
                                <div class="alert alert-danger p-2 mt-2 mb-0 small d-none" id="alertExceed">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    <span id="alertMessage">Nominal pencairan melebihi saldo yang tersedia!</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 bg-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Saldo yang Dicairkan</span>
                                        <strong id="nominalDicairkan">Rp 0</strong>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Biaya Admin Transfer</span>
                                        <strong>Rp 2.500</strong>
                                    </div>

                                    <hr class="my-2">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Diterima Bersih</h6>
                                        <h5 class="text-success fw-bold mb-0" id="diterima">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" id="btnSubmit" class="btn btn-success btn-lg px-5" {{ $saldo < 12500 ? 'disabled' : '' }}>
                                <i class="bi bi-send-check-fill me-1"></i>
                                Ajukan Pencairan
                            </button>

                            @if($saldo < 12500)
                                <small class="text-danger d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> Saldo Anda belum mencapai batas minimum pencairan (Rp12.500).
                                </small>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= RIWAYAT PENCAIRAN ================= -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-white pt-4 px-4 pb-0 border-0">
                    <h5 class="fw-bold mb-0">Riwayat Pengajuan Pencairan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tujuan Transfer</th>
                                    <th>Nominal</th>
                                    <th>Biaya Admin</th>
                                    <th>Diterima</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                           <tbody>
    @forelse($withdrawals ?? [] as $item)
    <tr>
        <td>{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>
        <td>
            @php
                // Cek tipe dari profil user
                $userType = strtolower(Auth::user()->withdraw_type ?? 'bank');
                $isEwallet = ($userType == 'ewallet' || $userType == 'e-wallet');

                // Label Tipe
                $labelTipe = $isEwallet ? 'E-WALLET' : 'BANK';

                // Ambil Nama Bank / E-Wallet (Abaikan jika nilai di DB masih tertulis 'ewallet' atau 'bank')
                $destination = $item->bank_name;
                if (!$destination || in_array(strtolower($destination), ['ewallet', 'e-wallet', 'bank', 'ewallet/bank'])) {
                    if ($isEwallet) {
                        $destination = optional(Auth::user()->ewallet)->nama_wallet ?? 'GoPay';
                    } else {
                        $destination = optional(Auth::user()->bank)->nama_bank ?? 'Bank';
                    }
                }

                $accNumber = $item->bank_account ?? Auth::user()->withdraw_number ?? '-';
                $accName   = $item->account_holder ?? Auth::user()->withdraw_name ?? '-';
            @endphp

            <span class="fw-bold text-dark text-uppercase">{{ $labelTipe }}</span> - {{ $destination }}<br>
            <small class="text-muted">{{ $accNumber }} a.n {{ $accName }}</small>
        </td>
        <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
        <td>Rp 2.500</td>
        <td class="fw-bold text-success">Rp {{ number_format(max(0, $item->amount - 2500), 0, ',', '.') }}</td>
        <td>
            @if(in_array($item->status, ['pending', 'menunggu']))
                <span class="badge bg-warning text-dark">Menunggu Admin</span>
            @elseif($item->status == 'processing')
                <span class="badge bg-info text-dark">Sedang Diproses</span>
            @elseif(in_array($item->status, ['success', 'approved', 'berhasil']))
                <span class="badge bg-success">Berhasil Dicairkan</span>
            @elseif($item->status == 'failed')
                <span class="badge bg-danger">Gagal Transfer</span>
            @else
                <span class="badge bg-secondary">Ditolak</span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">
            Belum ada riwayat pengajuan pencairan.
        </td>
    </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const withdrawForm = document.getElementById('withdrawForm');
    const amountInput = document.getElementById('amount');
    const nominalDicairkanText = document.getElementById('nominalDicairkan');
    const diterimaText = document.getElementById('diterima');
    const alertExceed = document.getElementById('alertExceed');
    const alertMessage = document.getElementById('alertMessage');
    const btnSubmit = document.getElementById('btnSubmit');
    
    const maxSaldo = Number("{{ (float)$saldo }}") || 0;
    const adminFee = 2500;

    if (amountInput) {
        amountInput.addEventListener('input', function () {
            let nominal = parseInt(this.value) || 0;

            // Display Nominal
            nominalDicairkanText.innerText = 'Rp ' + nominal.toLocaleString('id-ID');

            // Hitung Diterima Bersih
            let hasil = nominal - adminFee;
            diterimaText.innerText = 'Rp ' + (hasil > 0 ? hasil.toLocaleString('id-ID') : 0);

            // Validasi Realtime Input
            if (nominal > maxSaldo) {
                alertMessage.innerText = 'Nominal pencairan melebihi saldo yang tersedia!';
                alertExceed.classList.remove('d-none');
                amountInput.classList.add('is-invalid');
                btnSubmit.disabled = true;
            } else if (nominal > 0 && nominal < 12500) {
                alertMessage.innerText = 'Nominal minimal pencairan adalah Rp 12.500';
                alertExceed.classList.remove('d-none');
                amountInput.classList.add('is-invalid');
                btnSubmit.disabled = true;
            } else {
                alertExceed.classList.add('d-none');
                amountInput.classList.remove('is-invalid');
                if (maxSaldo >= 12500 && nominal >= 12500) {
                    btnSubmit.disabled = false;
                }
            }
        });
    }

    // Penanganan Submit Form
    if (withdrawForm) {
        withdrawForm.addEventListener('submit', function (e) {
            setTimeout(() => {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';
            }, 10);
        });
    }
});
</script>

@endsection