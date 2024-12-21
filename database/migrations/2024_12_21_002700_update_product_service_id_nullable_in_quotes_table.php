<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductServiceIdNullableInQuotesTable extends Migration
{
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->unsignedBigInteger('product_service_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->unsignedBigInteger('product_service_id')->nullable(false)->change();
        });
    }
}
