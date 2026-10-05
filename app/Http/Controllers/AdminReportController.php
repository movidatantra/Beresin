<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Complaint;





class AdminReportController extends Controller
{
    public function index()
    {
        $totalOrder = Order::count();
        $totalIncome = Order::where('payment_status','lunas')->sum('total_price');
        $totalMitra = User::where('role','mitra')->count();
        $totalCustomer = User::where('role','pelanggan')->count();

        $completedOrder = Order::where('status','selesai')->count();
        $processOrder = Order::where('status','diproses')->count();
        $pendingOrder = Order::where('status','pending')->count();

        return view('admin.reports.index', compact(
            'totalOrder',
            'totalIncome',
            'totalMitra',
            'totalCustomer',
            'completedOrder',
            'processOrder',
            'pendingOrder'
        ));
    }

   

public function orders(Request $request)
{
    $query = Order::with([
        'user',
        'mitra',
        'service'
    ]);

    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $orders = $query
        ->latest()
        ->paginate(10);

    return view(
        'admin.reports.orders',
        compact('orders')
    );
}

    

public function income(Request $request)
{
    $query = Order::with([
        'user',
        'mitra',
        'service'
    ])->where('payment_status', 'lunas');

    // Filter tanggal
    if ($request->filled('start_date')) {
        $query->whereDate('jadwal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('jadwal', '<=', $request->end_date);
    }

    // Filter metode pembayaran
    if ($request->filled('payment_method')) {
        $query->where('payment_method', $request->payment_method);
    }

    // Total pendapatan (sebelum paginate)
    $totalIncome = (clone $query)->sum('total_price');

    // Statistik
    $paidOrder = (clone $query)->count();

    $bankPayment = Order::where('payment_status', 'lunas')
        ->where('payment_method', 'bank')
        ->count();

    $ewalletPayment = Order::where('payment_status', 'lunas')
        ->where('payment_method', 'ewallet')
        ->count();

    // Data tabel
    $orders = $query
        ->latest()
        ->paginate(10);

    return view('admin.reports.income', compact(
        'orders',
        'totalIncome',
        'paidOrder',
        'bankPayment',
        'ewalletPayment'
    ));
}

   public function mitras(Request $request)
{
    $query = User::where('role', 'mitra');

    // Filter nama
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filter status verifikasi
    if ($request->filled('verification_status')) {
        $query->where('verification_status', $request->verification_status);
    }

    // Filter spesialisasi
    if ($request->filled('specialization')) {
        $query->where('specialization', 'like', '%' . $request->specialization . '%');
    }

    $mitras = $query->latest()->paginate(10);

    // Tambahkan statistik tiap mitra
    foreach ($mitras as $mitra) {

        $mitra->orders_count = Order::where('mitra_id', $mitra->id)->count();

        $mitra->income = Order::where('mitra_id', $mitra->id)
            ->where('payment_status', 'lunas')
            ->sum('total_price');
    }

    // Statistik dashboard
    $totalMitra = User::where('role', 'mitra')->count();

    $verifiedMitra = User::where('role', 'mitra')
        ->where('verification_status', 'verified')
        ->count();

    $totalOrder = Order::count();

    $totalIncome = Order::where('payment_status', 'lunas')
        ->sum('total_price');

    return view('admin.reports.mitras', compact(
        'mitras',
        'totalMitra',
        'verifiedMitra',
        'totalOrder',
        'totalIncome'
    ));
}

    public function customers(Request $request)
{
    $query = User::where('role', 'pelanggan');

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

    // Tambahkan statistik setiap pelanggan
    foreach ($customers as $customer) {

        $customer->orders_count = Order::where(
            'user_id',
            $customer->id
        )->count();

        $customer->total_transaction = Order::where(
            'user_id',
            $customer->id
        )
        ->where('payment_status', 'lunas')
        ->sum('total_price');

    }

    // Statistik Dashboard
    $totalCustomer = User::where(
        'role',
        'pelanggan'
    )->count();

    $activeCustomer = User::where('role', 'pelanggan')
        ->whereHas('orders')
        ->count();

    $totalBooking = Order::count();

    $totalTransaction = Order::where(
        'payment_status',
        'lunas'
    )->sum('total_price');

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

    public function services(Request $request)
{
    $query = Service::query();

    // Filter nama layanan
    if ($request->filled('search')) {

        $query->where('name', 'like', '%' . $request->search . '%');

    }

    // Filter status
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    $services = $query
        ->latest()
        ->paginate(10);

    // Hitung performa setiap layanan
    foreach ($services as $service) {

        $service->orders_count = Order::where(
            'service_id',
            $service->id
        )->count();

        $service->income = Order::where(
            'service_id',
            $service->id
        )
        ->where('payment_status', 'lunas')
        ->sum('total_price');

    }

    // Statistik Dashboard
    $totalService = Service::count();

    $activeService = Service::where(
        'status',
        'aktif'
    )->count();

    $totalOrder = Order::count();

    $totalIncome = Order::where(
        'payment_status',
        'lunas'
    )->sum('total_price');

    return view(
        'admin.reports.services',
        compact(
            'services',
            'totalService',
            'activeService',
            'totalOrder',
            'totalIncome'
        )
    );
}

    public function complaints(Request $request)
{
    $query = Complaint::with([
        'user',
        'admin'
    ]);

    // Filter nama pelapor
    if ($request->filled('search')) {

        $query->whereHas('user', function ($q) use ($request) {

            $q->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );

        });

    }

    // Filter status
    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );

    }

    // Filter tanggal
    if ($request->filled('tanggal')) {

        $query->whereDate(
            'created_at',
            $request->tanggal
        );

    }

    $complaints = $query
        ->latest()
        ->paginate(10);

    // CARD STATISTIK

    $totalComplaint = Complaint::count();

    $waitingComplaint = Complaint::where(
        'status',
        'pending'
    )->count();

    $processComplaint = Complaint::where(
        'status',
        'diproses'
    )->count();

    $doneComplaint = Complaint::where(
        'status',
        'selesai'
    )->count();

    return view(
        'admin.reports.complaints',
        compact(
            'complaints',
            'totalComplaint',
            'waitingComplaint',
            'processComplaint',
            'doneComplaint'
        )
    );
}
}