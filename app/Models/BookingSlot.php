<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    protected $fillable = [

        'mitra_id',
        'tanggal',
        'jam',
        'duration',
        'status'

    ];

    public function mitra()
    {
        return $this->belongsTo(
            User::class,
            'mitra_id'
        );
    }
    public function orders()
{
    return $this->hasMany(
        Order::class,
        'slot_id'
    );
}
}