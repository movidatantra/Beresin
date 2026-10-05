<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();

            $table->string('holiday')->nullable();

            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();

            $table->boolean('service_warranty')
                  ->default(false);

            $table->string('business_photo')
                  ->nullable();

            $table->json('portfolio_photos')
                  ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'open_time',
                'close_time',
                'holiday',

                'instagram_url',
                'facebook_url',
                'tiktok_url',

                'service_warranty',

                'business_photo',
                'portfolio_photos',
            ]);

        });
    }
};