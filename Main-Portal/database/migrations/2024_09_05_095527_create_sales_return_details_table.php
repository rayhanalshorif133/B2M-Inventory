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
        Schema::create('sales_return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_returns_id')->constrained('sales_returns');
            $table->foreignId('sales_details_id')->constrained('sales_details');
            $table->foreignId('product_attribute_id')->constrained('product_attributes');
            $table->integer('return_qty')->default(0)->nullable();
            $table->float('discount', 8, 2)->default(0)->nullable();
            $table->float('sales_rate')->default(0)->nullable();
            $table->float('total')->default(0)->nullable();
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
        Schema::dropIfExists('sales_return_details');
    }
};
