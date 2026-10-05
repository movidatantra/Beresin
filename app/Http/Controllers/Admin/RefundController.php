<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class RefundController extends Controller
{
    /**
     * Daftar Refund
     */
    public function index()
    {
        $refunds = Refund::with([
            'complaint.user',
            'order',
            'payment',
            'admin'
        ])
        ->latest()
        ->get();

        return view(
            'admin.refunds.index',
            compact('refunds')
        );
    }

    /**
     * Detail Refund
     */
    public function show($id)
    {
        $refund = Refund::with([
            'complaint.user',
            'order',
            'payment',
            'admin'
        ])->findOrFail($id);

        return view(
            'admin.refunds.show',
            compact('refund')
        );
    }

    /**
     * Proses Refund ke Saldo Pelanggan
     */
   public function process($id)
{
    DB::beginTransaction();

    try {
        // Ambil refund dan kunci row agar tidak diproses dua kali
        $refund = Refund::with([
            'complaint.user',
            'order.user',
            'payment'
        ])
        ->lockForUpdate()
        ->findOrFail($id);

        // Refund hanya boleh diproses jika masih pending
        if ($refund->status !== 'pending') {
            DB::rollBack();

            return back()->with('error', 'Refund sudah pernah diproses.');
        }

        $order = $refund->order;

        if (!$order) {
            DB::rollBack();

            return back()->with('error', 'Data pesanan tidak ditemukan.');
        }

        // Ambil customer
        $customer = $refund->complaint->user
            ?? $order->user;

        if (!$customer) {
            DB::rollBack();

            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | JUMLAH REFUND
        |--------------------------------------------------------------------------
        | Refund hanya biaya jasa/subtotal.
        | Biaya admin tidak dikembalikan.
        */
        $refundAmount = (float) $order->subtotal;

        if ($refundAmount <= 0) {
            DB::rollBack();

            return back()->with('error', 'Jumlah refund tidak valid.');
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
            DB::rollBack();

            return back()->with(
                'error',
                'Refund untuk pesanan ini sudah masuk ke saldo pelanggan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER BALANCE
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

        // Tambahkan refund ke saldo pelanggan
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
            'description' => 'Refund biaya jasa order ' . $order->invoice_number,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE REFUND
        |--------------------------------------------------------------------------
        */
        $refund->update([
            'amount' => $refundAmount,
            'refund_method' => 'balance',
            'status' => 'success',
            'processed_by' => auth()->id(),
            'refund_key' => 'BALANCE-' . $order->invoice_number . '-' . time(),
            'response' => json_encode([
                'method' => 'balance',
                'amount' => $refundAmount,
                'customer_id' => $customer->id,
                'message' => 'Refund berhasil dikreditkan ke saldo pelanggan.'
            ]),
            'refunded_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE COMPLAINT
        |--------------------------------------------------------------------------
        */
        if ($refund->complaint) {
            $refund->complaint->update([
                'status' => 'resolved',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER
        |--------------------------------------------------------------------------
        */
        $order->update([
            'status' => 'dibatalkan',
            'customer_confirmation' => 'complain',

            // Pembayaran awal tetap tercatat sebagai lunas,
            // karena uangnya sekarang dipindahkan menjadi saldo internal.
            'payment_status' => 'lunas',
        ]);

        DB::commit();

        return back()->with(
            'success',
            'Refund sebesar Rp ' .
            number_format($refundAmount, 0, ',', '.') .
            ' berhasil ditambahkan ke saldo pelanggan.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            'Gagal memproses refund: ' . $e->getMessage()
        );
    }
}
}