<?php

namespace App\Http\Controllers;


use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart; // Sesuaikan dengan model Cart Anda

class CartController extends Controller
{
    // =====================
    // TAMBAH KE KERANJANG
    // =====================

    public function add($id)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('service_id', $id)
                ->first();

    if ($cart) {

        $cart->increment('qty');

    } else {

        Cart::create([

            'user_id' => Auth::id(),

            'service_id' => $id,

            'qty' => 1

        ]);
    }

    return response()->json([
        'success' => true
    ]);
}

public function decrease($id)
{
    $cart = Cart::where('user_id', Auth::id())
                ->where('service_id', $id)
                ->first();

    if ($cart) {

        if ($cart->qty > 1) {

            $cart->decrement('qty');

        } else {

            $cart->delete();

        }
    }

    return response()->json([
        'success' => true
    ]);
}

    // =====================
    // HALAMAN KERANJANG
    // =====================

    public function index()
    {
        $carts = Cart::with('service')

                    ->where(
                        'user_id',
                        Auth::id()
                    )

                    ->get();

        $total = 0;

        foreach($carts as $cart)
        {
            $total +=
                $cart->service->price
                *
                $cart->qty;
        }

        return view(
            'pelanggan.cart',
            compact(
                'carts',
                'total'
            )
        );
    }

    // =====================
    // HAPUS ITEM
    // =====================

    public function delete($id)
    {
        Cart::findOrFail($id)
            ->delete();

        return back();
    }

    public function updateQty(Request $request)
{
    // Cari item keranjang berdasarkan ID yang dikirim AJAX
    $cart = Cart::find($request->id);

    if (!$cart) {
        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan.'
        ], 404);
    }

    // Cek aksi dari tombol (+ atau -)
    if ($request->action === 'increment') {
        $cart->qty += 1;
    } elseif ($request->action === 'decrement') {
        if ($cart->qty > 1) {
            $cart->qty -= 1;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah minimal adalah 1.'
            ]);
        }
    }

    $cart->save();

    // Kembalikan respons sukses ke AJAX berupa jumlah (quantity) terbaru
    return response()->json([
        'success' => true,
        'new_qty' => $cart->qty
    ]);
}
}