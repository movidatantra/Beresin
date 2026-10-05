<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Service;

return new class extends Migration
{
    public function up(): void
    {
        $services = Service::all();

        foreach ($services as $service) {

            DB::table('mitra_services')->insert([

                'mitra_id'     => $service->mitra_id,
                'service_id'   => $service->id,
                'price'        => $service->price,
                'duration'     => $service->duration,
                'status'       => $service->status,
                'total_order'  => $service->total_order,

                'created_at'   => now(),
                'updated_at'   => now(),

            ]);
        }
    }

    public function down(): void
    {
        DB::table('mitra_services')->truncate();
    }
};