<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminPembayaranController extends Controller
{

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $query = Order::with([
    'user',
    'mitra'
]);

/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

if ($request->filled('search')) {

    $search = $request->search;

    $query->where(function ($q) use ($search) {

        $q->where(
            'invoice_number',
            'like',
            "%{$search}%"
        )

        ->orWhereHas('user', function ($user) use ($search) {

            $user->where(
                'name',
                'like',
                "%{$search}%"
            );

        })

        ->orWhereHas('mitra', function ($mitra) use ($search) {

            $mitra->where(
                'business_name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'name',
                'like',
                "%{$search}%"
            );

        });

    });

}
/*
|--------------------------------------------------------------------------
| FILTER METODE
|--------------------------------------------------------------------------
*/

if ($request->filled('method')) {

    $query->where(
        'payment_method',
        $request->method
    );

}
/*
|--------------------------------------------------------------------------
| FILTER STATUS
|--------------------------------------------------------------------------
*/

if ($request->filled('status')) {

    $query->where(
        'payment_status',
        $request->status
    );

}
/*
|--------------------------------------------------------------------------
| FILTER TANGGAL
|--------------------------------------------------------------------------
*/

if ($request->filled('from')) {

    $query->whereDate(
        'created_at',
        '>=',
        $request->from
    );

}

if ($request->filled('to')) {

    $query->whereDate(
        'created_at',
        '<=',
        $request->to
    );

}
/*
|--------------------------------------------------------------------------
| SORTING
|--------------------------------------------------------------------------
*/

switch ($request->sort) {

    case 'oldest':

        $query->oldest();

        break;

    case 'highest':

        $query->orderByDesc('total_price');

        break;

    case 'lowest':

        $query->orderBy('total_price');

        break;

    default:

        $query->latest();

        break;

}
$payments = $query
                ->paginate(10)
                ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalTransaction = Order::count();

        $monthlyIncome = Order::whereMonth(
                            'created_at',
                            now()->month
                        )
                        ->where(
                            'payment_status',
                            'lunas'
                        )
                        ->sum('total_price');

        $waitingConfirmation = Order::where(
                                    'payment_status',
                                    'menunggu_verifikasi'
                                )->count();

        $paidTransaction = Order::where(
                                'payment_status',
                                'lunas'
                            )->count();

        $codCount = Order::where(
                        'payment_method',
                        'COD'
                    )->count();

        $vaCount = Order::where(
                        'payment_method',
                        'Virtual Account'
                    )->count();

        return view(

            'admin.pembayaran.index',

            compact(

                'payments',

                'totalTransaction',

                'monthlyIncome',

                'waitingConfirmation',

                'paidTransaction',

                'codCount',

                'vaCount'

            )

        );

    }

}