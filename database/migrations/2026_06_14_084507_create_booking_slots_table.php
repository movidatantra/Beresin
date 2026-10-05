<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_slots', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mitra_id');

            $table->date('tanggal');

            $table->time('jam');

            $table->enum('status', [

                'tersedia',
                'dipesan',
                'disetujui',
                'selesai'

            ])->default('tersedia');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_slots');
    }
};