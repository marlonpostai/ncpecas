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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quote_id')->index(); // FK para a tabela quotes
            $table->bigInteger('product_service_id')->index(); // FK para a tabela products_services
            $table->integer('quantity'); // Quantidade do item
            $table->bigInteger('unit_price')->index(); // Preço unitário do item
            $table->decimal('subtotal', 10, 2); // Subtotal do item (quantidade x preço unitário)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
