<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [

        'user_id',
        'service_id',
        'qty'

    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}