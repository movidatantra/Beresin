<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'tm_provinsi';

    protected $primaryKey = 'kd_prov';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
