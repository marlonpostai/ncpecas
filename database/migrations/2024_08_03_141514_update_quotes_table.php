<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (!Schema::hasColumn('quotes', 'product_service_id')) {
                $table->foreignId('product_service_id')->constrained('product_services')->after('quote_number');
            }
            if (!Schema::hasColumn('quotes', 'quantity')) {
                $table->integer('quantity')->default(1)->after('product_service_id');
            }
            if (!Schema::hasColumn('quotes', 'unit_price')) {
                $table->decimal('unit_price', 8, 2)->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (Schema::hasColumn('quotes', 'product_service_id')) {
                $table->dropColumn('product_service_id');
            }
            if (Schema::hasColumn('quotes', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('quotes', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
        });
    }
};
