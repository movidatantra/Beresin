<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class AdminOrderController extends Controller
{

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | QUERY ORDER (BASE)
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

        if($request->filled('search'))
        {
            $search = $request->search;

            $query->where(function($q) use($search){
                $q->where(
                    'invoice_number',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas('user',function($user) use($search){
                    $user->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                })
                ->orWhereHas('mitra',function($mitra) use($search){
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
        | FILTER STATUS ORDER
        |--------------------------------------------------------------------------
        */

        if($request->filled('status'))
        {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if($request->filled('payment'))
        {
            $query->where(
                'payment_status',
                $request->payment
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER METODE PEMBAYARAN (Tambahan dari view sebelumnya)
        |--------------------------------------------------------------------------
        */

        if($request->filled('method'))
        {
            $query->where(
                'payment_method',
                $request->method
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if($request->filled('from'))
        {
            $query->whereDate(
                'jadwal',
                '>=',
                $request->from
            );
        }

        if($request->filled('to'))
        {
            $query->whereDate(
                'jadwal',
                '<=',
                $request->to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTIK DINAMIS (Mengikuti hasil filter di atas)
        |--------------------------------------------------------------------------
        */

        // Clone query agar filter pencarian & tanggal ikut menyaring statistik
        $filteredStatsQuery = clone $query;

        $totalOrder     = (clone $filteredStatsQuery)->count();
        $todayOrder     = (clone $filteredStatsQuery)->whereDate('created_at', today())->count();
        $processOrder   = (clone $filteredStatsQuery)->whereIn('status', ['pending', 'diterima', 'menuju_lokasi', 'dikerjakan'])->count();
        $completedOrder = (clone $filteredStatsQuery)->where('status', 'selesai')->count();
        $cancelOrder    = (clone $filteredStatsQuery)->where('status', 'dibatalkan')->count();

        // Asumsi: Pendapatan Mitra dari subtotal, dan Pendapatan Admin dari service_fee (biaya admin)
        // (Bisa disesuaikan dengan nama kolom di database Anda jika berbeda)
        $totalMitraIncome = (clone $filteredStatsQuery)->sum('subtotal');
        $totalAdminIncome = (clone $filteredStatsQuery)->sum('service_fee');


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch($request->sort)
        {
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

        /*
        |--------------------------------------------------------------------------
        | PAGINATION & RESPONSE
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.kelola-order.index',
            compact(
                'orders',
                'totalOrder',
                'todayOrder',
                'processOrder',
                'completedOrder',
                'cancelOrder',
                'totalMitraIncome',
                'totalAdminIncome'
            )
        );

    }

    public function show($id)
    {
        $order = Order::with([
            'user',
            'mitra',
            'service'
        ])->findOrFail($id);

        return view(
            'admin.kelola-order.show',
            compact(
                'order'
            )
        );
    }

}