@extends('layouts.pelanggan')

@section('content')

<style>
.cart-header {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 30px;
    padding: 40px;
    color: white;
    margin-bottom: 40px;
}

.cart-card {
    border: none;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
    transition: .3s;
}

.cart-card:hover {
    transform: translateY(-3px);
}

.cart-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 20px;
}

.qty-box {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8fafc;
    padding: 8px 15px;
    border-radius: 50px;
}

.qty-btn {
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    background: #2563eb;
    color: white;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    cursor: pointer;
}

.qty-btn:hover {
    background: #1d4ed8;
}

.qty-number {
    font-weight: 700;
    font-size: 18px;
    min-width: 20px;
    text-align: center;
}

.summary-card {
    border: none;
    border-radius: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
    position: sticky;
    top: 100px;
}

.checkout-btn {
    background: #16a34a;
    color: white;
    border-radius: 50px;
    padding: 15px;
    font-weight: 700;
    text-decoration: none;
    display: block;
    text-align: center;
    border: none;
    transition: background 0.2s;
}

.checkout-btn:hover {
    background: #15803d;
    color: white;
}

.delete-btn {
    color: #ef4444;
    text-decoration: none;
    font-weight: 600;
}

.empty-box {
    background: white;
    border-radius: 30px;
    padding: 80px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
}
</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="cart-header">
        <h1 class="fw-bold">🛒 Keranjang Saya</h1>
        <p class="mb-0 opacity-75">Kelola layanan yang ingin Anda pesan</p>
    </div>

    @if($carts->count())
    <div class="row g-4">
        <!-- LIST PRODUK -->
        <div class="col-lg-8">
            @foreach($carts as $cart)
            <div class="card cart-card mb-4" id="cart-item-{{ $cart->id }}">
                <div class="card-body p-4">
                    <div class="d-flex gap-4">
                        <!-- GAMBAR -->
                        @if($cart->service->image)
                        <img src="{{ asset('uploads/'.$cart->service->image) }}" class="cart-image">
                        @else
                        <img src="https://placehold.co/200" class="cart-image">
                        @endif

                        <!-- DETAIL -->
                        <div class="flex-grow-1">
                            <span class="badge bg-primary-subtle text-primary rounded-pill mb-2">
                                {{ $cart->service->category }}
                            </span>
                            <h4 class="fw-bold">{{ $cart->service->name }}</h4>
                            <p class="text-muted mb-0">{{ $cart->service->duration }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- QTY -->
                                <div class="qty-box">
                                    <button type="button" class="qty-btn btn-min" data-id="{{ $cart->id }}">-</button>
                                    <span class="qty-number" id="qty-{{ $cart->id }}">{{ $cart->qty }}</span>
                                    <button type="button" class="qty-btn btn-plus" data-id="{{ $cart->id }}">+</button>
                                </div>

                                <!-- HARGA -->
                                <div class="text-end">
                                    <h4 class="fw-bold text-primary mb-1">
                                        Rp <span class="item-subtotal" id="subtotal-{{ $cart->id }}" data-price="{{ $cart->service->price }}">
                                            {{ number_format($cart->service->price * $cart->qty, 0, ',', '.') }}
                                        </span>
                                    </h4>
                                    <a href="/cart/delete/{{ $cart->id }}" class="delete-btn small text-decoration-none">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- RINGKASAN -->
        <div class="col-lg-4">
            <div class="card summary-card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Ringkasan Pesanan</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Item</span>
                        <strong id="total-items">{{ $carts->count() }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Harga Jasa</span>
                        <span class="fw-semibold">Rp <span id="total-jasa">{{ number_format($total, 0, ',', '.') }}</span></span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Biaya Layanan</span>
                        <span class="fw-semibold text-muted">Rp <span id="biaya-layanan" data-value="10000">10.000</span></span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total Pembayaran</span>
                        <h4 class="fw-bold text-primary">
                            Rp <span id="grand-total">{{ number_format($total + 10000, 0, ',', '.') }}</span>
                        </h4>
                    </div>

                    <a href="/checkout" class="checkout-btn w-100 py-3 text-center d-flex align-items-center justify-content-center shadow-sm text-white">
                        <i class="bi bi-calendar-event me-2 fs-5"></i>
                        Pilih Jadwal Kedatangan
                    </a>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- EMPTY -->
    <div class="empty-box">
        <i class="bi bi-cart-x" style="font-size:80px; color:#cbd5e1;"></i>
        <h3 class="fw-bold mt-4">Keranjang Masih Kosong</h3>
        <p class="text-muted">Yuk pilih layanan terbaik untuk rumah Anda</p>
        <a href="/pelanggan" class="btn btn-primary rounded-pill px-4">Cari Layanan</a>
    </div>
    @endif

</div>

<!-- AJAX SCRIPT UNTUK KLIK TOMBOL + & - -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Pengaturan global header AJAX untuk keamanan CSRF token Laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Menggunakan delegated event $(document).on agar deteksi klik jauh lebih responsif
    $(document).on('click', '.btn-plus', function(e) {
        e.preventDefault();
        let cartId = $(this).data('id');
        updateQuantity(cartId, 'increment');
    });

    $(document).on('click', '.btn-min', function(e) {
        e.preventDefault();
        let cartId = $(this).data('id');
        let currentQty = parseInt($('#qty-' + cartId).text());
        
        if (currentQty > 1) {
            updateQuantity(cartId, 'decrement');
        } else {
            if (confirm('Hapus item ini dari keranjang?')) {
                window.location.href = '/cart/delete/' + cartId;
            }
        }
    });

    function updateQuantity(id, action) {
        $.ajax({
            url: '/cart/update-qty',
            method: 'POST',
            data: {
                id: id,
                action: action
            },
            success: function(response) {
                if(response.success) {
                    // Update teks kuantitas di halaman web
                    $('#qty-' + id).text(response.new_qty);

                    // Ambil harga asli & kalkulasi subtotal per item
                    let price = parseFloat($('#subtotal-' + id).data('price'));
                    let newSubtotal = price * response.new_qty;
                    $('#subtotal-' + id).text(formatRupiah(newSubtotal));

                    // Kalkulasi ulang seluruh ringkasan belanja di sisi kanan
                    calculateTotal();
                } else {
                    alert('Gagal memperbarui: ' + (response.message || 'Error tidak diketahui'));
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan jaringan atau server.');
            }
        });
    }

    function calculateTotal() {
        let totalJasa = 0;
        $('.item-subtotal').each(function() {
            let id = $(this).attr('id').split('-')[1];
            let price = parseFloat($(this).data('price'));
            let qty = parseInt($('#qty-' + id).text());
            totalJasa += price * qty;
        });

        let biayaLayanan = parseFloat($('#biaya-layanan').data('value'));
        let grandTotal = totalJasa + biayaLayanan;

        $('#total-jasa').text(formatRupiah(totalJasa));
        $('#grand-total').text(formatRupiah(grandTotal));
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }
});
</script>

@endsection