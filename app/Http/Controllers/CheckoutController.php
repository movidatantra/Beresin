<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification as MidtransNotification;
use Midtrans\Snap;
use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * ============================================================
     * HALAMAN CHECKOUT
     * ============================================================
     */
    public function index()
    {
        $carts = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect('/cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        // Hitung subtotal
        $subtotal = 0;

        foreach ($carts as $cart) {
            $subtotal += $cart->service->price * $cart->qty;
        }

        // Biaya layanan Beres.in
        $serviceFee = 10000;

        // Total
        $total = $subtotal + $serviceFee;

        // Ambil mitra dari service pertama
        $mitraId = $carts->first()->service->mitra_id;

        $mitra = User::findOrFail($mitraId);

        // Generate slot berdasarkan jam operasional mitra
        $slots = [];

        if ($mitra->open_time && $mitra->close_time) {

            $mulai = strtotime($mitra->open_time);
            $selesai = strtotime($mitra->close_time);

            while ($mulai < $selesai) {

                $slots[] = date('H:i', $mulai);

                $mulai = strtotime('+1 hour', $mulai);
            }
        }

        return view(
            'pelanggan.checkout',
            compact(
                'carts',
                'subtotal',
                'serviceFee',
                'total',
                'slots',
                'mitra'
            )
        );
    }


    /**
     * ============================================================
     * SIMPAN ORDER
     * ============================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal'  => 'required|date|after_or_equal:today',
            'jam'     => 'required',
            'address' => 'required',
        ]);

        // Ambil cart
        $carts = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return back()
                ->with('error', 'Keranjang masih kosong.');
        }

        // Ambil mitra
        $mitraId = $carts->first()->service->mitra_id;

        $mitra = User::findOrFail($mitraId);

        // Pastikan mitra online
        if (!$mitra->is_online) {
            return back()
                ->with('error', 'Mitra sedang offline.');
        }

        /**
         * ========================================================
         * HITUNG HARGA
         * ========================================================
         */

        $subtotal = 0;

        foreach ($carts as $cart) {

            $subtotal +=
                $cart->service->price * $cart->qty;
        }

        // Biaya layanan Beres.in
        $serviceFee = 10000;

        // Total pembayaran
        $total = $subtotal + $serviceFee;


        /**
         * ========================================================
         * CEK SLOT BENTROK
         * ========================================================
         */

        $slotDipakai = Order::where('mitra_id', $mitraId)
            ->where('jadwal', $request->jadwal)
            ->where('jam', $request->jam)
            ->exists();

        if ($slotDipakai) {

            $mulai = strtotime($request->jam);

            $selesai = strtotime($mitra->close_time);

            while (
                strtotime('+1 hour', $mulai) < $selesai
            ) {

                $mulai = strtotime('+1 hour', $mulai);

                $jamBaru = date('H:i', $mulai);

                $dipakai = Order::where('mitra_id', $mitraId)
                    ->where('jadwal', $request->jadwal)
                    ->where('jam', $jamBaru)
                    ->exists();

                if (!$dipakai) {

                    return back()->with(
                        'warning',
                        'Jam tersebut baru saja terisi. ' .
                        'Slot berikutnya tersedia pukul ' .
                        $jamBaru
                    );
                }
            }

            return back()->with(
                'error',
                'Semua slot pada tanggal tersebut sudah penuh.'
            );
        }


        /**
         * ========================================================
         * SIMPAN ORDER
         * ========================================================
         *
         * status:
         * pending
         * diproses
         * selesai
         * dibatalkan
         *
         * payment_status:
         * belum_bayar
         * lunas
         * gagal
         *
         */

        $order = Order::create([

            'user_id' => Auth::id(),

            'mitra_id' => $mitraId,

            'service_id' =>
                $carts->first()->service_id,

            'subtotal' => $subtotal,

            'service_fee' => $serviceFee,

            'total_price' => $total,

            'jadwal' => $request->jadwal,

            'jam' => $request->jam,

            'address' => $request->address,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'note' => $request->note,

            // Order baru menunggu proses
            'status' => 'pending',

            // Pembayaran belum dilakukan
            'payment_status' => 'belum_bayar',

            'payment_method' => 'Midtrans / Online',
        ]);


        /**
         * ========================================================
         * GENERATE INVOICE
         * ========================================================
         */

        $order->update([
            'invoice_number' =>
                'BRS' .
                str_pad(
                    $order->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
        ]);


        /**
         * ========================================================
         * SIMPAN PAYMENT AWAL
         * ========================================================
         */

        Payment::create([

            'order_id' => $order->id,

            'order_code' =>
                'ORDER-' . $order->id,

            'gross_amount' =>
                $order->total_price,

            'transaction_status' =>
                'pending',
        ]);


        /**
         * ========================================================
         * SIMPAN ORDER ITEMS
         * ========================================================
         */

        foreach ($carts as $cart) {

            OrderItem::create([

                'order_id' => $order->id,

                'service_id' =>
                    $cart->service_id,

                'qty' =>
                    $cart->qty,

                'price' =>
                    $cart->service->price,
            ]);
        }


        /**
         * ========================================================
         * HAPUS CART
         * ========================================================
         */

        Cart::where(
            'user_id',
            Auth::id()
        )->delete();


        /**
         * ========================================================
         * KE HALAMAN PEMBAYARAN
         * ========================================================
         */

        return redirect()
            ->route(
                'checkout.payment',
                $order->id
            );
    }


    /**
     * ============================================================
     * HALAMAN PAYMENT MIDTRANS
     * ============================================================
     */
    public function payment($id)
    {
        $order = Order::with([
            'mitra',
            'payment'
        ])
            ->where(
                'user_id',
                Auth::id()
            )
            ->findOrFail($id);

            $customerBalance = CustomerBalance::firstOrCreate(
    [
        'user_id' => Auth::id()
    ],
    [
        'balance' => 0
    ]
);

$balance = (float) $customerBalance->balance;


        /**
         * ========================================================
         * KONFIGURASI MIDTRANS
         * ========================================================
         */

        Config::$serverKey =
            config('midtrans.server_key');

        Config::$isProduction =
            config(
                'midtrans.is_production',
                false
            );

        Config::$isSanitized =
            config(
                'midtrans.is_sanitized',
                true
            );

        Config::$is3ds =
            config(
                'midtrans.is_3ds',
                true
            );


        /**
         * ========================================================
         * CEK SNAP TOKEN
         * ========================================================
         */

        if (
            $order->payment &&
            $order->payment->snap_token
        ) {

            $snapToken =
                $order->payment->snap_token;

        } else {

            /**
             * ====================================================
             * ORDER CODE MIDTRANS
             * ====================================================
             *
             * Harus unik.
             */

            $orderCode =
                'ORDER-' .
                $order->id .
                '-' .
                time();


            $params = [

                'transaction_details' => [

                    'order_id' =>
                        $orderCode,

                    'gross_amount' =>
                        (int) $order->total_price,
                ],


                'customer_details' => [

                    'first_name' =>
                        Auth::user()->name,

                    'email' =>
                        Auth::user()->email,
                ],
            ];


            try {

                $snapToken =
                    Snap::getSnapToken(
                        $params
                    );


                /**
                 * Simpan token + order code
                 */

                $order->payment()->update([

                    'order_code' =>
                        $orderCode,

                    'snap_token' =>
                        $snapToken,

                    'gross_amount' =>
                        $order->total_price,
                ]);


            } catch (\Exception $e) {

                Log::error(
                    'Gagal generate Snap Token',
                    [
                        'order_id' =>
                            $order->id,

                        'error' =>
                            $e->getMessage(),
                    ]
                );


                return back()
                    ->with(
                        'error',
                        'Gagal membuat pembayaran: ' .
                        $e->getMessage()
                    );
            }
        }


      return view(
    'pelanggan.payment',
    compact(
        'order',
        'snapToken',
        'balance'
    )
);
    }


    /**
     * ============================================================
     * PROCESS PAYMENT METHOD
     * ============================================================
     */
    public function processPayment(
        Request $request,
        $id
    ) {

        $request->validate([
            'payment_method' =>
                'required'
        ]);


        $order = Order::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);


        $order->update([

            'payment_method' =>
                $request->payment_method,
        ]);


        return redirect()
            ->route(
                'pelanggan.orders'
            )
            ->with(
                'success',
                'Metode pembayaran berhasil dipilih.'
            );
    }

    /**
 * ============================================================
 * BAYAR MENGGUNAKAN SALDO BERES.IN
 * ============================================================
 */
