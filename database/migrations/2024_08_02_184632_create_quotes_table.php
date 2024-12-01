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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique(); // Número do orçamento (único)
            $table->date('creation_date'); // Data de criação do orçamento
            $table->bigInteger('client_id')->index(); // FK para a tabela clients
            $table->bigInteger('user_id')->index(); // FK para a tabela users
            $table->decimal('total_amount', 10, 2); // Valor total do orçamento
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
