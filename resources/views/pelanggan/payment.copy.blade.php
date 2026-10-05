@extends('layouts.pelanggan')

@section('content')
<style>
    .payment-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .badge-soft-primary {
        background-color: #eef2ff;
        color: #4f46e5;
    }
    .badge-soft-warning {
        background-color: #fffbeb;
        color: #d97706;
    }
    .badge-soft-success {
        background-color: #d1fae5;
        color: #059669;
    }
    #snap-container iframe {
        border-radius: 16px !important;
        width: 100% !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Step Indicator -->
            <div class="d-flex justify-content-center align-items-center mb-4 gap-2 small text-muted">
                <span>Keranjang</span>
                <span>&rsaquo;</span>
                <span>Checkout</span>
                <span>&rsaquo;</span>
                <span class="fw-bold text-primary">Pembayaran</span>
            </div>

            <div class="card payment-card bg-white p-4 p-md-5">
                
                <!-- Status & Title -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <span class="badge badge-soft-primary px-3 py-2 rounded-pill fw-semibold mb-2">
                            Order #{{ $order->id }}
                        </span>
                        <h4 class="fw-bold text-dark mb-0">Pembayaran Layanan</h4>
                    </div>
                    <div class="text-end">
                        <span id="payment-badge" class="badge badge-soft-warning px-3 py-2 rounded-pill fw-medium">
                            <i class="bi bi-clock me-1"></i> Menunggu Pembayaran
                        </span>
                    </div>
                </div>

                <!-- Rincian Pesanan Singkat -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="text-muted small mb-1">Penyedia Layanan / Mitra</div>
                            <div class="fw-bold text-dark fs-6">{{ $order->mitra->name ?? 'Beres.in Partner' }}</div>
                            <div class="text-muted small mt-2">Jadwal Kedatangan:</div>
                            <div class="fw-medium text-dark small">
                                📅 {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('l, d F Y') }} ({{ $order->jam }})
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="text-muted small mb-1">Total Tagihan</div>
                                <div class="fw-bold text-primary fs-3">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-shield-check text-success"></i> Sudah termasuk biaya penanganan & garansi
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Midtrans Widget Container -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark mb-2">Pilih Metode Pembayaran di Bawah Ini:</label>
                    <div class="text-center mt-4">
    <button id="pay-button" class="btn btn-primary btn-lg">
        Bayar Sekarang
    </button>
</div>
                </div>

                <!-- Footer Actions -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center pt-3 border-top gap-2">
                    <a href="{{ route('pelanggan.orders') }}" class="btn btn-link text-muted text-decoration-none small p-0">
                        ← Bayar Nanti & Check Pesanan
                    </a>
                    <span class="text-muted small">Butuh bantuan? <a href="#" class="text-primary text-decoration-none">Hubungi CS</a></span>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap SDK -->
<script 
    src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script type="text/javascript">

const orderId = {{ $order->id }};
const redirectUrl = "{{ route('pelanggan.orders') }}";

/**
 * Simpan informasi pembayaran ke database
 */
function savePaymentInfo(result) {

    console.log("Midtrans Result :", result);

    return fetch("{{ route('checkout.save-payment-info') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({

            order_id: orderId,

            transaction_id: result.transaction_id ?? null,

            payment_type: result.payment_type ?? null,

            va_numbers: result.va_numbers ?? null,

            permata_va_number: result.permata_va_number ?? null,

            bill_key: result.bill_key ?? null,

            biller_code: result.biller_code ?? null,

            expiry_time: result.expiry_time ?? null

        })

    })

    .then(async response => {

        if (!response.ok) {

            let text = await response.text();

            console.error(text);

            throw new Error("Gagal menyimpan data pembayaran.");

        }

        return response.json();

    });

}


/**
 * Embed Midtrans
 */

document.getElementById('pay-button').onclick = function () {

    window.snap.pay("{{ $snapToken }}", {

        onSuccess: function(result){

            savePaymentInfo(result)
                .then(() => {
                    window.location.href = redirectUrl;
                });

        },

        onPending: function(result){

            console.log(result);

            savePaymentInfo(result)
                .then(() => {
                    window.location.href = redirectUrl;
                });

        },

        onError: function(result){

            console.log(result);

            alert("Pembayaran gagal");

        },

        onClose: function(){

            console.log("Popup ditutup");

        }

    });

};


/**
 * Auto Check Status
 */

const checkInterval = setInterval(function(){

    fetch("/checkout/check-status/" + orderId)

    .then(response => response.json())

    .then(function(data){

        if(data.payment_status === "settlement" ||

           data.payment_status === "capture"){

            clearInterval(checkInterval);

            const badge = document.getElementById("payment-badge");

            badge.className="badge badge-soft-success px-3 py-2 rounded-pill fw-medium";

            badge.innerHTML="<i class='bi bi-check-circle me-1'></i> Pembayaran Berhasil";

            setTimeout(function(){

                window.location.href = redirectUrl;

            },1500);

        }

        if(

            data.payment_status=="expire" ||

            data.payment_status=="cancel" ||

            data.payment_status=="deny"

        ){

            clearInterval(checkInterval);

            const badge=document.getElementById("payment-badge");

            badge.className="badge bg-danger px-3 py-2 rounded-pill fw-medium";

            badge.innerHTML="<i class='bi bi-x-circle me-1'></i> Pembayaran Gagal";

        }

    })

    .catch(function(error){

        console.log(error);

    });

},3000);

</script>
@endsection