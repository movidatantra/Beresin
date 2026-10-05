<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiPelanggan extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_pelanggans';

    protected $fillable = [

        'user_id',

        'order_id',

        'title',

        'message',

        'type',

        'is_read'

    ];

    protected $casts = [

        'is_read' => 'boolean',

    ];

    /**
     * Relasi ke pelanggan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}