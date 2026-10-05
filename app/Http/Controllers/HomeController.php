<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $mitras = User::where(
                    'role',
                    'mitra'
                  )->get();

        $totalMitra = User::where(
                        'role',
                        'mitra'
                      )->count();

        $totalOrder = Order::where(
                        'status',
                        'selesai'
                      )->count();

        $averageRating = Review::avg('rating') ?? 0;

        return view(
            'welcome',
            compact(
                'mitras',
                'totalMitra',
                'totalOrder',
                'averageRating'
            )
        );
    }
}