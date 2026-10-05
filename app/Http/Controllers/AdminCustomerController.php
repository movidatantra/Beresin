<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
{
    $query = User::where('role','pelanggan');

    // SEARCH
    if($request->filled('search'))
    {
        $search = $request->search;

        $query->where(function($q) use($search){

            $q->where('name','like',"%{$search}%")
              ->orWhere('email','like',"%{$search}%")
              ->orWhere('phone','like',"%{$search}%");

        });
    }

    // FILTER STATUS
    if($request->filled('status'))
    {
        $query->where('status',$request->status);
    }

    // SORTING
    switch($request->sort)
    {
        case 'oldest':

            $query->oldest();

            break;

        case 'az':

            $query->orderBy('name');

            break;

        case 'za':

            $query->orderByDesc('name');

            break;

        default:

            $query->latest();

            break;
    }

    $customers = $query
                    ->paginate(10)
                    ->withQueryString();

    $totalCustomer = User::where('role','pelanggan')->count();

    $activeCustomer = User::where('role','pelanggan')
                            ->where('status','active')
                            ->count();

    $suspendedCustomer = User::where('role','pelanggan')
                            ->where('status','suspended')
                            ->count();

    return view(
        'admin.kelola-pengguna.pelanggan.index',
        compact(
            'customers',
            'totalCustomer',
            'activeCustomer',
            'suspendedCustomer'
        )
    );
}

    public function show($id)
    {
        $customer = User::where('role', 'pelanggan')
            ->findOrFail($id);

        $orders = Order::with([
            'mitra',
            'items.service'
        ])
            ->where('user_id', $customer->id)
            ->latest()
            ->paginate(10);

        $totalOrder = Order::where('user_id', $customer->id)->count();

        $orderPending = Order::where('user_id', $customer->id)
            ->where('status', 'pending')
            ->count();

        $processOrder = Order::where('user_id', $customer->id)
            ->whereIn('status', [
                'diterima',
                'menuju_lokasi',
                'dikerjakan'
            ])
            ->count();

        $orderSelesai = Order::where('user_id', $customer->id)
            ->where('status', 'selesai')
            ->count();

        $cancelOrder = Order::where('user_id', $customer->id)
            ->where('status', 'dibatalkan')
            ->count();

        $totalPengeluaran = Order::where('user_id', $customer->id)
            ->where('payment_status', 'lunas')
            ->sum('total_price');

        $payments = Order::where('user_id', $customer->id)
            ->latest()
            ->get();

        $reviews = Review::with('mitra')
            ->where('user_id', $customer->id)
            ->latest()
            ->get();

        return view(
            'admin.kelola-pengguna.pelanggan.show',
            compact(
                'customer',
                'orders',
                'payments',
                'reviews',
                'totalOrder',
                'orderPending',
                'processOrder',
                'orderSelesai',
                'cancelOrder',
                'totalPengeluaran'
            )
        );
    }
    public function suspend($id)
    {
        $customer = User::findOrFail($id);

        $customer->update([

            'status' => 'suspended'

        ]);

        return back()->with(
            'success',
            'Pelanggan berhasil disuspend.'
        );
    }
    public function activate($id)
    {
        $customer = User::findOrFail($id);

        $customer->update([

            'status' => 'active'

        ]);

        return back()->with(
            'success',
            'Akun pelanggan berhasil diaktifkan.'
        );
    }
}
