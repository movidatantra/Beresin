<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Service;
use App\Models\Saldopencairan;
use App\Models\Bank;
use App\Models\Ewallet;
use App\Models\Notification;
use App\Models\MitraBalance;

class MitraController extends Controller
{
    public function dashboard()
    {
        $layananAktif = Service::where('mitra_id', Auth::id())
            ->where('status', 'aktif')
            ->count();

        $pendapatan = Order::where('mitra_id', Auth::id())
            ->where('status', 'selesai')
            ->sum('subtotal');

        $pendapatanBulanIni = Order::where('mitra_id', Auth::id())
            ->where('status', 'selesai')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('subtotal');

        // $saldo = Order::where('mitra_id', Auth::id())
        //     ->where('payment_status', 'lunas')
        //     ->sum('subtotal');
    $pendapatan = Order::where('mitra_id', Auth::id())
    ->where('status', 'selesai')
    ->where('payment_status', 'lunas')
    ->sum('subtotal');

$sudahDicairkan = Saldopencairan::where('mitra_id', Auth::id())
    ->where('status', 'berhasil')
    ->sum('amount');

$menunggu = Saldopencairan::where('mitra_id', Auth::id())
    ->whereIn('status', ['pending','processing','menunggu'])
    ->sum('amount');

$saldo = $pendapatan - $sudahDicairkan - $menunggu;

        $menungguPembayaran = Order::where('mitra_id', Auth::id())
            ->where('payment_status', 'belum_bayar')
            ->sum('subtotal');

        $rating = Review::where('mitra_id', Auth::id())
            ->avg('rating') ?? 0;

        $totalOrder = Order::where('mitra_id', Auth::id())->count();

        $selesai = Order::where('mitra_id', Auth::id())
            ->where('status', 'selesai')
            ->count();

        $pending = Order::where('mitra_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $diproses = Order::where('mitra_id', Auth::id())
            ->where('status', 'diproses')
            ->count();

        $pendapatanHariIni = Order::where('mitra_id', Auth::id())
            ->where('status', 'selesai')
            ->whereDate('updated_at', today())
            ->sum('subtotal');

        $dibatalkan = Order::where('mitra_id', Auth::id())
            ->where('status', 'dibatalkan')
            ->count();

        $orders = Order::with(['user', 'mitra', 'items.service'])
            ->where('mitra_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
        $notifications = Notification::where('user_id', Auth::id())
    ->latest()
    ->take(5)
    ->get();

$jumlahNotifikasi = Notification::where('user_id', Auth::id())
    ->where('is_read', 0)
    ->count();
    
// $saldoTersedia = MitraBalance::where(
//                     'mitra_id',
//                     auth()->id()
//                 )
//                 ->where(
//                     'status',
//                     'available'
//                 )
//                 ->sum('amount');

$saldoTersedia = $saldo;

        return view('mitra.dashboard', compact(
            'totalOrder',
            'selesai',
            'pending',
            'diproses',
            'orders',
            'pendapatan',
            'pendapatanBulanIni',
            'saldo',
            'menungguPembayaran',
            'rating',
            'layananAktif',
            'pendapatanHariIni',
            'dibatalkan',

    'notifications',
    'jumlahNotifikasi',
     'saldoTersedia'
        ));
    }

    public function pendapatan(Request $request)
{
    $query = Order::with([
        'user',
        'mitra',
        'items.service'
    ])
    ->where('mitra_id', Auth::id())
    ->where('payment_status', 'lunas')
    ->where('status', 'selesai');

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->filled('payment_method') && $request->payment_method != 'all') {
        $query->where('payment_method', $request->payment_method);
    }

    $transaksi = $query->latest()->get();

    $pendapatan = $transaksi->sum('subtotal');

    $hariIni = Order::where('mitra_id', Auth::id())
        ->where('payment_status', 'lunas')
        ->where('status', 'selesai')
        ->whereDate('updated_at', today())
        ->sum('subtotal');

    $bulanIni = Order::where('mitra_id', Auth::id())
        ->where('payment_status', 'lunas')
        ->where('status', 'selesai')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->sum('subtotal');

    return view(
        'mitra.pendapatan.pendapatan',
        compact(
            'transaksi',
            'pendapatan',
            'hariIni',
            'bulanIni'
        )
    );
}

  public function saldo()
    {
        // $pendapatan = Order::where('mitra_id', Auth::id())
        //     ->where('payment_status', 'lunas')
        //     ->sum('subtotal');
    $totalPendapatan = Order::where('mitra_id', Auth::id())
    ->where('status', 'selesai')
    ->where('payment_status', 'lunas')
    ->sum('subtotal');

$sudahDicairkan = Saldopencairan::where('mitra_id', Auth::id())
    ->where('status', 'berhasil')
    ->sum('amount');

$menunggu = Saldopencairan::where('mitra_id', Auth::id())
    ->whereIn('status', ['pending', 'processing', 'menunggu'])
    ->sum('amount');

$saldo = $totalPendapatan - $sudahDicairkan - $menunggu;
        // $sudahDicairkan = Saldopencairan::where('mitra_id', Auth::id())
        //     ->where('status', 'berhasil')
        //     ->sum('amount');

        // $menunggu = Saldopencairan::where('mitra_id', Auth::id())
        //     ->whereIn('status', ['pending', 'processing', 'menunggu'])
        //     ->sum('amount');

        // $saldo = $pendapatan - $sudahDicairkan - $menunggu;

        $withdrawals = Saldopencairan::where('mitra_id', Auth::id())
            ->latest()
            ->get();

      return view('mitra.saldo-pencairan.saldo', [

    'saldo'            => $saldo,

    'totalPendapatan'  => $totalPendapatan,

    'sudahDicairkan'   => $sudahDicairkan,
    'menunggu' => $menunggu,

    'withdrawals'      => $withdrawals

]);
    }

 public function withdraw(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'amount' => 'required|numeric|min:12500'
    ]);

