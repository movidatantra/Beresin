<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('saldopencairan', function (Blueprint $table) {

        $table->enum('withdraw_type',[
            'bank',
            'ewallet'
        ])->default('bank');

        $table->unsignedBigInteger('bank_id')->nullable();

        $table->unsignedBigInteger('ewallet_id')->nullable();

        $table->string('account_number')->nullable();

    });
}
};
