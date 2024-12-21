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
         Schema::table('quote_items', function (Blueprint $table) {
             $table->boolean('apply_discount')->default(false)->after('total_price');
         });
     }

     public function down()
     {
         Schema::table('quote_items', function (Blueprint $table) {
             $table->dropColumn('apply_discount');
         });
     }

};
