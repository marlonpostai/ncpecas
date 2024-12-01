<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropQuoteItemsTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('quote_items');
    }

    public function down(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            // Defina a estrutura da tabela se desejar restaurá-la
        });
    }
}
