<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;

class CustomerReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = User::where('role', 'pelanggan')
            ->withCount('orders');

        // Filter nama / email
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');

            });

        }

        $customers = $query
            ->latest()
            ->paginate(10);

        // Total transaksi setiap pelanggan
        foreach ($customers as $customer) {

            $customer->total_transaction = Order::where(
                'user_id',
                $customer->id
            )
            ->where('payment_status', 'lunas')
            ->sum('total_price');

        }

        $totalCustomer = User::where('role', 'pelanggan')->count();

        $activeCustomer = User::where('role', 'pelanggan')
            ->whereHas('orders')
            ->count();

        $totalBooking = Order::count();

        $totalTransaction = Order::where('payment_status', 'lunas')
            ->sum('total_price');

        return view(
            'admin.reports.customers',
            compact(
                'customers',
                'totalCustomer',
                'activeCustomer',
                'totalBooking',
                'totalTransaction'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function pdf(Request $request)
    {
        $query = User::where('role', 'pelanggan')
            ->withCount('orders');

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');

            });

        }

        $customers = $query->get();

        foreach ($customers as $customer) {

            $customer->total_transaction = Order::where(
                'user_id',
                $customer->id
            )
            ->where('payment_status', 'lunas')
            ->sum('total_price');

        }

        $totalCustomer = $customers->count();

        $activeCustomer = $customers
            ->where('orders_count', '>', 0)
            ->count();

        $totalBooking = Order::count();

        $totalTransaction = Order::where('payment_status', 'lunas')
            ->sum('total_price');

        $pdf = Pdf::loadView(
            'admin.reports.pdf.customers',
            compact(
                'customers',
                'totalCustomer',
                'activeCustomer',
                'totalBooking',
                'totalTransaction'
            )
        );

        return $pdf->download('laporan-pelanggan.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function excel(Request $request)
    {
        return Excel::download(

            new CustomerExport(

                $request->search

            ),

            'laporan-pelanggan.xlsx'

        );
    }
}