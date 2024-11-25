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
        Schema::create('expenses_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('expenses_income_categories_id')->constrained('expenses_income_categories');
            $table->foreignId('expenses_income_heads_id')->constrained('expenses_income_heads');
            $table->string('type')->comment('1 = Income, 2 = Expenses');
            $table->date('date')->nullable();
            $table->foreignId('transaction_type_id')->constrained('transaction_types');
            $table->float('amount', 8, 2)->default(0)->nullable();
            $table->string('status')->nullable();
            $table->longText('note')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses_incomes');
    }
};
