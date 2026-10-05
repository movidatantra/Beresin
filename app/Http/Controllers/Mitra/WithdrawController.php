<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data saldo user
        $saldo = $user->saldo ?? 0; // Sesuaikan jika lo pakai kolom/logika saldo lain
        
        $totalPendapatan = 0; // Sesuaikan query pendapatan mitra
        $sudahDicairkan = Withdrawal::where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('amount');
        $menunggu = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        // 2. Ambil riwayat pencairan mitra
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->get();

       return view('mitra.saldo', compact('saldo', 'totalPendapatan', 'sudahDicairkan', 'menunggu', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $saldoTersedia = $user->saldo ?? 0;

        // Validasi ketersediaan data rekening mitra
        if (!$user->withdraw_type || !$user->withdraw_number || !$user->withdraw_name) {
            return redirect()->back()->with('error', 'Data rekening pencairan Anda belum lengkap. Silakan lengkapi di profil.');
        }

        // Validasi input nominal
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:12500',
                'max:' . $saldoTersedia,
            ],
        ], [
            'amount.required' => 'Nominal pencairan wajib diisi.',
            'amount.min'      => 'Minimal pencairan dana adalah Rp 12.500.',
            'amount.max'      => 'Nominal pencairan melebihi saldo yang tersedia.',
        ]);

        // Ambil nama bank/e-wallet untuk snapshot destination
        $destination = '-';
        if ($user->withdraw_type == 'bank') {
            $destination = optional($user->bank)->nama_bank ?? 'Bank';
        } else {
            $destination = optional($user->ewallet)->nama_wallet ?? 'E-Wallet';
        }

        DB::beginTransaction();
        try {
            // 1. Buat record pencairan (Status Pending)
            Withdrawal::create([
                'user_id'        => $user->id,
                'amount'         => $request->amount,
                'withdraw_type'  => $user->withdraw_type,
                'destination'    => $destination,
                'account_number' => $user->withdraw_number,
                'account_name'   => $user->withdraw_name,
                'status'         => 'pending',
            ]);

            // 2. Potong saldo mitra di database
            if (isset($user->saldo)) {
                $user->saldo -= $request->amount;
                $user->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pengajuan pencairan dana berhasil dikirim! Menunggu konfirmasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal mengajukan pencairan: ' . $e->getMessage());
        }
    }
}