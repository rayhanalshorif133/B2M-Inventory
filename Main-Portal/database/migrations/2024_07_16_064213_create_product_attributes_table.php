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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('product_id')->constrained('products');
            $table->string('code');
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->string('current_stock')->nullable();
            $table->string('last_purchase')->nullable();
            $table->string('sales_rate')->nullable();
            $table->string('unit_cost')->nullable();
            $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
