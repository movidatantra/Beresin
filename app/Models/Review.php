<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=[
        'order_id',
        'user_id',
        'mitra_id',
        'rating',
        'review'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(User::class,'mitra_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}



}