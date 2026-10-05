<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\MitraBalance;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;

class ComplaintController extends Controller
{
    /**
     * Daftar semua komplain
     */
    public function index()
    {
        $complaints = Complaint::with([
            'order',
            'user',
            'mitra'
        ])
        ->latest()
        ->get();

        return view(
            'admin.complaints.index',
            compact('complaints')
        );
    }

    /**
     * Detail komplain
     */
    public function show($id)
    {
        $complaint = Complaint::with([
            'order',
            'user',
            'mitra',
            'bank',
            'ewallet'
        ])->findOrFail($id);

        return view(
            'admin.complaints.show',
            compact('complaint')
        );
    }

    /**
     * Menyelesaikan komplain
     */
    public function resolve(Request $request, $id)
    {
        $complaint = Complaint::with([
            'order',
            'mitra'
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CEK KEPUTUSAN SUDAH FINAL
        |--------------------------------------------------------------------------
        */

        if (in_array(
            $complaint->status,
            ['approved', 'rejected', 'resolved']
        )) {
            return back()->with(
                'error',
                'Keputusan admin sudah disimpan dan tidak dapat diubah lagi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN BALASAN ADMIN SAJA
        |--------------------------------------------------------------------------
        */

        if ($request->action === 'save') {

            $request->validate([
                'admin_response' => 'required|string',
            ]);

            $complaint->admin_response =
                $request->admin_response;

            $complaint->save();

            return back()->with(
                'success',
                'Balasan admin berhasil disimpan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KEPUTUSAN
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'admin_response' => 'required|string',
            'decision' => 'required|in:mitra,customer',
        ]);

        try {

            DB::transaction(function () use (
                $request,
                $complaint
            ) {

                /*
                |--------------------------------------------------------------------------
                | AMBIL ORDER
                |--------------------------------------------------------------------------
                */

                $order = $complaint->order;

                if (!$order) {
                    throw new \Exception(
                        'Order tidak ditemukan.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | SIMPAN BALASAN ADMIN
                |--------------------------------------------------------------------------
                */

                $complaint->admin_response =
                    $request->admin_response;

                $complaint->resolved_at = now();

                /*
                |--------------------------------------------------------------------------
                | KEPUTUSAN: MITRA
                |--------------------------------------------------------------------------
                */

                if ($request->decision === 'mitra') {

                    $complaint->status = 'rejected';

                    $order->status = 'selesai';

                    $order->customer_confirmation =
                        'confirmed';

                    $order->payment_status =
                        'lunas';

                    /*
                    |--------------------------------------------------------------------------
                    | BAGIAN MITRA
                    |--------------------------------------------------------------------------
                    */

                    $adminFee = 10000;

                    $saldoMitra =
                        (float) $order->total_price
                        - $adminFee;

                    if (
                        !MitraBalance::where(
                            'order_id',
                            $order->id
                        )->exists()
                    ) {

                        MitraBalance::create([
                            'mitra_id' => $order->mitra_id,
                            'order_id' => $order->id,
                            'amount' => $saldoMitra,
                            'type' => 'income',
                            'status' => 'available',
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | KEPUTUSAN: PELANGGAN
                |--------------------------------------------------------------------------
                */

               else {

    /*
    |--------------------------------------------------------------------------
    | CEK PAYMENT
    |--------------------------------------------------------------------------
    */

    $payment = Payment::where(
        'order_id',
        $order->id
    )->first();

    if (!$payment) {
        throw new \Exception(
            'Data pembayaran order tidak ditemukan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NOMINAL REFUND
    |--------------------------------------------------------------------------
    | Refund hanya biaya jasa / subtotal.
    | Biaya admin tidak dikembalikan.
    |
    | Contoh:
    | subtotal    = 75.000
    | service_fee = 10.000
    | total       = 85.000
    |
    | Refund = 75.000
    |--------------------------------------------------------------------------
    */

    $refundAmount = (float) $order->subtotal;

    if ($refundAmount <= 0) {
        throw new \Exception(
            'Nominal refund tidak valid.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATA CUSTOMER
    |--------------------------------------------------------------------------
    */

    $customer = $complaint->user ?? $order->user;

    if (!$customer) {
        throw new \Exception(
            'Data pelanggan tidak ditemukan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEGAH REFUND GANDA
    |--------------------------------------------------------------------------
    */

    $alreadyRefunded = CustomerBalanceTransaction::where(
        'order_id',
        $order->id
    )
    ->where('user_id', $customer->id)
    ->where('type', 'refund')
    ->exists();

    if ($alreadyRefunded) {
        throw new \Exception(
            'Refund untuk pesanan ini sudah masuk ke saldo pelanggan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS KOMPLAIN
    |--------------------------------------------------------------------------
    */

    $complaint->status = 'approved';

    /*
    |--------------------------------------------------------------------------
    | STATUS ORDER
    |--------------------------------------------------------------------------
    */

    $order->status = 'dibatalkan';

    $order->customer_confirmation = 'complain';

    /*
    | Pembayaran awal tetap tercatat lunas.
    | Dana refund dipindahkan menjadi saldo internal pelanggan.
    */

    $order->payment_status = 'lunas';

    /*
    |--------------------------------------------------------------------------
    | TAMBAHKAN REFUND KE SALDO PELANGGAN
    |--------------------------------------------------------------------------
    */

    $customerBalance = CustomerBalance::firstOrCreate(
        [
            'user_id' => $customer->id
        ],
        [
            'balance' => 0
        ]
    );

    $balanceBefore = (float) $customerBalance->balance;

    $balanceAfter = $balanceBefore + $refundAmount;

    $customerBalance->update([
        'balance' => $balanceAfter
    ]);

    /*
    |--------------------------------------------------------------------------
    | CATAT TRANSAKSI SALDO
    |--------------------------------------------------------------------------
    */

    CustomerBalanceTransaction::create([
        'user_id' => $customer->id,
        'order_id' => $order->id,
        'type' => 'refund',
        'amount' => $refundAmount,
        'balance_before' => $balanceBefore,
        'balance_after' => $balanceAfter,
        'description' =>
            'Refund biaya jasa order ' . $order->invoice_number,
    ]);

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA REFUND
    |--------------------------------------------------------------------------
    | Karena saldo langsung diberikan,
    | status refund langsung SUCCESS.
    |--------------------------------------------------------------------------
    */

    $refund = Refund::where(
        'complaint_id',
        $complaint->id
    )->first();

    if (!$refund) {

        Refund::create([
            'complaint_id' => $complaint->id,
            'order_id' => $order->id,
            'payment_id' => $payment->id,
            'refund_method' => 'balance',
            'amount' => $refundAmount,
            'reason' => 'Komplain pelanggan disetujui',
            'status' => 'success',
            'processed_by' => auth()->id(),
            'refund_key' =>
                'BALANCE-' .
                $order->invoice_number .
                '-' .
                time(),
            'response' => json_encode([
                'method' => 'balance',
                'amount' => $refundAmount,
                'customer_id' => $customer->id,
                'message' =>
                    'Refund langsung dikreditkan ke saldo pelanggan.'
            ]),
            'refunded_at' => now(),
        ]);

    } else {

        /*
        |--------------------------------------------------------------------------
        | JIKA DATA REFUND SUDAH ADA
        |--------------------------------------------------------------------------
        */

        $refund->update([
            'amount' => $refundAmount,
            'refund_method' => 'balance',
            'status' => 'success',
            'payment_id' => $payment->id,
            'reason' => 'Komplain pelanggan disetujui',
            'processed_by' => auth()->id(),
            'refund_key' =>
                'BALANCE-' .
                $order->invoice_number .
                '-' .
                time(),
            'response' => json_encode([
                'method' => 'balance',
                'amount' => $refundAmount,
                'customer_id' => $customer->id,
                'message' =>
                    'Refund langsung dikreditkan ke saldo pelanggan.'
            ]),
            'refunded_at' => now(),
        ]);
    }
}

                /*
                |--------------------------------------------------------------------------
                | SIMPAN COMPLAINT & ORDER
                |--------------------------------------------------------------------------
                */

                $complaint->save();

                $order->save();
            });

            return redirect()
                ->route('admin.complaints')
                ->with(
                    'success',
                    'Keputusan komplain berhasil disimpan.'
                );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}