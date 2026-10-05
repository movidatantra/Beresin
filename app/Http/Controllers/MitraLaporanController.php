<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MitraIncomeExport;
use App\Models\Review;
use App\Models\Saldopencairan;
use App\Exports\MitraOrderExport;
use App\Exports\MitraReviewExport;
use App\Exports\MitraWithdrawalExport;

class MitraLaporanController extends Controller
{
    public function index()
{
    return view('mitra.reports.index');
}
public function income(Request $request)
{
    $query = Order::with([
        'user',
        'service'
    ])
    ->where('mitra_id', auth()->id())
    ->where('payment_status', 'lunas');

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    $orders = $query->latest()->paginate(10);

    $totalIncome = (clone $query)->sum('total_price');

    $totalOrder = (clone $query)->count();

    $completedOrder = Order::where('mitra_id', auth()->id())
        ->where('status', 'selesai')
        ->count();

    return view(
        'mitra.reports.income',
        compact(
            'orders',
            'totalIncome',
            'totalOrder',
            'completedOrder'
        )
    );
}
public function orders(Request $request)
{
    $query = Order::with([
        'user',
        'service'
    ])
    ->where('mitra_id', auth()->id());

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    $orders = $query->latest()->paginate(10);

    // Statistik
    $totalOrder = Order::where('mitra_id', auth()->id())->count();

    $pendingOrder = Order::where('mitra_id', auth()->id())
        ->where('status', 'pending')
        ->count();

    $completedOrder = Order::where('mitra_id', auth()->id())
        ->where('status', 'selesai')
        ->count();

    $cancelledOrder = Order::where('mitra_id', auth()->id())
        ->where('status', 'dibatalkan')
        ->count();

    return view(
        'mitra.reports.orders',
        compact(
            'orders',
            'totalOrder',
            'pendingOrder',
            'completedOrder',
            'cancelledOrder'
        )
    );
}
public function reviews(Request $request)
{
    $query = Review::with([
        'user',
        'order'
    ])
    ->where('mitra_id', auth()->id());

    if ($request->filled('start_date')) {

        $query->whereDate(
            'created_at',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'created_at',
            '<=',
            $request->end_date
        );

    }

    $reviews = $query
        ->latest()
        ->paginate(10);

    $averageRating = Review::where(
        'mitra_id',
        auth()->id()
    )->avg('rating');

    $totalReview = Review::where(
        'mitra_id',
        auth()->id()
    )->count();

    $rating5 = Review::where(
        'mitra_id',
        auth()->id()
    )->where('rating',5)->count();

    $rating4 = Review::where(
        'mitra_id',
        auth()->id()
    )->where('rating',4)->count();

    $rating3 = Review::where(
        'mitra_id',
        auth()->id()
    )->where('rating',3)->count();

    $rating2 = Review::where(
        'mitra_id',
        auth()->id()
    )->where('rating',2)->count();

    $rating1 = Review::where(
        'mitra_id',
        auth()->id()
    )->where('rating',1)->count();

    return view(
        'mitra.reports.reviews',
        compact(

            'reviews',

            'averageRating',

            'totalReview',

            'rating5',

            'rating4',

            'rating3',

            'rating2',

            'rating1'

        )
    );
}
public function withdrawals(Request $request)
{
    $query = Saldopencairan::where(
        'mitra_id',
        auth()->id()
    );

    if ($request->filled('start_date')) {

        $query->whereDate(
            'created_at',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'created_at',
            '<=',
            $request->end_date
        );

    }

    $withdrawals = (clone $query)
        ->latest()
        ->paginate(10);

    // GANTI 'amount' jika nama kolom nominal di tabelmu berbeda
    $totalWithdrawal = (clone $query)
        ->sum('amount');

    $totalRequest = (clone $query)
        ->count();

    $approved = (clone $query)
        ->where('status', 'approved')
        ->count();

    $pending = (clone $query)
        ->where('status', 'pending')
        ->count();

    return view(
        'mitra.reports.withdrawals',
        compact(
            'withdrawals',
            'totalWithdrawal',
            'totalRequest',
            'approved',
            'pending'
        )
    );
}


