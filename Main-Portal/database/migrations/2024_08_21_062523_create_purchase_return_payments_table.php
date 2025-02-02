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
        Schema::create('purchase_return_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_return_id')->nullable();
            $table->foreignId('transaction_type_id')->constrained('transaction_types');
            $table->foreignId('company_id')->constrained('companies');
            $table->double('amount', 8, 2)->default(0)->nullable();
            $table->string('receipt_no')->default(0)->nullable()->unique();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('added_by')->constrained('users');
            $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return_payments');
    }
};
