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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            // Identificação
            $table->string('code', 3)->unique();    // ISO 4217 (ex.: "BRL", "USD", "EUR")
            $table->string('name');                 // Nome descritivo (ex.: Real Brasileiro, Dólar Americano)
            $table->string('symbol', 5);            // Símbolo (ex.: R$, $, €)
            // Formatação
            $table->string('decimal_separator', 1)->default('.');   // Separador decimal (. ou ,)
            $table->string('thousand_separator', 1)->default(',');  // Separador de milhar (, ou . ou espaço)
            $table->unsignedTinyInteger('decimal_places')->default(2); // Casas decimais (ex.: 2 para BRL/USD, 0 para JPY)
            // Configurações extras
            $table->boolean('is_active')->default(true); // Se a moeda está habilitada no sistema
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
