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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchases_id')->constrained('purchases');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('product_attribute_id')->constrained('product_attributes');
            $table->integer('qty')->default(0)->nullable();
            $table->float('purchase_rate')->default(0)->nullable();
            $table->float('sales_rate')->default(0)->nullable();
            $table->float('discount')->default(0)->nullable();
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
        Schema::dropIfExists('purchase_details');
    }
};
