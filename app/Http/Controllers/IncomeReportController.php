<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Exports\IncomeExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IncomeReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN PENDAPATAN
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
{
    $query = Order::with(['user','mitra'])
        ->where('payment_status', 'lunas');

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    if ($request->filled('payment_method')) {

        if ($request->payment_method == 'bank') {

            $query->where('payment_method', 'BANK_TRANSFER');

        } elseif ($request->payment_method == 'ewallet') {

            $query->whereIn('payment_method', [
                'GOPAY',
                'OVO',
                'DANA',
                'SHOPEEPAY',
                'LINKAJA',
                'QRIS'
            ]);

        }

    }

    $orders = $query->latest()->paginate(10);

    $totalIncome = (clone $query)->sum('total_price');

    $paidOrder = (clone $query)->count();

    $bankPayment = (clone $query)
        ->where('payment_method', 'BANK_TRANSFER')
        ->count();

    $ewalletPayment = (clone $query)
        ->whereIn('payment_method', [
            'GOPAY',
            'OVO',
            'DANA',
            'SHOPEEPAY',
            'LINKAJA',
            'QRIS'
        ])
        ->count();

    return view('admin.reports.income', compact(
        'orders',
        'totalIncome',
        'paidOrder',
        'bankPayment',
        'ewalletPayment'
    ));
}
    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
 public function pdf(Request $request)
{
    $query = Order::with(['user','mitra'])
        ->where('payment_status', 'lunas');

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    if ($request->filled('payment_method')) {

        if ($request->payment_method == 'bank') {

            $query->where('payment_method', 'BANK_TRANSFER');

        } elseif ($request->payment_method == 'ewallet') {

            $query->whereIn('payment_method', [
                'GOPAY',
                'OVO',
                'DANA',
                'SHOPEEPAY',
                'LINKAJA',
                'QRIS'
            ]);

        }

    }

    // Pakai paginate supaya view tetap mengenali paginator
    $orders = $query->latest()->paginate(100000);

    $totalIncome = $orders->sum('total_price');

    $paidOrder = $orders->count();

    $bankPayment = $orders
        ->where('payment_method', 'BANK_TRANSFER')
        ->count();

    $ewalletPayment = $orders
        ->whereIn('payment_method', [
            'GOPAY',
            'OVO',
            'DANA',
            'SHOPEEPAY',
            'LINKAJA',
            'QRIS'
        ])
        ->count();

    $isPdf = true;

   $totalIncome = $orders->sum('total_price');

$pdf = Pdf::loadView(
    'admin.reports.pdf.income',
    compact(
        'orders',
        'totalIncome'
    )
);

    return $pdf->download('laporan-pendapatan.pdf');
}

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function excel(Request $request)
    {
        return Excel::download(

            new IncomeExport(

                $request->start_date,

                $request->end_date,

                $request->payment_method

            ),

            'laporan-pendapatan.xlsx'

        );
    }
}