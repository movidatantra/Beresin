<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('mitra_services', function (Blueprint $table) {

        $table->id();

        $table->foreignId('mitra_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->foreignId('service_id')
            ->constrained('services')
            ->cascadeOnDelete();

        $table->integer('price');

        $table->string('duration');

        $table->integer('total_order')->default(0);

        $table->enum('status', [
            'aktif',
            'nonaktif'
        ])->default('aktif');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_services');
    }
};