    public function incomePdf(Request $request)
    {
        $query = Order::with([
            'user',
            'service'
        ])
        ->where('mitra_id', auth()->id())
        ->where('payment_status', 'lunas');

        if ($request->filled('start_date')) {
            $query->whereDate('jadwal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('jadwal', '<=', $request->end_date);
        }

        $orders = $query->latest()->get();

        $totalIncome = $orders->sum('total_price');

        $totalOrder = $orders->count();

        $completedOrder = $orders
            ->where('status', 'selesai')
            ->count();

        $pdf = Pdf::loadView(
            'mitra.reports.pdf.income',
            compact(
                'orders',
                'totalIncome',
                'totalOrder',
                'completedOrder'
            )
        );

        return $pdf->download('laporan-pendapatan.pdf');
    }
    public function orderPdf(Request $request)
{
    $query = Order::with([
        'user',
        'service'
    ])
    ->where('mitra_id', auth()->id());

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    $orders = $query->latest()->get();

    $pdf = Pdf::loadView(
        'mitra.reports.pdf.orders',
        compact('orders')
    );

    return $pdf->download('laporan-order.pdf');
}
public function reviewPdf(Request $request)
{
    $query = Review::with('user')
        ->where('mitra_id', auth()->id());

    if ($request->filled('start_date')) {
        $query->whereDate(
            'created_at',
            '>=',
            $request->start_date
        );
    }

    if ($request->filled('end_date')) {
        $query->whereDate(
            'created_at',
            '<=',
            $request->end_date
        );
    }

    $reviews = $query->latest()->get();

    $averageRating = $reviews->avg('rating');

    $totalReview = $reviews->count();

    $pdf = Pdf::loadView(
        'mitra.reports.pdf.reviews',
        compact(
            'reviews',
            'averageRating',
            'totalReview'
        )
    );

    return $pdf->download(
        'laporan-rating-review.pdf'
    );
}

    public function incomeExcel(Request $request)
    {
        return Excel::download(
            new MitraIncomeExport(
                auth()->id(),
                $request->start_date,
                $request->end_date
            ),
            'laporan-pendapatan.xlsx'
        );
    }
    public function orderExcel(Request $request)
{
    return Excel::download(

        new MitraOrderExport(

            auth()->id(),

            $request->status,

            $request->start_date,

            $request->end_date

        ),

        'laporan-order.xlsx'

    );
}
public function reviewExcel(Request $request)
{
    return Excel::download(

        new MitraReviewExport(

            auth()->id(),

            $request->start_date,

            $request->end_date

        ),

        'laporan-rating-review.xlsx'

    );
}
public function withdrawalPdf(Request $request)
{
    $query = Saldopencairan::where(
        'mitra_id',
        auth()->id()
    );

    if ($request->filled('start_date')) {

        $query->whereDate(
            'created_at',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'created_at',
            '<=',
            $request->end_date
        );

    }

    $withdrawals = $query
        ->latest()
        ->get();

    $totalWithdrawal = $withdrawals->sum('amount');

    $approved = $withdrawals
        ->where('status', 'approved')
        ->count();

    $pending = $withdrawals
        ->where('status', 'pending')
        ->count();

    $pdf = Pdf::loadView(

        'mitra.reports.pdf.withdrawals',

        compact(

            'withdrawals',

            'totalWithdrawal',

            'approved',

            'pending'

        )

    );

    return $pdf->download(
        'laporan-pencairan-saldo.pdf'
    );
}
public function withdrawalExcel(Request $request)
{
    return Excel::download(

        new MitraWithdrawalExport(

            auth()->id(),

            $request->start_date,

            $request->end_date

        ),

        'laporan-pencairan-saldo.xlsx'

    );
}
}