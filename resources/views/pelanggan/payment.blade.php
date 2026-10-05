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
        min-height: 600px;
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

                <span class="fw-bold text-primary">
                    Pembayaran
                </span>

            </div>


            <div class="card payment-card bg-white p-4 p-md-5">


                <!-- Status & Title -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">

                    <div>

                        <span class="badge badge-soft-primary px-3 py-2 rounded-pill fw-semibold mb-2">

                            Order #{{ $order->id }}

                        </span>

                        <h4 class="fw-bold text-dark mb-0">

                            Pembayaran Layanan

                        </h4>

                    </div>


                    <div class="text-end">

                        <span
                            id="payment-badge"
                            class="badge badge-soft-warning px-3 py-2 rounded-pill fw-medium"
                        >

                            <i class="bi bi-clock me-1"></i>

                            Menunggu Pembayaran

                        </span>

                    </div>

                </div>


                <!-- Rincian Pesanan -->
                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <div class="p-3 bg-light rounded-4 h-100">

                            <div class="text-muted small mb-1">
                                Penyedia Layanan / Mitra
                            </div>

                            <div class="fw-bold text-dark fs-6">

                                {{ $order->mitra->name ?? 'Beres.in Partner' }}

                            </div>


                            <div class="text-muted small mt-2">
                                Jadwal Kedatangan:
                            </div>

                            <div class="fw-medium text-dark small">

                                📅
                                {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('l, d F Y') }}

                                ({{ $order->jam }})

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="p-3 bg-light rounded-4 h-100 d-flex flex-column justify-content-between">

                            <div>

                                <div class="text-muted small mb-1">
                                    Total Tagihan
                                </div>

                                <div class="fw-bold text-primary fs-3">

                                    Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}

                                </div>

                            </div>


                            <div class="text-muted small">

                                <i class="bi bi-shield-check text-success"></i>

                                Sudah termasuk biaya penanganan & garansi

                            </div>

                        </div>

                    </div>

                </div>


                <!-- MIDTRANS -->
                <!-- =================================================
     METODE PEMBAYARAN
================================================== -->

