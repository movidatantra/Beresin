<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\NotifikasiPelanggan;
use App\Models\Saldopencairan;
use App\Models\MitraBalance;



class OrderController extends Controller
{

    // =========================
    // LIST ORDER MITRA
    // =========================

    public function index()
    {

        $orders = Order::where('mitra_id', Auth::id())
                    ->latest()
                    ->get();

        return view('mitra.orders.index', compact('orders'));

    }

    // =========================
    // UPDATE STATUS
    // =========================

  public function updateStatus($id, $status)
{
    $statusValid = [
        'pending',
        'diterima',
        'ditolak',
        'menuju_lokasi',
        'dikerjakan',
        'menunggu_konfirmasi',
        'selesai',
        'dibatalkan'
    ];

    if (!in_array($status, $statusValid)) {
        abort(404);
    }

    $order = Order::with('slot')->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | STATUS MENUNGGU KONFIRMASI
    |--------------------------------------------------------------------------
    */

    if ($status == 'menunggu_konfirmasi') {

        $order->update([

            'status' => 'menunggu_konfirmasi',

            'customer_confirmation' => 'pending',

            'finished_at' => now()

        ]);

        NotifikasiPelanggan::create([

            'user_id' => $order->user_id,

            'order_id' => $order->id,

            'title' => 'Konfirmasi Penyelesaian',

            'message' => 'Mitra telah menyelesaikan pekerjaan. Silakan konfirmasi pekerjaan.',

            'type' => 'order',

            'is_read' => false

        ]);

    } else {

        $order->update([

            'status' => $status

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SLOT
    |--------------------------------------------------------------------------
    */

    if ($order->slot) {

        switch ($status) {

            case 'diterima':

                $order->slot->update([
                    'status' => 'disetujui'
                ]);

            break;

            case 'dibatalkan':

                $order->slot->update([
                    'status' => 'tersedia'
                ]);

            break;

            case 'menunggu_konfirmasi':

                $order->slot->update([
                    'status' => 'menunggu_konfirmasi'
                ]);

            break;

            case 'selesai':

                $order->slot->update([
                    'status' => 'selesai'
                ]);

            break;

        }

    }

    return back()->with(
        'success',
        'Status berhasil diperbarui.'
    );
}

// =========================
// RIWAYAT PEKERJAAN
// =========================

public function history()
{

    $orders = Order::where(

                    'mitra_id',

                    Auth::id()

                )

                ->where(

                    'status',

                    'selesai'

                )

                ->latest()

                ->get();

    return view(

        'mitra.orders.history',

        compact('orders')

    );

}
public function myOrders()
{
    $orders = Order::with([
        'items.service',
        'mitra',
        'payment'
    ])
    ->where('user_id', Auth::id())
    ->latest()
    ->get();

    return view(
        'pelanggan.orders',
        compact('orders')
    );
}
public function show($id)
{
    $order = Order::with([
        'items.service',
        'mitra',
        'payment',
         'review'
    ])
    ->where('user_id', auth()->id())
    ->findOrFail($id);

    $biayaLayanan = 10000;
    $subtotal = $order->total_price - $biayaLayanan;

    return view('pelanggan.orders.show', compact('order', 'biayaLayanan', 'subtotal'));
}
// public function confirmOrder($id)
// {
//     $order = Order::where(
//                 'user_id',
//                 auth()->id()
//             )
//             ->findOrFail($id);

//     if($order->status != 'menunggu_konfirmasi'){

//         return back()->with(
//             'error',
//             'Order belum bisa dikonfirmasi.'
//         );

//     }

//     $order->update([

//         'status' => 'selesai',

//         'customer_confirmation' => 'confirmed'

//     ]);

//     return back()->with(

//         'success',

//         'Terima kasih, pesanan telah selesai.'

//     );
// }

public function confirmOrder($id)
{
    $order = Order::where(
                'user_id',
                auth()->id()
            )
            ->findOrFail($id);

    if ($order->status != 'menunggu_konfirmasi') {

        return back()->with(
            'error',
            'Order belum bisa dikonfirmasi.'
        );

    }

    $order->update([

        'status' => 'selesai',

        'customer_confirmation' => 'confirmed'

    ]);

    // ======================
    // MASUKKAN SALDO KE MITRA
    // ======================

    $adminFee = 10000;

    $saldoMitra = $order->total_price - $adminFee;

    MitraBalance::firstOrCreate(

        [
            'order_id' => $order->id
        ],

        [
            'mitra_id' => $order->mitra_id,
            'amount'   => $saldoMitra,
            'type'     => 'income',
            'status'   => 'available'
        ]

    );

    return back()->with(

        'success',

        'Terima kasih, pesanan telah selesai.'

    );
}
public function complainOrder($id)
{
    $order = Order::where(
                'user_id',
                auth()->id()
            )
            ->findOrFail($id);

    if ($order->status != 'menunggu_konfirmasi') {

        return back()->with(
            'error',
            'Pesanan tidak dapat dikomplain.'
        );

    }

    $order->update([

        'status' => 'komplain',

        'customer_confirmation' => 'complain'

    ]);

    // Notifikasi untuk mitra
    NotifikasiMitra::create([

        'user_id'  => $order->mitra_id,

        'order_id' => $order->id,

        'title'    => 'Order Dikomplain',

        'message'  => 'Pelanggan mengajukan komplain atas pekerjaan yang telah diselesaikan.',

        'type'     => 'order',

        'is_read'  => false

    ]);

    // Notifikasi untuk admin
    NotifikasiAdmin::create([

        'order_id' => $order->id,

        'title'    => 'Komplain Baru',

        'message'  => 'Terdapat komplain baru yang perlu ditinjau.',

        'type'     => 'complain',

        'is_read'  => false

    ]);

    return back()->with(

        'success',

        'Komplain berhasil dikirim. Admin akan segera meninjau laporan Anda.'

    );
}

// 1. Menampilkan Form Upload (Hanya untuk status 'dikerjakan')
public function showWorkProof($id)
{
    $order = Order::where('mitra_id', auth()->id())->findOrFail($id);

    // Kalau status sudah lewat dari 'dikerjakan', arahkan ke halaman detail saja
    if ($order->status != 'dikerjakan') {
        return redirect()->route('orders.work-proof.detail', $order->id);
    }

    return view('mitra.orders.work-proof', compact('order'));
}

// 2. Menampilkan Halaman Detail Bukti (Untuk status menunggu_konfirmasi, selesai, komplain, dll)
public function workProofDetail($id)
{
    $order = Order::where('mitra_id', auth()->id())->findOrFail($id);

    return view('mitra.orders.work-proof-detail', compact('order'));
}

public function storeWorkProof(Request $request, $id)
{
    $request->validate([
        'work_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'work_video' => 'nullable|mimes:mp4,mov,avi|max:20480',
        'work_note'  => 'nullable|string|max:1000',
    ]);

    $order = Order::where('mitra_id', auth()->id())
        ->findOrFail($id);

    if ($order->status != 'dikerjakan') {
        return back()->with(
            'error',
            'Status order tidak valid.'
        );
    }

    // Upload Foto
    $photo = null;
    if ($request->hasFile('work_photo')) {
        $file = $request->file('work_photo');
        $photo = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/work-proof/photos'), $photo);
    }

    // Upload Video
    $video = null;
    if ($request->hasFile('work_video')) {
        $file = $request->file('work_video');
        $video = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/work-proof/videos'), $video);
    }

    // Update Order
    $order->update([
        'work_photo' => $photo,
        'work_video' => $video,
        'work_note' => $request->work_note,
        'status' => 'menunggu_konfirmasi',
        'customer_confirmation' => 'pending',
        'finished_at' => now()
    ]);

    // Notifikasi Pelanggan (Pastikan model NotifikasiPelanggan sudah di-import)
    NotifikasiPelanggan::create([
        'user_id' => $order->user_id,
        'order_id' => $order->id,
        'title' => 'Pekerjaan Selesai',
        'message' => 'Mitra telah mengunggah bukti pekerjaan. Silakan lakukan konfirmasi.',
        'type' => 'order',
        'is_read' => false
    ]);

    return redirect('/orders')->with(
        'success',
        'Bukti pekerjaan berhasil diupload.'
    );
}


}