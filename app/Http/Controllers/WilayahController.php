<?php

namespace App\Http\Controllers;


use App\Models\Kabupaten;
use App\Models\Kecamatan;

class WilayahController extends Controller
{
    public function getKabupaten($kd_prov)
    {
        return Kabupaten::where(
            'kd_prov',
            $kd_prov
        )
        ->orderBy('nama_kab')
        ->get();
    }

    public function getKecamatan($kd_kab)
    {
        return Kecamatan::where(
            'kd_kab',
            $kd_kab
        )
        ->orderBy('nama_kec')
        ->get();
    }
}