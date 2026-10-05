<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Review;
use App\Models\Saldopencairan;

class AdminMitraController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mitra');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('business_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER ONLINE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('online')) {
            $query->where('is_online', $request->online);
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */
        switch ($request->sort) {
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
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */
        $mitras = $query->paginate(10)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $totalMitra = User::where('role', 'mitra')->count();
        $verified = User::where('role', 'mitra')->where('verification_status', 'verified')->count();
        $pending = User::where('role', 'mitra')->where('verification_status', 'pending')->count();
        $rejected = User::where('role', 'mitra')->where('verification_status', 'rejected')->count();

        return view(
            'admin.kelola-pengguna.mitra.index',
            compact('mitras', 'totalMitra', 'verified', 'pending', 'rejected')
        );
    }

    public function show($id)
    {
        $mitra = User::where('role', 'mitra')->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */
        $totalOrder = Order::where('mitra_id', $mitra->id)->count();
        $pendingOrder = Order::where('mitra_id', $mitra->id)->where('status', 'pending')->count();
        
        $processOrder = Order::where('mitra_id', $mitra->id)
            ->whereIn('status', ['diterima', 'menuju_lokasi', 'dikerjakan'])
            ->count();

        $completedOrder = Order::where('mitra_id', $mitra->id)->where('status', 'selesai')->count();
        $totalIncome = Order::where('mitra_id', $mitra->id)->where('payment_status', 'lunas')->sum('total_price');
        $totalReview = Review::where('mitra_id', $mitra->id)->count();
        $averageRating = Review::where('mitra_id', $mitra->id)->avg('rating');

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENCAIRAN
        |--------------------------------------------------------------------------
        */
        $withdrawQuery = Saldopencairan::where('mitra_id', $mitra->id);

        if (request()->filled('search_withdraw')) {
            $withdrawQuery->where('id', 'like', "%" . request('search_withdraw') . "%");
        }
        if (request()->filled('withdraw_status')) {
            $withdrawQuery->where('status', request('withdraw_status'));
        }
        if (request()->filled('withdraw_from')) {
            $withdrawQuery->whereDate('created_at', '>=', request('withdraw_from'));
        }
        if (request()->filled('withdraw_to')) {
            $withdrawQuery->whereDate('created_at', '<=', request('withdraw_to'));
        }

        $withdrawals = $withdrawQuery->latest()->paginate(10)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | LAYANAN MITRA
        |--------------------------------------------------------------------------
        */
        $services = Service::where('mitra_id', $mitra->id)->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT ORDER
        |--------------------------------------------------------------------------
        */
        $orderQuery = Order::with(['customer', 'items.service'])->where('mitra_id', $mitra->id);

        if (request()->filled('search_order')) {
            $search = request('search_order');
            $orderQuery->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }
        if (request()->filled('status_order')) {
            $orderQuery->where('status', request('status_order'));
        }
        if (request()->filled('from_date')) {
            $orderQuery->whereDate('jadwal', '>=', request('from_date'));
        }
        if (request()->filled('to_date')) {
            $orderQuery->whereDate('jadwal', '<=', request('to_date'));
        }

        $orders = $orderQuery->latest()->paginate(10)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | LOG POLA AKTIVITAS MITRA
        |--------------------------------------------------------------------------
        */
        $reviews = Review::where('mitra_id', $mitra->id)->latest()->get();
        $allWithdrawalsForActivity = Saldopencairan::where('mitra_id', $mitra->id)->get();
        
        $activities = collect();

        // 1. Aktivitas Registrasi
        $activities->push([
            'type'  => 'register',
            'icon'  => 'bi-person-plus-fill',
            'color' => 'primary',
            'title' => 'Mendaftar sebagai mitra',
            'time'  => $mitra->created_at,
        ]);

        // 2. Aktivitas Verifikasi
        if ($mitra->verification_status == 'verified') {
            $activities->push([
                'type'   => 'verification',
                'status' => 'Verified',
                'icon'   => 'bi-patch-check-fill',
                'color'  => 'success',
                'title'  => 'Akun berhasil diverifikasi',
                'time'   => $mitra->updated_at,
            ]);
        }

        // 3. Aktivitas Order
        foreach ($orders as $order) {
            $activities->push([
                'type'   => 'order',
                'status' => ucfirst($order->status),
                'icon'   => 'bi-cart-check-fill',
                'color'  => 'info',
                'title'  => 'Menerima Order ' . $order->invoice_number,
                'time'   => $order->created_at
            ]);

            if ($order->status == 'selesai') {
                $activities->push([
                    'type'   => 'order',
                    'status' => 'Selesai',
                    'icon'   => 'bi-check-circle-fill',
                    'color'  => 'success',
                    'title'  => 'Menyelesaikan Order ' . $order->invoice_number,
                    'time'   => $order->updated_at
                ]);
            }
        }

        // 4. Aktivitas Ulasan / Review
        foreach ($reviews as $review) {
            $activities->push([
                'type'   => 'review',
                'status' => $review->rating . ' Bintang',
                'icon'   => 'bi-star-fill',
                'color'  => 'warning',
                'title'  => 'Mendapat ulasan ' . $review->rating . ' bintang dari pelanggan',
                'time'   => $review->created_at
            ]);
        }

        // 5. Aktivitas Pencairan Saldo
        foreach ($allWithdrawalsForActivity as $withdraw) {
            $activities->push([
                'type'   => 'withdraw',
                'status' => ucfirst($withdraw->status),
                'icon'   => 'bi-wallet2',
                'color'  => 'danger',
                'title'  => 'Mengajukan pencairan Rp ' . number_format($withdraw->amount, 0, ',', '.'),
                'time'   => $withdraw->created_at
            ]);

            if ($withdraw->status == 'berhasil') {
                $activities->push([
                    'type'   => 'withdraw',
                    'status' => 'Berhasil',
                    'icon'   => 'bi-bank',
                    'color'  => 'success',
                    'title'  => 'Pencairan berhasil ditransfer',
                    'time'   => $withdraw->updated_at
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER & SORT AKTIVITAS
        |--------------------------------------------------------------------------
        */
        /*
        |--------------------------------------------------------------------------
        | FILTER & SORT AKTIVITAS
        |--------------------------------------------------------------------------
        */
        /*
        |--------------------------------------------------------------------------
        | FILTER & SORT AKTIVITAS
        |--------------------------------------------------------------------------
        */
        // 1. Filter Berdasarkan Teks
        if (request()->filled('search_activity')) {
            $search = strtolower(request('search_activity'));
            $activities = $activities->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['title']), $search);
            });
        }

        // 2. Filter Berdasarkan Jenis Aktivitas
        if (request()->filled('activity_type')) {
            $type = request('activity_type');
            $activities = $activities->filter(function ($item) use ($type) {
                return $item['type'] === $type;
            });
        }

        // 3. Filter Kalender: Dari Tanggal
        if (request()->filled('activity_from')) {
            $fromDate = request('activity_from');
            $activities = $activities->filter(function ($item) use ($fromDate) {
                return $item['time']->format('Y-m-d') >= $fromDate;
            });
        }

        // 4. Filter Kalender: Sampai Tanggal
        if (request()->filled('activity_to')) {
            $toDate = request('activity_to');
            $activities = $activities->filter(function ($item) use ($toDate) {
                return $item['time']->format('Y-m-d') <= $toDate;
            });
        }

        // Urutkan ulang berdasarkan waktu terbaru
        $activities = $activities->sortByDesc('time')->values();

        

        return view(
            'admin.kelola-pengguna.mitra.show',
            compact(
                'mitra',
                'totalOrder',
                'pendingOrder',
                'processOrder',
                'completedOrder',
                'totalIncome',
                'totalReview',
                'averageRating',
                'services',
                'orders',
                'withdrawals',
                'activities'
            )
        );
    }

    public function suspend($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'suspended';
        $mitra->save();

        return back()->with('success', 'Mitra berhasil disuspend.');
    }

    public function activate($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'active';
        $mitra->save();

        return back()->with('success', 'Mitra berhasil diaktifkan.');
    }
}