<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToProductServices extends Migration
{
    public function up(): void
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->string('image_one')->nullable();
            $table->string('image_two')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_services', function (Blueprint $table) {
            $table->dropColumn(['image_one', 'image_two']);
        });
    }
}
