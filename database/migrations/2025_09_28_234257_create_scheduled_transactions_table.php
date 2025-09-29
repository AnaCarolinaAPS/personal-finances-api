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
        Schema::create('scheduled_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('due_date');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->foreignId('currency_id')->constrained('currencies')->restrictOnDelete(); // Erro ao apagar a moeda relacionada
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete(); // Erro ao apagar a categoria relacionada
            $table->foreignId('recurring_transaction_id')->nullable()->constrained('recurring_transactions')->nullOnDelete(); // Nulo caso a recurring_transactions for excluída
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_transactions');
    }
};
