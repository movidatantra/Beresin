@extends('layouts.admin')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Kelola Pencairan Saldo</h3>
            <span class="badge bg-warning fs-6">{{ $pending }} Pending</span>
        </div>

        {{-- CARD STATISTIK --}}
        <div class="row mb-4">
            @foreach(['Pending' => [$pending, 'warning'], 'Diproses' => [$processing, 'info'], 'Berhasil' => [$success, 'success'], 'Gagal' => [$failed, 'danger']] as $label => $val)
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">{{ $label }}</small>
                        <h2 class="text-{{ $val[1] }} fw-bold">{{ $val[0] }}</h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- SEARCH & FILTER --}}
        <form method="GET">
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama mitra...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['pending', 'menunggu', 'processing', 'success', 'failed', 'rejected'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        {{-- TABEL --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mitra</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Tujuan</th>
                        <th>Nama Pemilik</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $item)
                    <tr>
                        <td><strong>{{ $item->user->name ?? 'Mitra Tidak Ditemukan' }}</strong></td>
                        <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($item->withdraw_type) }}</td>
                        <td>
                            <strong>{{ $item->bank_name ?? '-' }}</strong><br>
                            <small>{{ $item->bank_account }}</small>
                        </td>
                        <td>{{ $item->account_holder }}</td>
                        <td>
                            @php 
                                $badge = [
                                    'pending' => 'warning', 
                                    'menunggu' => 'warning', 
                                    'processing' => 'info', 
                                    'success' => 'success',
                                    'rejected' => 'danger',
                                    'failed' => 'danger'
                                ]; 
                            @endphp
                            <span class="badge bg-{{ $badge[$item->status] ?? 'secondary' }}">{{ ucfirst($item->status) }}</span>
                        </td>
                        <td>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    {{-- MODAL DETAIL (Diletakkan di dalam perulangan agar ID unik per baris) --}}
                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Detail Pencairan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <p class="text-muted mb-1">Mitra</p>
                                        <strong class="fs-5">{{ $item->user->name ?? '-' }}</strong>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Nominal</p>
                                            <strong class="text-success fs-5">Rp {{ number_format($item->amount, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Metode</p>
                                            <strong>{{ ucfirst($item->withdraw_type) }} - {{ $item->bank_name }}</strong>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-1">Tujuan / No. Rek</p>
                                    <strong class="d-block mb-3">{{ $item->bank_account }} ({{ $item->account_holder }})</strong>
                                </div>
                                <div class="modal-footer">
                                    @if(in_array($item->status, ['pending', 'menunggu']))
                                        {{-- Form Tolak dengan AJAX --}}
                                        <form class="ajax-form d-inline" action="{{ route('admin.withdrawals.reject', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </form>

                                        {{-- Form Cairkan dengan AJAX --}}
                                        <form class="ajax-form d-inline" action="{{ route('admin.withdrawals.approve', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Cairkan</button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">Belum ada pengajuan pencairan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>

{{-- SCRIPT AJAX --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('submit', '.ajax-form', function(e) {
        e.preventDefault();
        let form = $(this);
        let btn = form.find('button[type="submit"]');
        let originalText = btn.text();

        btn.prop('disabled', true).text('Memproses...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if(response.success) {
                    alert(response.message);
                    location.reload(); 
                } else {
                    alert('Gagal: ' + response.message);
                    btn.prop('disabled', false).text(originalText);
                }
            },
            error: function(xhr) {
                let errMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                alert('Error: ' + errMessage);
                btn.prop('disabled', false).text(originalText);
            }
        });
    });
</script>
@endpush

@endsection