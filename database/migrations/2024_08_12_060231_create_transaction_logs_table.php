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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_type_id')->constrained('transaction_types');
            $table->float('amount')->default(0)->nullable();
            $table->bigInteger('type')->comment('1 for Purchase Payment,
            2 for Purchase Payment Return,
            3 for Sales Payment,  4 for Sales Payment Return');
            $table->date('opt_date')->now();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