public function payWithBalance($id)
{
    try {

        DB::beginTransaction();

        /*
        |--------------------------------------------------------------------------
        | AMBIL ORDER
        |--------------------------------------------------------------------------
        */

        $order = Order::where(
            'user_id',
            Auth::id()
        )
        ->lockForUpdate()
        ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CEK ORDER SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        */

        if ($order->payment_status === 'lunas') {

            DB::rollBack();

            return redirect()
                ->route('pelanggan.orders')
                ->with(
                    'info',
                    'Pesanan ini sudah dibayar.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL SALDO CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerBalance = CustomerBalance::where(
            'user_id',
            Auth::id()
        )
        ->lockForUpdate()
        ->first();

        if (!$customerBalance) {

            DB::rollBack();

            return back()->with(
                'error',
                'Saldo Beres.in tidak tersedia.'
            );
        }

        $balanceBefore = (float) $customerBalance->balance;

        $paymentAmount = (float) $order->total_price;

        /*
        |--------------------------------------------------------------------------
        | CEK SALDO
        |--------------------------------------------------------------------------
        */

        if ($balanceBefore < $paymentAmount) {

            DB::rollBack();

            return back()->with(
                'error',
                'Saldo tidak mencukupi untuk membayar pesanan ini.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO SETELAH PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $balanceAfter =
            $balanceBefore - $paymentAmount;

        /*
        |--------------------------------------------------------------------------
        | POTONG SALDO
        |--------------------------------------------------------------------------
        */

        $customerBalance->update([
            'balance' => $balanceAfter
        ]);

        /*
        |--------------------------------------------------------------------------
        | CATAT TRANSAKSI SALDO
        |--------------------------------------------------------------------------
        */

        CustomerBalanceTransaction::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'type' => 'payment',
            'amount' => $paymentAmount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'description' =>
                'Pembayaran order ' .
                $order->invoice_number .
                ' menggunakan saldo Beres.in',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment = Payment::firstOrCreate(
            [
                'order_id' => $order->id
            ],
            [
                'order_code' =>
                    'BALANCE-' . $order->id,
                'gross_amount' =>
                    $paymentAmount,
            ]
        );

        $payment->update([
            'transaction_id' =>
                'BALANCE-' .
                $order->invoice_number .
                '-' .
                time(),

            'payment_type' => 'balance',

            'transaction_status' => 'settlement',

            'gross_amount' => $paymentAmount,

            'settlement_time' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER
        |--------------------------------------------------------------------------
        */

        $order->update([
            'payment_status' => 'lunas',
            'payment_method' => 'Saldo Beres.in',

            /*
             * Order tetap pending karena
             * setelah pembayaran harus diproses mitra.
             */
            'status' => 'pending',
        ]);

        DB::commit();

        return redirect()
            ->route(
                'pelanggan.orders'
            )
            ->with(
                'success',
                'Pembayaran berhasil menggunakan saldo Beres.in sebesar Rp ' .
                number_format(
                    $paymentAmount,
                    0,
                    ',',
                    '.'
                ) .
                '. Sisa saldo Rp ' .
                number_format(
                    $balanceAfter,
                    0,
                    ',',
                    '.'
                ) .
                '.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        Log::error(
            'Pembayaran menggunakan saldo gagal',
            [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]
        );

        return back()->with(
            'error',
            'Pembayaran menggunakan saldo gagal: ' .
            $e->getMessage()
        );
    }
}


    /**
     * ============================================================
     * AVAILABLE SLOTS
     * ============================================================
     */
    public function availableSlots(
        Request $request
    ) {

        $request->validate([
            'tanggal' =>
                'required|date'
        ]);


        $carts = Cart::with('service')
            ->where(
                'user_id',
                Auth::id()
            )
            ->get();


        if ($carts->isEmpty()) {

            return response()->json([]);
        }


        $mitraId =
            $carts->first()
                ->service
                ->mitra_id;


        $mitra =
            User::findOrFail($mitraId);


        /**
         * ========================================================
         * MITRA OFFLINE
         * ========================================================
         */

        if (!$mitra->is_online) {

            return response()->json([

                'status' =>
                    'offline',

                'slots' =>
                    [],
            ]);
        }


        /**
         * ========================================================
         * CEK HARI LIBUR
         * ========================================================
         */

        $hariIndonesia = [

            'Sunday' =>
                'Minggu',

            'Monday' =>
                'Senin',

            'Tuesday' =>
                'Selasa',

            'Wednesday' =>
                'Rabu',

            'Thursday' =>
                'Kamis',

            'Friday' =>
                'Jumat',

            'Saturday' =>
                'Sabtu',
        ];


        $hariBooking =
            $hariIndonesia[
                date(
                    'l',
                    strtotime(
                        $request->tanggal
                    )
                )
            ];


        $holiday =
            array_map(
                'trim',
                explode(
                    ',',
                    $mitra->holiday ?? ''
                )
            );


        if (
            in_array(
                $hariBooking,
                $holiday
            )
        ) {

            return response()->json([

                'status' =>
                    'holiday',

                'slots' =>
                    [],
            ]);
        }


        /**
         * ========================================================
         * GENERATE SLOT
         * ========================================================
         */

        $slots = [];


        if (
            $mitra->open_time &&
            $mitra->close_time
        ) {

            $mulai =
                strtotime(
                    $mitra->open_time
                );

            $selesai =
                strtotime(
                    $mitra->close_time
                );


            while (
                $mulai < $selesai
            ) {

                $jam =
                    date(
                        'H:i',
                        $mulai
                    );


                $dipakai =
                    Order::where(
                        'mitra_id',
                        $mitraId
                    )
                    ->where(
                        'jadwal',
                        $request->tanggal
                    )
                    ->where(
                        'jam',
                        $jam
                    )
                    ->whereNotIn(
                        'status',
                        ['dibatalkan']
                    )
                    ->exists();


                if (!$dipakai) {

                    $slots[] =
                        $jam;
                }


                $mulai =
                    strtotime(
                        '+1 hour',
                        $mulai
                    );
            }
        }


        return response()->json([

            'status' =>
                'success',

            'slots' =>
                $slots,
        ]);
    }


    /**
     * ============================================================
     * MIDTRANS CALLBACK / WEBHOOK
     * ============================================================
     */
    public function callback(
        Request $request
    ) {

        /**
         * ========================================================
         * KONFIGURASI MIDTRANS
         * ========================================================
         */

        Config::$serverKey =
            config('midtrans.server_key');

        Config::$isProduction =
            config(
                'midtrans.is_production',
                false
            );


        /**
         * ========================================================
         * BACA NOTIFICATION MIDTRANS
         * ========================================================
         */

        try {

            $notif =
                new MidtransNotification();

        } catch (\Exception $e) {

            Log::error(
                'Error membaca notification Midtrans',
                [
                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([

                'message' =>
                    'Error reading notification',

                'error' =>
                    $e->getMessage(),

            ], 400);
        }


        /**
         * ========================================================
         * CARI PAYMENT
         * ========================================================
         */

        $orderCode =
            $notif->order_id;


        $payment =
            Payment::where(
                'order_code',
                $orderCode
            )->first();


        if (!$payment) {

            Log::error(
                'Payment tidak ditemukan',
                [
                    'midtrans_order_id' =>
                        $orderCode,
                ]
            );


            return response()->json([

                'message' =>
                    'Payment not found',

            ], 404);
        }


        $order =
            $payment->order;


        if (!$order) {

            Log::error(
                'Order tidak ditemukan',
                [
                    'payment_id' =>
                        $payment->id,
                ]
            );


            return response()->json([

                'message' =>
                    'Order not found',

            ], 404);
        }


        /**
         * ========================================================
         * AMBIL DETAIL PEMBAYARAN
         * ========================================================
         */

        $bank = null;

        $vaNumber = null;

        $paymentCode = null;


        /**
         * ========================================================
         * 1. BANK TRANSFER / VA
         * ========================================================
         */

        if (
            isset($notif->va_numbers) &&
            is_array($notif->va_numbers) &&
            count($notif->va_numbers) > 0
        ) {

            $bank =
                $notif->va_numbers[0]->bank
                ?? null;


            $vaNumber =
                $notif->va_numbers[0]->va_number
                ?? null;
        }


        /**
         * ========================================================
         * 2. PERMATA VA
         * ========================================================
         */

        elseif (
            isset(
                $notif->permata_va_number
            )
        ) {

            $bank =
                'permata';

            $vaNumber =
                $notif->permata_va_number;
        }


        /**
         * ========================================================
         * 3. MANDIRI BILL PAYMENT
         * ========================================================
         */

        elseif (
            isset($notif->bill_key) &&
            isset($notif->biller_code)
        ) {

            $bank =
                'mandiri';

            $vaNumber =
                $notif->biller_code .
                $notif->bill_key;
        }


        /**
         * ========================================================
         * 4. RETAIL / CONVENIENCE STORE
         * ========================================================
         */

        if (
            isset($notif->payment_code)
        ) {

            $paymentCode =
                $notif->payment_code;
        }


        /**
         * ========================================================
         * UPDATE PAYMENT
         * ========================================================
         */

        $payment->update([

            'transaction_id' =>
                $notif->transaction_id
                ?? null,

            'payment_type' =>
                $notif->payment_type
                ?? null,

            'bank' =>
                $bank,

            'va_number' =>
                $vaNumber,

            'payment_code' =>
                $paymentCode,

            'transaction_status' =>
                $notif->transaction_status
                ?? null,

            'fraud_status' =>
                $notif->fraud_status
                ?? null,

            'transaction_time' =>
                $notif->transaction_time
                ?? null,

            'settlement_time' =>
                $notif->settlement_time
                ?? null,

            'expiry_time' =>
                $notif->expiry_time
                ?? null,
        ]);


        /**
         * ========================================================
         * PAYMENT METHOD
         * ========================================================
         */

        $paymentMethod =
            $notif->payment_type
            ?? 'Midtrans';


        if ($bank) {

            $paymentMethod =
                $bank . ' (VA)';
        }


        $paymentMethod =
            strtoupper(
                $paymentMethod
            );


        /**
         * ========================================================
         * TRANSACTION STATUS
         * ========================================================
         */

        $transactionStatus =
            $notif->transaction_status
            ?? null;


        /**
         * ========================================================
         * SETTLEMENT / CAPTURE
         * ========================================================
         */

        if (
            $transactionStatus === 'settlement'
        ) {

            $order->update([

                // PEMBAYARAN BERHASIL
                'payment_status' =>
                    'lunas',

                // ORDER SIAP DIPROSES MITRA
                'status' =>
                    'pending',

                'payment_method' =>
                    $paymentMethod,
            ]);
        }


        elseif (
            $transactionStatus === 'capture'
        ) {

            /**
             * Untuk kartu kredit,
             * pastikan fraud status diterima.
             */

            $fraudStatus =
                $notif->fraud_status
                ?? null;


            if (
                $fraudStatus === 'accept' ||
                !$fraudStatus
            ) {

                $order->update([

                    'payment_status' =>
                        'lunas',

                    'status' =>
                        'pending',

                    'payment_method' =>
                        $paymentMethod,
                ]);
            }
        }


        /**
         * ========================================================
         * PAYMENT PENDING
         * ========================================================
         */

        elseif (
            $transactionStatus === 'pending'
        ) {

            /**
             * Jangan mengubah order yang
             * sudah lunas menjadi belum bayar.
             */

            if (
                $order->payment_status !== 'lunas'
            ) {

                $order->update([

                    'status' =>
                        'pending',

                    'payment_status' =>
                        'belum_bayar',

                    'payment_method' =>
                        $paymentMethod,
                ]);
            }
        }


        /**
         * ========================================================
         * PAYMENT GAGAL
         * ========================================================
         */

        elseif (
            in_array(
                $transactionStatus,
                [
                    'deny',
                    'expire',
                    'cancel'
                ]
            )
        ) {

            /**
             * Jangan membatalkan order yang
             * sudah lunas.
             */

            if (
                $order->payment_status !== 'lunas'
            ) {

                $order->update([

                    'status' =>
                        'dibatalkan',

                    'payment_status' =>
                        'gagal',

                    'payment_method' =>
                        $paymentMethod,
                ]);
            }
        }


        /**
         * ========================================================
         * LOG CALLBACK
         * ========================================================
         */

        Log::info(
            'Midtrans callback berhasil diproses',
            [

                'order_id' =>
                    $order->id,

                'order_code' =>
                    $orderCode,

                'transaction_status' =>
                    $transactionStatus,

                'payment_status' =>
                    $order->payment_status,

                'order_status' =>
                    $order->status,
            ]
        );


        return response()->json([

            'status' =>
                'success',
        ]);
    }


    /**
     * ============================================================
     * CHECK STATUS PAYMENT
     * ============================================================
     */
    public function checkStatus($id)
    {
        $order =
            Order::with('payment')
            ->where(
                'user_id',
                Auth::id()
            )
            ->findOrFail($id);


        return response()->json([

            'payment_status' =>
                $order->payment_status,

            'order_status' =>
                $order->status,

            'transaction_status' =>
                $order->payment
                    ->transaction_status
                    ?? null,

        ]);
    }


    /**
     * ============================================================
     * SIMPAN INFORMASI PAYMENT DARI FRONTEND
     * ============================================================
     */
    public function savePaymentInfo(
        Request $request
    ) {

        try {

            $order =
                Order::with('payment')
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->findOrFail(
                    $request->order_id
                );


            $payment =
                $order->payment;


            if (!$payment) {

                Log::error(
                    'Payment tidak ditemukan',
                    [
                        'order_id' =>
                            $order->id,
                    ]
                );


                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Data payment untuk order tidak ditemukan.',

                ], 404);
            }


            /**
             * ====================================================
             * DEFAULT
             * ====================================================
             */

            $bank = null;

            $va = null;


            /**
             * ====================================================
             * VA NUMBERS
             * ====================================================
             */

            if (
                !empty(
                    $request->va_numbers
                ) &&
                is_array(
                    $request->va_numbers
                )
            ) {

                $bank =
                    $request
                        ->va_numbers[0]['bank']
                        ?? null;


                $va =
                    $request
                        ->va_numbers[0]['va_number']
                        ?? null;
            }


            /**
             * ====================================================
             * PERMATA
             * ====================================================
             */

            if (
                !empty(
                    $request->permata_va_number
                )
            ) {

                $bank =
                    'permata';

                $va =
                    $request
                        ->permata_va_number;
            }


            /**
             * ====================================================
             * MANDIRI
             * ====================================================
             */

            if (
                !empty(
                    $request->bill_key
                )
            ) {

                $bank =
                    'mandiri';

                $va =
                    (
                        $request
                            ->biller_code
                        ?? ''
                    )
                    .
                    $request->bill_key;
            }


            /**
             * ====================================================
             * UPDATE PAYMENT
             * ====================================================
             */

            $payment->update([

                'transaction_id' =>
                    $request->transaction_id,

                'payment_type' =>
                    $request->payment_type,

                'bank' =>
                    $bank,

                'va_number' =>
                    $va,

                'expiry_time' =>
                    $request->expiry_time,
            ]);


            Log::info(
                'Payment info berhasil disimpan',
                [

                    'order_id' =>
                        $order->id,

                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $request->transaction_id,
                ]
            );


            return response()->json([

                'success' =>
                    true,
            ]);


        } catch (\Exception $e) {

            Log::error(
                'GAGAL SAVE PAYMENT INFO',
                [

                    'order_id' =>
                        $request->order_id
                        ?? null,

                    'error' =>
                        $e->getMessage(),

                    'line' =>
                        $e->getLine(),

                    'file' =>
                        $e->getFile(),
                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Gagal menyimpan data pembayaran.',

                'error' =>
                    $e->getMessage(),

            ], 500);
        }
    }
}

