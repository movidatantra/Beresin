<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminComplaintController extends Controller
{
    /**
     * Menampilkan semua komplain
     */
    public function index()
    {
        $complaints = Complaint::with([
                'user',
                'order'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.complains.index',
            compact('complaints')
        );
    }

    /**
     * Detail komplain
     */
    public function show(Complaint $complaint)
    {
        $complaint->load([
            'user',
            'mitra',
            'order',
            'bank',
            'ewallet'
        ]);

        return view(
            'admin.complaints.show',
            compact('complaint')
        );
    }

    /**
     * Update komplain biasa
     */
    public function update(
        Request $request,
        Complaint $complaint
    ) {
        $request->validate([
            'response' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $complaint->update([
            'response' => $request->response,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.complaints')
            ->with(
                'success',
                'Pengaduan berhasil ditanggapi.'
            );
    }

    /**
     * Menyelesaikan komplain
     *
     * decision:
     *
     * - customer = refund biaya jasa/subtotal ke saldo pelanggan
     * - mitra    = dana diteruskan ke mitra
     */
    public function resolve(
        Request $request,
        Complaint $complaint
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'admin_response' => 'required|string',
            'decision' => 'required|in:mitra,customer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEPUTUSAN: REFUND KE PELANGGAN
        |--------------------------------------------------------------------------
        */

        if ($request->decision === 'customer') {

            try {

                DB::transaction(function () use (
                    $request,
                    $complaint
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | 1. AMBIL ORDER
                    |--------------------------------------------------------------------------
                    */

                    $order = $complaint->order;

                    if (!$order) {
                        throw new \Exception(
                            'Order dari komplain tidak ditemukan.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | 2. CEK APAKAH REFUND SUDAH PERNAH DIBERIKAN
                    |--------------------------------------------------------------------------
                    */

                    $alreadyRefunded =
                        CustomerBalanceTransaction::where(
                            'order_id',
                            $order->id
                        )
                        ->where(
                            'type',
                            'refund'
                        )
                        ->exists();

                    if ($alreadyRefunded) {
                        throw new \Exception(
                            'Refund untuk order ' .
                            $order->invoice_number .
                            ' sudah pernah diberikan.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | 3. TENTUKAN NOMINAL REFUND
                    |--------------------------------------------------------------------------
                    |
                    | Refund = subtotal / biaya jasa.
                    |
                    | Contoh:
                    |
                    | subtotal      = Rp75.000
                    | service_fee   = Rp10.000
                    | total_price   = Rp85.000
                    |
                    | Refund pelanggan = Rp75.000
                    |
                    | Biaya admin/service_fee Rp10.000 TIDAK dikembalikan.
                    |
                    |--------------------------------------------------------------------------
                    */

                    $refundAmount = (float) $order->subtotal;

                    /*
                    |--------------------------------------------------------------------------
                    | 4. VALIDASI NOMINAL REFUND
                    |--------------------------------------------------------------------------
                    */

                    if ($refundAmount <= 0) {
                        throw new \Exception(
                            'Subtotal order untuk refund tidak tersedia atau bernilai 0.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | 5. USER PEMILIK ORDER
                    |--------------------------------------------------------------------------
                    |
                    | Gunakan user_id dari order agar saldo pasti masuk
                    | ke pelanggan yang memiliki order tersebut.
                    |
                    |--------------------------------------------------------------------------
                    */

                    $userId = $order->user_id;

                    if (!$userId) {
                        throw new \Exception(
                            'Pelanggan dari order tidak ditemukan.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | 6. AMBIL ATAU BUAT SALDO PELANGGAN
                    |--------------------------------------------------------------------------
                    */

                    $balance = CustomerBalance::firstOrCreate(
                        [
                            'user_id' => $userId,
                        ],
                        [
                            'balance' => 0,
                        ]
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | 7. HITUNG SALDO SEBELUM REFUND
                    |--------------------------------------------------------------------------
                    */

                    $balanceBefore = (float) $balance->balance;

                    /*
                    |--------------------------------------------------------------------------
                    | 8. HITUNG SALDO SETELAH REFUND
                    |--------------------------------------------------------------------------
                    */

                    $balanceAfter =
                        $balanceBefore + $refundAmount;

                    /*
                    |--------------------------------------------------------------------------
                    | 9. UPDATE SALDO PELANGGAN
                    |--------------------------------------------------------------------------
                    */

                    $balance->update([
                        'balance' => $balanceAfter,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | 10. SIMPAN RIWAYAT TRANSAKSI SALDO
                    |--------------------------------------------------------------------------
                    */

                    CustomerBalanceTransaction::create([
                        'user_id' => $userId,

                        'order_id' => $order->id,

                        'type' => 'refund',

                        'amount' => $refundAmount,

                        'balance_before' => $balanceBefore,

                        'balance_after' => $balanceAfter,

                        'description' =>
                            'Refund biaya jasa order ' .
                            $order->invoice_number,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | 11. UPDATE STATUS KOMPLAIN
                    |--------------------------------------------------------------------------
                    */

                    $complaint->update([
                        'admin_response' =>
                            $request->admin_response,

                        'status' => 'approved',

                        'resolved_at' => now(),
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | 12. UPDATE STATUS ORDER
                    |--------------------------------------------------------------------------
                    |
                    | Pembayaran sebelumnya sudah berhasil.
                    |
                    | Jadi:
                    |
                    | status          = dibatalkan
                    | payment_status  = lunas
                    |
                    | Uang refund dipindahkan secara internal
                    | ke saldo pelanggan.
                    |
                    |--------------------------------------------------------------------------
                    */

                    $order->update([
                        'status' => 'dibatalkan',

                        'payment_status' => 'lunas',
                    ]);
                });

                /*
                |--------------------------------------------------------------------------
                | REDIRECT BERHASIL
                |--------------------------------------------------------------------------
                */

                return redirect()
                    ->route(
                        'admin.complaints.show',
                        $complaint->id
                    )
                    ->with(
                        'success',
                        'Refund sebesar Rp' .
                        number_format(
                            (float) $complaint->order->subtotal,
                            0,
                            ',',
                            '.'
                        ) .
                        ' berhasil ditambahkan ke saldo pelanggan.'
                    );

            } catch (\Exception $e) {

                /*
                |--------------------------------------------------------------------------
                | JIKA GAGAL
                |--------------------------------------------------------------------------
                */

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Refund gagal diproses: ' .
                        $e->getMessage()
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | KEPUTUSAN: DANA DITERUSKAN KE MITRA
        |--------------------------------------------------------------------------
        */

        if ($request->decision === 'mitra') {

            $complaint->update([
                'admin_response' =>
                    $request->admin_response,

                'status' => 'resolved',

                'resolved_at' => now(),
            ]);

            return redirect()
                ->route(
                    'admin.complaints.show',
                    $complaint->id
                )
                ->with(
                    'success',
                    'Dana diteruskan ke mitra dan komplain telah diselesaikan.'
                );
        }
    }
}