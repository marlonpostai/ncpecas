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
         Schema::table('quotes', function (Blueprint $table) {
             $table->date('expected_payment_date')->nullable();
         });
     }

     public function down()
     {
         Schema::table('quotes', function (Blueprint $table) {
             $table->dropColumn('expected_payment_date');
         });
     }

};
