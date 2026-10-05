<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification as MidtransNotification;
use Midtrans\Snap;
use App\Models\Notification;


class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->count() == 0) {
            return redirect('/cart')->with('error', 'Keranjang masih kosong');
        }

        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->service->price * $cart->qty;
        }

        $mitraId = $carts->first()->service->mitra_id;
        $mitra = User::findOrFail($mitraId);

        $slots = [];
        if ($mitra->open_time && $mitra->close_time) {
            $mulai = strtotime($mitra->open_time);
            $selesai = strtotime($mitra->close_time);

            while ($mulai < $selesai) {
                $slots[] = date('H:i', $mulai);
                $mulai = strtotime('+1 hour', $mulai);
            }
        }

        return view('pelanggan.checkout', compact('carts', 'total', 'slots', 'mitra'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal'  => 'required|date|after_or_equal:today',
            'jam'     => 'required',
            'address' => 'required',
        ]);

        $carts = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $mitraId = $carts->first()->service->mitra_id;
        $mitra   = User::findOrFail($mitraId);

        if (!$mitra->is_online) {
            return back()->with('error', 'Mitra sedang offline.');
        }

        // Hitung subtotal jasa
$subtotal = 0;

foreach ($carts as $cart) {

    $subtotal += $cart->service->price * $cart->qty;

}

// Biaya layanan Beres.in
$serviceFee = 10000;

// Total dibayar pelanggan
$total = $subtotal + $serviceFee;

        // Cek slot bentrok
        $slotDipakai = Order::where('mitra_id', $mitraId)
            ->where('jadwal', $request->jadwal)
            ->where('jam', $request->jam)
            ->exists();

        if ($slotDipakai) {

            $mulai   = strtotime($request->jam);
            $selesai = strtotime($mitra->close_time);

            while (strtotime('+1 hour', $mulai) < $selesai) {

                $mulai = strtotime('+1 hour', $mulai);
                $jamBaru = date('H:i', $mulai);

                $dipakai = Order::where('mitra_id', $mitraId)
                    ->where('jadwal', $request->jadwal)
                    ->where('jam', $jamBaru)
                    ->exists();

                if (!$dipakai) {
                    return back()->with(
                        'warning',
                        'Jam tersebut baru saja terisi. Slot berikutnya tersedia pukul ' . $jamBaru
                    );
                }
            }

            return back()->with(
                'error',
                'Semua slot pada tanggal tersebut sudah penuh.'
            );
        }

        // Simpan Order
        $order = Order::create([
    'user_id'        => Auth::id(),
    'mitra_id'       => $mitraId,
    'service_id'     => $carts->first()->service_id,
    'subtotal'       => $subtotal,
    'service_fee'    => $serviceFee,
    'total_price'    => $total,
    'jadwal'         => $request->jadwal,
    'jam'            => $request->jam,
    'address'        => $request->address,
    'latitude'       => $request->latitude,
    'longitude'      => $request->longitude,
    'note'           => $request->note,
    'status' => 'menunggu_pembayaran',
    'payment_status' => 'belum_bayar',
    'payment_method' => 'Midtrans / Online',
]);

// ================================
// Generate Nomor Invoice
// ================================

$order->update([
    'invoice_number' => 'BRS' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
]);

        // Simpan Payment awal
        Payment::create([
            'order_id'           => $order->id,
            'order_code'         => 'ORDER-' . $order->id,
            'gross_amount'       => $order->total_price,
            'transaction_status' => 'pending',
        ]);
//         Notification::create([

//     'user_id'=>$mitraId,

//     'title'=>'Pesanan Baru',

//     'message'=>Auth::user()->name.
//                ' melakukan pemesanan layanan.',

//     'type'=>'order',

//     'reference_id'=>$order->id

