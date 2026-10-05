<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->enum('withdraw_type', [
                'bank',
                'ewallet'
            ])->nullable();

            $table->unsignedBigInteger('bank_id')->nullable();

            $table->unsignedBigInteger('ewallet_id')->nullable();

            $table->string('withdraw_number')->nullable();

            $table->string('withdraw_name')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'withdraw_type',
                'bank_id',
                'ewallet_id',
                'withdraw_number',
                'withdraw_name'
            ]);

        });
    }
};