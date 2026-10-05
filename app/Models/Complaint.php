<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [

        'complaint_number',

        'order_id',

        'user_id',

        'mitra_id',

        'category',

        'subject',

        'complaint',

        'photo',

        'video',

        'admin_response',

        'mitra_response',

        'status',

        'resolved_at',
        'refund_type',

'bank_id',

'ewallet_id',

'account_number',

'account_holder',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION ORDER
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

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


public function user()
{
    return $this->belongsTo(User::class);
}
public function bank()
{
    return $this->belongsTo(
        Bank::class,
        'bank_id'
    );
}

public function ewallet()
{
    return $this->belongsTo(
        Ewallet::class,
        'ewallet_id'
    );
}
public function refund()
{
    return $this->hasOne(Refund::class);
}



}