<div class="mb-4">

    <label class="form-label fw-bold text-dark mb-3">
        Pilih Metode Pembayaran
    </label>


    <!-- =================================================
         SALDO BERES.IN
    ================================================== -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <div
                        class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3"
                        style="width:48px;height:48px;"
                    >
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>

                    <div>

                        <div class="fw-bold">
                            Saldo Beres.in
                        </div>

                        <div class="text-muted small">
                            Saldo tersedia:
                            <strong class="text-dark">
                                Rp {{ number_format($balance, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>


            <hr>


            @if($balance >= $order->total_price)

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="small text-muted">
                            Total pembayaran
                        </div>

                        <div class="fw-bold text-success fs-5">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>

                    </div>


                    <form
                        action="{{ route('checkout.pay-balance', $order->id) }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-success rounded-pill px-4"
                            onclick="return confirm('Gunakan saldo Beres.in untuk membayar pesanan ini?')"
                        >

                            <i class="bi bi-wallet2 me-1"></i>

                            Bayar dengan Saldo

                        </button>

                    </form>

                </div>

            @else

                <div class="alert alert-warning mb-0 rounded-3">

                    <i class="bi bi-exclamation-circle me-2"></i>

                    Saldo tidak mencukupi untuk membayar pesanan ini.

                    <div class="small mt-1">

                        Saldo kamu:
                        <strong>
                            Rp {{ number_format($balance, 0, ',', '.') }}
                        </strong>

                        <br>

                        Total pesanan:
                        <strong>
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            @endif

        </div>

    </div>


    <!-- =================================================
         PEMISAH
    ================================================== -->

    <div class="text-center text-muted small mb-4">

        <span class="px-3 bg-white position-relative" style="z-index:2;">
            ATAU BAYAR DENGAN
        </span>

        <hr style="margin-top:-9px;">

    </div>


    <!-- =================================================
         MIDTRANS
    ================================================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="fw-bold mb-3">

                <i class="bi bi-credit-card me-2 text-primary"></i>

                Pembayaran Online

            </div>

            <div id="snap-container"></div>


            <!-- Loading -->

            <div
                id="payment-loading"
                class="text-center py-4"
            >

                <div
                    class="spinner-border text-primary"
                    role="status"
                >

                    <span class="visually-hidden">
                        Loading...
                    </span>

                </div>

                <div class="mt-2 text-muted">
                    Memuat metode pembayaran...
                </div>

            </div>

        </div>

    </div>

</div>


                <!-- Footer -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center pt-3 border-top gap-2">

                    <a
                        href="{{ route('pelanggan.orders') }}"
                        class="btn btn-link text-muted text-decoration-none small p-0"
                    >

                        ← Bayar Nanti & Check Pesanan

                    </a>


                    <span class="text-muted small">

                        Butuh bantuan?

                        <a
                            href="#"
                            class="text-primary text-decoration-none"
                        >

                            Hubungi CS

                        </a>

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ===================================================== -->
<!-- MIDTRANS SNAP SDK -->
<!-- ===================================================== -->

<script
    src="{{ config('midtrans.is_production')
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"
></script>


<script>

const orderId = {{ $order->id }};

const redirectUrl = "{{ route('pelanggan.orders') }}";


/*
|--------------------------------------------------------------------------
| Simpan informasi pembayaran
|--------------------------------------------------------------------------
*/

function savePaymentInfo(result)
{

    console.log("Midtrans Result:", result);


    return fetch(
        "{{ route('checkout.save-payment-info') }}",
        {

            method: "POST",

            headers:
            {
                "Content-Type": "application/json",

                "Accept": "application/json",

                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}"
            },

            body: JSON.stringify(
            {

                order_id: orderId,

                transaction_id:
                    result.transaction_id ?? null,

                payment_type:
                    result.payment_type ?? null,

                va_numbers:
                    result.va_numbers ?? null,

                permata_va_number:
                    result.permata_va_number ?? null,

                bill_key:
                    result.bill_key ?? null,

                biller_code:
                    result.biller_code ?? null,

                expiry_time:
                    result.expiry_time ?? null

            })

        }
    )

    .then(async response =>
    {

        if (!response.ok)
        {

            const text =
                await response.text();

            console.error(text);

            throw new Error(
                "Gagal menyimpan data pembayaran."
            );

        }

        return response.json();

    });

}


/*
|--------------------------------------------------------------------------
| Tampilkan Midtrans otomatis
|--------------------------------------------------------------------------
*/

window.addEventListener(
    'load',
    function()
    {

        const loading =
            document.getElementById(
                'payment-loading'
            );


        /*
        |--------------------------------------------------------------------------
        | Pastikan Snap sudah tersedia
        |--------------------------------------------------------------------------
        */

        if (typeof window.snap === 'undefined')
        {

            console.error(
                "Midtrans Snap SDK belum tersedia."
            );

            if (loading)
            {

                loading.innerHTML = `
                    <div class="alert alert-danger">
                        Gagal memuat pembayaran Midtrans.
                        Silakan refresh halaman.
                    </div>
                `;

            }

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Hilangkan loading
        |--------------------------------------------------------------------------
        */

        if (loading)
        {

            loading.style.display = 'none';

        }


        /*
        |--------------------------------------------------------------------------
        | EMBED MIDTRANS
        |--------------------------------------------------------------------------
        */
console.log("Snap Token:", "{{ $snapToken }}");
console.log("Window Snap:", window.snap);
        window.snap.embed(
            "{{ $snapToken }}",
            {

                embedId:
                    "snap-container",


                /*
                |--------------------------------------------------------------------------
                | Pembayaran berhasil
                |--------------------------------------------------------------------------
                */

                onSuccess:
                    function(result)
                    {

                        console.log(
                            "Pembayaran berhasil:",
                            result
                        );


                        savePaymentInfo(result)

                            .then(function()
                            {

                                updatePaymentBadge(
                                    "success"
                                );


                                setTimeout(
                                    function()
                                    {

                                        window.location.href =
                                            redirectUrl;

                                    },
                                    1500
                                );

                            })

                            .catch(function(error)
                            {

                                console.error(error);

                                alert(
                                    "Pembayaran berhasil, tetapi data pembayaran gagal disimpan."
                                );

                            });

                    },


                /*
                |--------------------------------------------------------------------------
                | Pembayaran pending
                |--------------------------------------------------------------------------
                */

                onPending:
                    function(result)
                    {

                        console.log(
                            "Pembayaran pending:",
                            result
                        );


                        savePaymentInfo(result)

                            .then(function()
                            {

                                updatePaymentBadge(
                                    "pending"
                                );

                            })

                            .catch(function(error)
                            {

                                console.error(error);

                            });

                    },


                /*
                |--------------------------------------------------------------------------
                | Pembayaran gagal
                |--------------------------------------------------------------------------
                */

                onError:
                    function(result)
                    {

                        console.log(
                            "Pembayaran gagal:",
                            result
                        );


                        updatePaymentBadge(
                            "failed"
                        );

                    },


                /*
                |--------------------------------------------------------------------------
                | Popup ditutup
                |--------------------------------------------------------------------------
                */

                onClose:
                    function()
                    {

                        console.log(
                            "Midtrans ditutup."
                        );

                    }

            }
        );

    }
);


/*
|--------------------------------------------------------------------------
| Update Badge
|--------------------------------------------------------------------------
*/

function updatePaymentBadge(type)
{

    const badge =
        document.getElementById(
            "payment-badge"
        );


    if (!badge)
        return;


    if (type === "success")
    {

        badge.className =
            "badge badge-soft-success px-3 py-2 rounded-pill fw-medium";

        badge.innerHTML =
            `
            <i class="bi bi-check-circle me-1"></i>
            Pembayaran Berhasil
            `;

    }


    else if (type === "failed")
    {

        badge.className =
            "badge bg-danger px-3 py-2 rounded-pill fw-medium";

        badge.innerHTML =
            `
            <i class="bi bi-x-circle me-1"></i>
            Pembayaran Gagal
            `;

    }


    else
    {

        badge.className =
            "badge badge-soft-warning px-3 py-2 rounded-pill fw-medium";

        badge.innerHTML =
            `
            <i class="bi bi-clock me-1"></i>
            Menunggu Pembayaran
            `;

    }

}


/*
|--------------------------------------------------------------------------
| Auto Check Status Pembayaran
|--------------------------------------------------------------------------
*/

const checkInterval =
    setInterval(
        function()
        {

            fetch(
                "/checkout/check-status/" +
                orderId
            )

            .then(
                response =>
                    response.json()
            )

            .then(
                function(data)
                {

                    console.log(
                        "Status pembayaran:",
                        data
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | PEMBAYARAN BERHASIL
                    |--------------------------------------------------------------------------
                    */

                    if (

                        data.payment_status ===
                            "settlement"

                        ||

                        data.payment_status ===
                            "capture"

                        ||

                        data.payment_status ===
                            "lunas"

                    )
                    {

                        clearInterval(
                            checkInterval
                        );


                        updatePaymentBadge(
                            "success"
                        );


                        setTimeout(
                            function()
                            {

                                window.location.href =
                                    redirectUrl;

                            },
                            1500
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PEMBAYARAN GAGAL
                    |--------------------------------------------------------------------------
                    */

                    if (

                        data.payment_status ===
                            "expire"

                        ||

                        data.payment_status ===
                            "cancel"

                        ||

                        data.payment_status ===
                            "deny"

                    )
                    {

                        clearInterval(
                            checkInterval
                        );


                        updatePaymentBadge(
                            "failed"
                        );

                    }

                }
            )

            .catch(
                function(error)
                {

                    console.log(
                        "Gagal mengecek status:",
                        error
                    );

                }
            );

        },
        3000
    );

</script>

@endsection