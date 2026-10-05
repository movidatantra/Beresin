<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // =========================
    // STORE REVIEW
    // =========================
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $order = Order::findOrFail($id);

        // Pastikan pesanan milik pelanggan yang login
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        // Hanya boleh review jika pesanan selesai
        if ($order->status != 'selesai') {
            return back()->with(
                'error',
                'Pesanan belum selesai sehingga belum dapat memberikan ulasan.'
            );
        }

        // Cek apakah sudah pernah review
        if (Review::where('order_id', $order->id)->exists()) {
            return back()->with(
                'error',
                'Anda sudah memberikan ulasan untuk pesanan ini.'
            );
        }

        Review::create([
            'user_id' => Auth::id(),
            'mitra_id' => $order->mitra_id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()
    ->route('pelanggan.orders.show', $order->id)
    ->with(
        'success',
        'Terima kasih, ulasan berhasil dikirim.'
    );
    }

    // =========================
    // LIST REVIEW MITRA
    // =========================
   public function index()
{
    $reviews = Review::with(['user', 'order'])
        ->where('mitra_id', Auth::id())
        ->latest()
        ->get();

    $averageRating = round($reviews->avg('rating') ?? 0, 1);

    $totalReview = $reviews->count();

    return view(
        'mitra.reviews.index',
        compact(
            'reviews',
            'averageRating',
            'totalReview'
        )
    );
}

 public function create($id)
{
    $order = Order::with('mitra', 'review')->findOrFail($id);

    if ($order->user_id != Auth::id()) {
        abort(403);
    }

    if ($order->status != 'selesai') {
        return redirect()
            ->route('pelanggan.orders.show', $order->id)
            ->with('error', 'Pesanan belum selesai.');
    }

    if ($order->review) {
        return redirect()
            ->route('pelanggan.orders.show', $order->id)
            ->with('info', 'Anda sudah memberikan ulasan.');
    }

    return view('pelanggan.review', compact('order'));
}
}