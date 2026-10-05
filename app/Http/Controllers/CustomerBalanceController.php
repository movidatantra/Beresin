<?php

namespace App\Http\Controllers;

use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;
use Illuminate\Support\Facades\Auth;

class CustomerBalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $balance = CustomerBalance::firstOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'balance' => 0
            ]
        );

        $transactions = CustomerBalanceTransaction::where(
            'user_id',
            $user->id
        )
        ->with('order')
        ->latest()
        ->paginate(10);

        return view(
            'pelanggan.balance.index',
            compact(
                'balance',
                'transactions'
            )
        );
    }
}