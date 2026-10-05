<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class WorkProofController extends Controller
{
    // Form upload bukti
    public function create($id)
    {
        $order = Order::where('mitra_id', auth()->id())
            ->findOrFail($id);

        if ($order->status != 'dikerjakan') {
            return back()->with('error', 'Order belum dapat diupload bukti.');
        }

        return view('mitra.orders.work-proof', compact('order'));
    }

    // Detail bukti
    public function show($id)
    {
        $order = Order::where('mitra_id', auth()->id())
            ->findOrFail($id);

        return view('mitra.orders.work-proof-detail', compact('order'));
    }

    // Simpan bukti
    public function store(Request $request, $id)
    {
        // nanti kita isi
    }
}