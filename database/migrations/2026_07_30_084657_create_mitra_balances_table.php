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
    Schema::create('mitra_balances', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('mitra_id');

        $table->unsignedBigInteger('order_id');

        $table->decimal('amount',12,2);

        $table->enum('type',[

            'income',

            'withdraw'

        ])->default('income');

        $table->enum('status',[

            'available',

            'withdrawn'

        ])->default('available');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_balances');
    }
};
