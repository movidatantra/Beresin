<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerOrderExport;
use App\Models\Order;
use App\Models\Review;
use App\Exports\CustomerPaymentExport;
use App\Exports\CustomerReviewExport;

use Illuminate\Http\Request;

class CustomerLaporanController extends Controller
{
    public function index()
    {
        return view('pelanggan.reports.index');
    }

    public function orders(Request $request)
{
    $query = Order::with([
        'mitra',
        'service'
    ])
    ->where('user_id', auth()->id());

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    $orders = $query
        ->latest()
        ->paginate(10);

    $totalOrder = Order::where(
        'user_id',
        auth()->id()
    )->count();

    $completedOrder = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('status','selesai')
    ->count();

    $pendingOrder = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('status','pending')
    ->count();

    $cancelledOrder = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('status','dibatalkan')
    ->count();

    return view(
        'pelanggan.reports.orders',
        compact(
            'orders',
            'totalOrder',
            'completedOrder',
            'pendingOrder',
            'cancelledOrder'
        )
    );
}

    public function payments(Request $request)
{
    $query = Order::with([
        'mitra',
        'service'
    ])
    ->where('user_id', auth()->id());

    if ($request->filled('payment_status')) {

        $query->where(
            'payment_status',
            $request->payment_status
        );

    }

    if ($request->filled('start_date')) {

        $query->whereDate(
            'jadwal',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'jadwal',
            '<=',
            $request->end_date
        );

    }

    $payments = $query
        ->latest()
        ->paginate(10);

    $totalPayment = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('payment_status','lunas')
    ->sum('total_price');

    $paid = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('payment_status','lunas')
    ->count();

    $waiting = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('payment_status','menunggu_verifikasi')
    ->count();

    $unpaid = Order::where(
        'user_id',
        auth()->id()
    )
    ->where('payment_status','belum_bayar')
    ->count();

    return view(
        'pelanggan.reports.payments',
        compact(
            'payments',
            'totalPayment',
            'paid',
            'waiting',
            'unpaid'
        )
    );
}

    public function reviews(Request $request)
{
    $query = Review::with([
        'mitra',
        'order'
    ])
    ->where('user_id', auth()->id());

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
        'user_id',
        auth()->id()
    )->avg('rating');

    $totalReview = Review::where(
        'user_id',
        auth()->id()
    )->count();

    $rating5 = Review::where(
        'user_id',
        auth()->id()
    )->where('rating',5)->count();

    $rating4 = Review::where(
        'user_id',
        auth()->id()
    )->where('rating',4)->count();

    $rating3 = Review::where(
        'user_id',
        auth()->id()
    )->where('rating',3)->count();

    $rating2 = Review::where(
        'user_id',
        auth()->id()
    )->where('rating',2)->count();

    $rating1 = Review::where(
        'user_id',
        auth()->id()
    )->where('rating',1)->count();

    return view(
        'pelanggan.reports.reviews',
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

    public function orderPdf(Request $request)
{
    $query = Order::with([
        'mitra',
        'service'
    ])
    ->where('user_id', auth()->id());

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );

    }

    if ($request->filled('start_date')) {

        $query->whereDate(
            'jadwal',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'jadwal',
            '<=',
            $request->end_date
        );

    }

    $orders = $query
        ->latest()
        ->get();

    $totalOrder = $orders->count();

    $completedOrder = $orders
        ->where('status','selesai')
        ->count();

    $pendingOrder = $orders
        ->where('status','pending')
        ->count();

    $cancelledOrder = $orders
        ->where('status','dibatalkan')
        ->count();

    $pdf = Pdf::loadView(

        'pelanggan.reports.pdf.orders',

        compact(

            'orders',

            'totalOrder',

            'completedOrder',

            'pendingOrder',

            'cancelledOrder'

        )

    );

    return $pdf->download(
        'laporan-pesanan-customer.pdf'
    );
}

   public function paymentPdf(Request $request)
{
    $query = Order::with([
        'mitra',
        'service'
    ])
    ->where('user_id', auth()->id());

    if ($request->filled('payment_status')) {

        $query->where(
            'payment_status',
            $request->payment_status
        );

    }

    if ($request->filled('start_date')) {

        $query->whereDate(
            'jadwal',
            '>=',
            $request->start_date
        );

    }

    if ($request->filled('end_date')) {

        $query->whereDate(
            'jadwal',
            '<=',
            $request->end_date
        );

    }

    $payments = $query
        ->latest()
        ->get();

    $totalPayment = $payments
        ->where('payment_status','lunas')
        ->sum('total_price');

    $paid = $payments
        ->where('payment_status','lunas')
        ->count();

    $unpaid = $payments
        ->where('payment_status','belum_bayar')
        ->count();

    $totalTransaction = $payments->count();

    $pdf = Pdf::loadView(

        'pelanggan.reports.pdf.payments',

        compact(

            'payments',

            'totalPayment',

            'paid',

            'unpaid',

            'totalTransaction'

        )

    );

    return $pdf->download(
        'laporan-pembayaran-customer.pdf'
    );
}

    public function reviewPdf(Request $request)
{
    $query = Review::with([
        'mitra',
        'order'
    ])
    ->where('user_id', auth()->id());

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
        ->get();

    $averageRating = $reviews->avg('rating');

    $totalReview = $reviews->count();

    $rating5 = $reviews->where('rating',5)->count();

    $rating4 = $reviews->where('rating',4)->count();

    $rating3 = $reviews->where('rating',3)->count();

    $rating2 = $reviews->where('rating',2)->count();

    $rating1 = $reviews->where('rating',1)->count();

    $pdf = Pdf::loadView(

        'pelanggan.reports.pdf.reviews',

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

    return $pdf->download(
        'laporan-rating-review.pdf'
    );
}

    public function orderExcel(Request $request)
{
    return Excel::download(

        new CustomerOrderExport(

            auth()->id(),

            $request->status,

            $request->start_date,

            $request->end_date

        ),

        'laporan-pesanan-customer.xlsx'

    );
}

    public function paymentExcel(Request $request)
{
    return Excel::download(

        new CustomerPaymentExport(

            auth()->id(),

            $request->payment_status,

            $request->start_date,

            $request->end_date

        ),

        'laporan-pembayaran-customer.xlsx'

    );
}

    public function reviewExcel(Request $request)
{
    return Excel::download(

        new CustomerReviewExport(

            auth()->id(),

            $request->start_date,

            $request->end_date

        ),

        'laporan-rating-review.xlsx'

    );
}
}