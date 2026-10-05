<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('services', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mitra_id');

            $table->string('name');

            $table->string('category');

            $table->integer('price');

            $table->text('description');

            $table->string('duration');

            $table->string('image')->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};