<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;
use App\Models\BookingSlot;

class Order extends Model
{

   protected $fillable = [

    'invoice_number',

    'user_id',

    'mitra_id',

    'service_id',

    'total_price',

    'slot_id',

    'jadwal',

    'jam',

    'address',

    'note',

    'status',

    'payment_status',

    'payment_method',

    'payment_proof',

    'subtotal',

    'service_fee',

    'customer_confirmation',

    'finished_at',
    'work_photo', // Pastikan ini ada
    'work_video', // Pastikan ini ada
    'work_note',

];

    /*
    |--------------------------------------------------------------------------
    | RELATION USER
    |--------------------------------------------------------------------------
    */

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    /*
    |--------------------------------------------------------------------------
    | RELATION SERVICE
    |--------------------------------------------------------------------------
    */

    

public function user()
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}

public function mitra()
{
    return $this->belongsTo(
        User::class,
        'mitra_id'
    );
}


public function slot()
{
    return $this->belongsTo(
        BookingSlot::class,
        'slot_id'
    );
}
public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function service()
{
    return $this->belongsTo(Service::class);
}



public function customer()
{
    return $this->belongsTo(User::class,'user_id');
}
public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function payment()
{
    return $this->hasOne(Payment::class);
}
public function review()
{
    return $this->hasOne(Review::class);
}
public function complaint()
{
    return $this->hasOne(Complaint::class);
}
public function balance()
{
    return $this->hasOne(MitraBalance::class);
}
public function refund()
{
    return $this->hasOne(Refund::class);
}




}