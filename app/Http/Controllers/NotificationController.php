<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Tandai semua notifikasi sudah dibaca
    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update([
                'is_read' => 1
            ]);

        return response()->json([
            'success' => true
        ]);
    }
}