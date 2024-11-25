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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('code')->unique();
            $table->unsignedBigInteger('status')->default(1)->nullable();
            $table->date('invoice_date');
            $table->float('total_amount', 8, 2)->default(0)->nullable();
            $table->float('sub_amount', 8,2)->default(0)->nullable();
            $table->float('discount', 8, 2)->default(0)->nullable();
            $table->float('grand_total', 8, 2)->default(0)->nullable();
            $table->float('paid_amount', 8, 2)->default(0)->nullable();
            $table->float('due_amount', 8, 2)->default(0)->nullable();
            $table->longText('note')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->time('created_time')->nullable();
            $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
