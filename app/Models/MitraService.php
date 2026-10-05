<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraService extends Model
{
    protected $fillable = [
        'mitra_id',
        'service_id',
        'price',
        'duration',
        'status',
        'total_order'
    ];

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}