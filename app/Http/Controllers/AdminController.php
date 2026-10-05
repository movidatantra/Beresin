<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Saldopencairan;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // MITRA

        $totalMitra = User::where(
                            'role',
                            'mitra'
                        )->count();

        $verifiedMitra = User::where(
                                'role',
                                'mitra'
                            )
                            ->where(
                                'verification_status',
                                'verified'
                            )
                            ->count();

        $pendingMitra = User::where(
                            'role',
                            'mitra'
                        )
                        ->where(
                            'verification_status',
                            'pending'
                        )
                        ->count();

        $rejectedMitra = User::where(
                            'role',
                            'mitra'
                        )
                        ->where(
                            'verification_status',
                            'rejected'
                        )
                        ->count();

        // PELANGGAN

        $totalPelanggan = User::where(
                                'role',
                                'pelanggan'
                            )
                            ->count();

        // ORDER

        $totalOrder = Order::count();

        // PENCAIRAN

        $pendingPencairan = Saldopencairan::where(
                                    'status',
                                    'menunggu'
                                )
                                ->count();

        $berhasilPencairan = Saldopencairan::where(
                                     'status',
                                     'berhasil'
                                 )
                                 ->count();

        // MITRA PENDING

        $mitraPendingList = User::where(
                                    'role',
                                    'mitra'
                                )
                                ->where(
                                    'verification_status',
                                    'pending'
                                )
                                ->latest()
                                ->take(5)
                                ->get();

                                // ===============================
// NOTIFIKASI ADMIN
// ===============================

$notifications = [];

// Mitra menunggu verifikasi
if ($pendingMitra > 0) {

    $notifications[] = [
        'icon' => 'bi-person-plus-fill',
        'color' => 'warning',
        'title' => 'Verifikasi Mitra',
        'message' => $pendingMitra . ' mitra menunggu verifikasi',
        'url' => url('/admin/mitra')
    ];
}

// Pencairan saldo
if ($pendingPencairan > 0) {

    $notifications[] = [
        'icon' => 'bi-wallet2',
        'color' => 'danger',
        'title' => 'Pencairan Saldo',
        'message' => $pendingPencairan . ' pencairan menunggu approval',
        'url' => url('/admin/withdrawals')
    ];
}

// Order baru hari ini
$orderHariIni = Order::whereDate('created_at', today())->count();

if ($orderHariIni > 0) {

    $notifications[] = [
        'icon' => 'bi-cart-fill',
        'color' => 'success',
        'title' => 'Order Baru',
        'message' => $orderHariIni . ' order baru hari ini',
        'url' => url('/admin/orders')
    ];
}

$jumlahNotifikasi = count($notifications);

       return view(
    'admin.dashboard',
    compact(
        'totalMitra',
        'verifiedMitra',
        'pendingMitra',
        'rejectedMitra',
        'totalPelanggan',
        'totalOrder',
        'pendingPencairan',
        'berhasilPencairan',
        'mitraPendingList',

        // Tambahan
        'notifications',
        'jumlahNotifikasi'
    )
);
    }

    public function mitraPending()
{
    $mitras = User::where('role','mitra')
                ->where('verification_status','pending')
                ->latest()
                ->paginate(10);

    return view(
        'admin.mitra.index',
        compact('mitras')
    );
}

public function detailMitra($id)
{
    $mitra = User::where('role','mitra')
                ->findOrFail($id);

    $services = Service::where(
                    'mitra_id',
                    $mitra->id
                )->get();

    return view(
        'admin.mitra.detail',
        compact(
            'mitra',
            'services'
        )
    );
}

    public function approveMitra($id)
{
    $mitra = User::findOrFail($id);

    $mitra->update([

        'verification_status' => 'verified'

    ]);

    return redirect()
            ->route('admin.mitra')
            ->with(
                'success',
                'Mitra berhasil diverifikasi.'
            );
}

    public function rejectMitra(Request $request,$id)
{
    $mitra = User::findOrFail($id);

    $mitra->update([

        'verification_status' => 'rejected'

    ]);

    return redirect()
            ->route('admin.mitra')
            ->with(
                'success',
                'Mitra berhasil ditolak.'
            );
}

    
}