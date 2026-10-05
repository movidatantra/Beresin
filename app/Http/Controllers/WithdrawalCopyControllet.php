<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import Namespace SDK v7
use Xendit\Configuration;
use Xendit\Disbursement\DisbursementApi;
use Xendit\Disbursement\CreateDisbursementRequest;

class WithdrawalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - LIST PENCAIRAN
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // 1. Ambil relasi user (menggunakan withTrashed agar jika user soft-deleted, data transaksi tetap muncul)
        $query = Withdrawal::with(['user']);

        // 2. Filter Status (jika ada filter yang dipilih)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Search Nama Mitra
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $withdrawals = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 4. Hitung Statistik untuk Cards (Mendukung 'pending' & 'menunggu')
        return view('admin.withdrawals.index', [
            'withdrawals' => $withdrawals,
            'pending'     => Withdrawal::whereIn('status', ['pending', 'menunggu'])->count(),
            'processing'  => Withdrawal::where('status', 'processing')->count(),
            'success'     => Withdrawal::where('status', 'success')->count(),
            'failed'      => Withdrawal::where('status', 'failed')->count(),
            'rejected'    => Withdrawal::where('status', 'rejected')->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PENCAIRAN
    |--------------------------------------------------------------------------
    */
    public function show($id)
{
    $withdrawal = Withdrawal::with([
        'user.bank',
        'user.ewallet'
    ])->findOrFail($id);

    return view(
        'admin.withdrawals.show',
        compact('withdrawal')
    );
}

    
/*
    |--------------------------------------------------------------------------
    | APPROVE PENCAIRAN
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        DB::beginTransaction();

        try {
            // 1. Ambil data withdrawal beserta relasi user
            $withdrawal = Withdrawal::with(['user.bank', 'user.ewallet'])->findOrFail($id);

            if (!in_array($withdrawal->status, ['pending', 'menunggu'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pencairan sudah diproses atau tidak berstatus pending.'
                ], 422);
            }

            $user = $withdrawal->user;

            // 2. Mapping bank_name dari database ke kode standar Xendit
            $rawBankName = strtoupper($withdrawal->bank_name ?? '');
            
            $mapXendit = [
                'GOPAY'     => 'GOPAY',
                'DANA'      => 'DANA',
                'OVO'       => 'OVO',
                'SHOPEEPAY' => 'SHOPEEPAY',
                'LINKAJA'   => 'LINKAJA',
                'BCA'       => 'BCA',
                'BRI'       => 'BRI',
                'MANDIRI'   => 'MANDIRI',
                'BNI'       => 'BNI',
            ];

            $bankCode = $mapXendit[$rawBankName] 
                        ?? optional($user->bank)->brick_code 
                        ?? optional($user->ewallet)->brick_code;

            // 3. Ambil nomor rekening dari kolom bank_account
            $accountNumber = $withdrawal->bank_account ?? $withdrawal->account_number;

            // 4. Validasi Kelengkapan Data
            if (empty($bankCode) || empty($accountNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak lengkap. Pastikan bank_name dan bank_account terisi di database.',
                    'debug' => [
                        'bank_name_db' => $withdrawal->bank_name,
                        'bank_account_db' => $withdrawal->bank_account,
                        'bankCode_resolved' => $bankCode,
                        'accountNumber_resolved' => $accountNumber
                    ]
                ], 400);
            }

            // 5. Hitung Nominal Bersih
            $adminFee = 2500;
            $netAmount = max(0, $withdrawal->amount - $adminFee);

            if ($netAmount < 10000) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nominal bersih kurang dari Rp 10.000.'
                ], 422);
            }

            // Update status lokal menjadi processing
            $withdrawal->status = 'processing';
            $withdrawal->save();

            // 6. Eksekusi Request ke Xendit menggunakan Endpoint Disbursements
            $externalId = 'WD-' . $withdrawal->id . '-' . time();

            $response = \Illuminate\Support\Facades\Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
                ->post('https://api.xendit.co/disbursements', [
                    'external_id'         => (string)$externalId,
                    'bank_code'           => (string)strtoupper($bankCode),
                    'account_holder_name' => (string)($withdrawal->account_holder ?? optional($user)->name ?? 'Mitra'),
                    'account_number'      => (string)$accountNumber,
                    'amount'              => (float)$netAmount,
                    'description'         => 'Pencairan Dana ' . (optional($user)->name ?? 'Mitra')
                ]);

            $responseData = $response->json();

            // 7. Cek Respon dari Xendit (Cukup 1 pengecekan bersih yang mengembalikan JSON)
            if ($response->successful() && isset($responseData['id'])) {
                $withdrawal->status = 'success';
                $withdrawal->xendit_id = $responseData['id'];
                $withdrawal->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pencairan berhasil diproses.'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Xendit Error: ' . ($responseData['message'] ?? 'Gagal memproses disbursement.'),
                    'full_response' => $responseData
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $withdrawal = Withdrawal::findOrFail($id);

            if (!in_array($withdrawal->status, ['pending', 'menunggu'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status pencairan sudah berubah.'
                ], 422);
            }

            $withdrawal->status = 'rejected';
            $withdrawal->note = $request->input('note', 'Ditolak oleh admin');
            $withdrawal->save();

            if ($withdrawal->user && isset($withdrawal->user->saldo)) {
                $withdrawal->user->saldo += $withdrawal->amount;
                $withdrawal->user->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil ditolak.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}