    // Hitung saldo
    // $pendapatan = MitraBalance::where('mitra_id', $user->id)
    // ->where('type', 'income')
    // ->where('status', 'available')
    // ->sum('amount');


   $pendapatan = Order::where('mitra_id', $user->id)
    ->where('status', 'selesai')
    ->where('payment_status', 'lunas')
    ->sum('subtotal');

$sudahDicairkan = Saldopencairan::where('mitra_id', $user->id)
    ->where('status', 'berhasil')
    ->sum('amount');

$menunggu = Saldopencairan::where('mitra_id', $user->id)
    ->whereIn('status', ['pending', 'processing', 'menunggu'])
    ->sum('amount');

$saldoTersedia = $pendapatan - $sudahDicairkan - $menunggu;
    // $pendapatan = Order::where('mitra_id', $user->id)
    //     ->where('payment_status', 'lunas')
    //     ->sum('subtotal');

    // $sudahDicairkan = Saldopencairan::where('mitra_id', $user->id)
    //     ->where('status', 'berhasil')
    //     ->sum('amount');

    // $menunggu = Saldopencairan::where('mitra_id', $user->id)
    //     ->whereIn('status', ['pending', 'processing', 'menunggu'])
    //     ->sum('amount');

    // $saldoTersedia = $pendapatan - $sudahDicairkan - $menunggu;

    if ($request->amount > $saldoTersedia) {
        return back()->with('error', 'Saldo tidak mencukupi untuk melakukan pencairan.');
    }

    // Tentukan nama Bank/E-Wallet dengan benar
    $type = strtolower($user->withdraw_type ?? 'bank');
    if ($type == 'ewallet' || $type == 'e-wallet') {
        $namaTujuan = optional($user->ewallet)->nama_wallet ?? $user->bank_name ?? 'E-Wallet';
    } else {
        $namaTujuan = optional($user->bank)->nama_bank ?? $user->bank_name ?? 'Bank';
    }

    Saldopencairan::create([
        'mitra_id'       => $user->id,
        'bank_name'      => $namaTujuan,
        'bank_account'   => $user->withdraw_number ?? $user->bank_account ?? '-',
        'account_holder' => $user->withdraw_name ?? $user->account_holder ?? $user->name,
        'amount'         => $request->amount,
        'status'         => 'menunggu'
    ]);

    return back()->with('success', 'Pengajuan pencairan berhasil dikirim');
}

    public function notifikasi()
    {
        return view('mitra.notifikasi.notifikasi');
    }

    public function toggleStatus()
    {
        $user = Auth::user();

        $user->update([
            'is_online' => !$user->is_online
        ]);

        return back();
    }

    public function profile()
    {
        $banks = Bank::orderBy('nama_bank')->get();
        $ewallets = Ewallet::orderBy('nama')->get();

        return view('mitra.profile.profile', compact('banks', 'ewallets'));
    }

    public function schedule()
    {
        $orders = Order::with(['user', 'service'])
            ->where('mitra_id', Auth::id())
            ->orderBy('jadwal')
            ->orderBy('jam')
            ->get();

        return view('mitra.slots.index', compact('orders'));
    }
}