// ]);

        // Simpan item pesanan
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id'   => $order->id,
                'service_id' => $cart->service_id,
                'qty'        => $cart->qty,
                'price'      => $cart->service->price,
            ]);
        }

        // Hapus keranjang
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('checkout.payment', $order->id);
    }

    public function payment($id)
    {
        $order = Order::with(['mitra', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        // Jika sudah pernah membuat Snap Token, gunakan yang lama
        if ($order->payment && $order->payment->snap_token) {

            $snapToken = $order->payment->snap_token;

        } else {

            // Generate Order Code unik
            $orderCode = 'ORDER-' . $order->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderCode,
                    'gross_amount' => (int) $order->total_price,
                ],

                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email'      => Auth::user()->email,
                ],
            ];

            try {

                $snapToken = Snap::getSnapToken($params);

                $order->payment()->update([
                    'order_code' => $orderCode,
                    'snap_token' => $snapToken,
                ]);

            } catch (\Exception $e) {

                return back()->with('error', $e->getMessage());

            }
        }

        return view('pelanggan.payment', compact('order', 'snapToken'));
    }

    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update([
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('pelanggan.orders')->with('success', 'Metode pembayaran berhasil dipilih.');
    }

    public function availableSlots(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $carts = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return response()->json([]);
        }

        $mitraId = $carts->first()->service->mitra_id;
        $mitra = User::findOrFail($mitraId);

        if (!$mitra->is_online) {
            return response()->json([
                'status' => 'offline',
                'slots'  => []
            ]);
        }

        $hariIndonesia = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $hariBooking = $hariIndonesia[date('l', strtotime($request->tanggal))];
        $holiday = array_map('trim', explode(',', $mitra->holiday));

        if (in_array($hariBooking, $holiday)) {
            return response()->json([
                'status' => 'holiday',
                'slots'  => []
            ]);
        }

        $slots = [];
        if ($mitra->open_time && $mitra->close_time) {
            $mulai = strtotime($mitra->open_time);
            $selesai = strtotime($mitra->close_time);

            while ($mulai < $selesai) {
                $jam = date('H:i', $mulai);
                $dipakai = Order::where('mitra_id', $mitraId)
                    ->where('jadwal', $request->tanggal)
                    ->where('jam', $jam)
                    ->exists();

                if (!$dipakai) {
                    $slots[] = $jam;
                }

                $mulai = strtotime('+1 hour', $mulai);
            }
        }

        return response()->json([
            'status' => 'success',
            'slots'  => $slots
        ]);
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);

        try {
            $notif = new MidtransNotification();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error reading notification',
                'error'   => $e->getMessage()
            ], 400);
        }

        $orderCode = $notif->order_id;
        $payment = Payment::where('order_code', $orderCode)->first();

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        $order = $payment->order;

        // --- EXTRACT DETAIL PEMBAYARAN MIDTRANS ---
        $bank = null;
        $vaNumber = null;
        $paymentCode = null;

        // 1. Bank Transfer standar (BCA, BNI, BRI, Cimb, dll)
        if (isset($notif->va_numbers) && is_array($notif->va_numbers) && count($notif->va_numbers) > 0) {
            $bank = $notif->va_numbers[0]->bank ?? null;
            $vaNumber = $notif->va_numbers[0]->va_number ?? null;
        } 
        // 2. Permata Bank Virtual Account
        elseif (isset($notif->permata_va_number)) {
            $bank = 'permata';
            $vaNumber = $notif->permata_va_number;
        } 
        // 3. Mandiri Bill Payment / E-Channel
        elseif (isset($notif->bill_key) && isset($notif->biller_code)) {
            $bank = 'mandiri';
            $vaNumber = $notif->biller_code . $notif->bill_key;
        }
        
        // 4. Convenience Store / Retail (Indomaret, Alfamart)
        if (isset($notif->payment_code)) {
            $paymentCode = $notif->payment_code;
        }

        // Update seluruh detail transaksi ke tabel payments
        $payment->update([
            'transaction_id'     => $notif->transaction_id ?? null,
            'payment_type'       => $notif->payment_type ?? null,
            'bank'               => $bank,
            'va_number'          => $vaNumber,
            'payment_code'       => $paymentCode,
            'transaction_status' => $notif->transaction_status,
            'fraud_status'       => $notif->fraud_status ?? null,
            'transaction_time'   => $notif->transaction_time ?? null,
            'settlement_time'    => $notif->settlement_time ?? null,
            'expiry_time'        => $notif->expiry_time ?? null,
        ]);

        // Sinkronisasi status dan metode pembayaran ke tabel orders
        $paymentMethod = $notif->payment_type ?? 'Midtrans';
        if ($bank) {
            $paymentMethod = $bank . ' (VA)';
        }

        switch ($notif->transaction_status) {
            case 'capture':
            case 'settlement':
                $order->update([
                    'payment_status' => 'lunas',
                    'payment_method' => strtoupper($paymentMethod)
                ]);
                break;

            case 'pending':
                $order->update([
                    'payment_status' => 'belum_bayar',
                    'payment_method' => strtoupper($paymentMethod)
                ]);
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->update([
                    'status'         => 'dibatalkan',
                    'payment_status' => 'gagal',
                    'payment_method' => strtoupper($paymentMethod)
                ]);
                break;
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function checkStatus($id)
    {
        $order = Order::with('payment')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'payment_status' => $order->payment->transaction_status ?? 'pending'
        ]);
    }
}