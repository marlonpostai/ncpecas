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
             $table->decimal('item_discount_percent', 5, 2)->nullable()->after('apply_discount');
         });
     }

     public function down()
     {
         Schema::table('quote_items', function (Blueprint $table) {
             $table->dropColumn('item_discount_percent');
         });
     }

};
