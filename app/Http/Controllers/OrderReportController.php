<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\OrdersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class  OrderReportController extends Controller
{
    public function pdf(Request $request)
{
    $query = Order::with([
        'user',
        'mitra',
        'service'
    ]);

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $orders = $query->latest()->get();

    $pdf = Pdf::loadView(
        'admin.reports.pdf.orders',
        compact(
            'orders'
        )
    );

    return $pdf->download('laporan-order.pdf');
}

    public function excel(Request $request)
{
    return Excel::download(

        new OrdersExport(

            $request->start_date,

            $request->end_date,

            $request->status

        ),

        'laporan-order.xlsx'

    );
}
}