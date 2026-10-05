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
       Schema::create('saldopencairan', function (Blueprint $table)  {

    $table->id();

    $table->foreignId('mitra_id');

    $table->decimal(
        'amount',
        12,
        2
    );

    $table->string('bank_name');

    $table->string('bank_account');

    $table->string('account_holder');

    $table->enum('status',[

        'menunggu',
        'berhasil',
        'ditolak'

    ])->default('menunggu');

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldopencairan');
    }
};
