<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiPelanggan;
use Illuminate\Http\Request;

class NotifikasiPelangganController extends Controller
{
    public function index()
    {
        $notifications = NotifikasiPelanggan::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(15);

        NotifikasiPelanggan::where(
            'user_id',
            auth()->id()
        )
        ->where('is_read',0)
        ->update([
            'is_read'=>1
        ]);

        return view(
            'pelanggan.notifications.index',
            compact('notifications')
        );
    }
}