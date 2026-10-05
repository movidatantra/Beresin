<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MitraExport;

class MitraReportController extends Controller
{
    

    public function pdf(Request $request)
{
    $query = User::where('role', 'mitra')
        ->withCount('orders');

    // Filter nama
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('business_name', 'like', '%' . $request->search . '%');
        });
    }

    // Filter status verifikasi
    if ($request->filled('verification_status')) {
        $query->where(
            'verification_status',
            $request->verification_status
        );
    }

    // Filter spesialisasi
    if ($request->filled('specialization')) {
        $query->where(
            'specialization',
            'like',
            '%' . $request->specialization . '%'
        );
    }

    $mitras = $query->get();

    // Tambahkan pendapatan tiap mitra
    foreach ($mitras as $mitra) {

    $mitra->income = Order::where('mitra_id', $mitra->id)
        ->where('payment_status', 'lunas')
        ->sum('total_price');

    $mitra->total_order = Order::where('mitra_id', $mitra->id)
        ->count();

}

    $totalMitra = $mitras->count();

    $verifiedMitra = $mitras
        ->where('verification_status', 'verified')
        ->count();

    $totalOrder = Order::count();

    $totalIncome = Order::where('payment_status', 'lunas')
        ->sum('total_price');

    $pdf = Pdf::loadView(
        'admin.reports.pdf.mitras',
        compact(
            'mitras',
            'totalMitra',
            'verifiedMitra',
            'totalOrder',
            'totalIncome'
        )
    );

    return $pdf->download('laporan-mitra.pdf');
}

public function excel(Request $request)
{
    return Excel::download(

        new MitraExport(

            $request->search,

            $request->verification_status,

            $request->specialization

        ),

        'laporan-mitra.xlsx'

    );
}
}
