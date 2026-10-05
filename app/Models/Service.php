<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MitraService;

class Service extends Model
{

    protected $fillable = [

        'mitra_id',
        'name',
        'category',
        'price',
        'description',
        'duration',
        'image',
        'status'

    ];

    public function mitra()
{
    return $this->belongsTo(
        User::class,
        'mitra_id'
    );
}
public function mitraServices()
{
    return $this->hasMany(MitraService::class);
}


}