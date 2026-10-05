<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraBalance extends Model
{
    protected $fillable = [

        'mitra_id',

        'order_id',

        'amount',

        'type',

        'status'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION MITRA
    |--------------------------------------------------------------------------
    */

    public function mitra()
    {
        return $this->belongsTo(
            User::class,
            'mitra_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION ORDER
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}