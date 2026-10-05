<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function show($id)
    {
        $order = Order::with([
            'payment',
            'mitra'
        ])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS PEMBAYARAN KE MIDTRANS
        |--------------------------------------------------------------------------
        */
        if ($order->payment && $order->payment->order_code) {

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            try {

                $status = Transaction::status(
                    $order->payment->order_code
                );

                /*
                |--------------------------------------------------------------------------
                | AMBIL VA
                |--------------------------------------------------------------------------
                */
                $bank = null;
                $va = null;

                if (!empty($status->va_numbers)) {

                    $bank = $status->va_numbers[0]->bank ?? null;

                    $va = $status->va_numbers[0]->va_number ?? null;

                } elseif (isset($status->permata_va_number)) {

                    $bank = 'permata';

                    $va = $status->permata_va_number;

                } elseif (
                    isset($status->bill_key) &&
                    isset($status->biller_code)
                ) {

                    $bank = 'mandiri';

                    $va =
                        $status->biller_code .
                        $status->bill_key;
                }

                /*
                |--------------------------------------------------------------------------
                | UPDATE DATA PAYMENT
                |--------------------------------------------------------------------------
                */
                $order->payment->update([

                    'transaction_id' =>
                        $status->transaction_id ?? null,

                    'payment_type' =>
                        $status->payment_type ?? null,

                    'bank' =>
                        $bank,

                    'va_number' =>
                        $va,

                    'transaction_status' =>
                        $status->transaction_status ?? null,

                    'transaction_time' =>
                        $status->transaction_time ?? null,

                    'expiry_time' =>
                        $status->expiry_time ?? null,

                ]);

                /*
                |--------------------------------------------------------------------------
                | UPDATE STATUS ORDER
                |--------------------------------------------------------------------------
                */

                $transactionStatus =
                    $status->transaction_status ?? null;


                // ==========================================
                // PEMBAYARAN BERHASIL
                // ==========================================

                if (
                    $transactionStatus === 'settlement' ||
                    $transactionStatus === 'capture'
                ) {

                    $order->update([
                        'payment_status' => 'lunas',
                    ]);
                }


                // ==========================================
                // MASIH MENUNGGU PEMBAYARAN
                // ==========================================

                elseif (
                    $transactionStatus === 'pending'
                ) {

                    $order->update([
                        'payment_status' => 'menunggu_verifikasi',
                    ]);
                }


                // ==========================================
                // PEMBAYARAN EXPIRED
                // ==========================================

                elseif (
                    $transactionStatus === 'expire'
                ) {

                    $order->update([
                        'payment_status' => 'belum_bayar',
                    ]);
                }


                // ==========================================
                // PEMBAYARAN GAGAL / DIBATALKAN
                // ==========================================

                elseif (
                    $transactionStatus === 'cancel' ||
                    $transactionStatus === 'deny'
                ) {

                    $order->update([
                        'payment_status' => 'belum_bayar',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | LOAD ULANG PAYMENT
                |--------------------------------------------------------------------------
                */

                $order->load('payment');

            } catch (\Exception $e) {

                report($e);
            }
        }

        return view(
            'pelanggan.payments.show',
            compact('order')
        );
    }
}