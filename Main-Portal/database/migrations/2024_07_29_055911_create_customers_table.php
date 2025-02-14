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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name');
            $table->string('contact');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('others_info')->nullable();
            $table->unsignedBigInteger('status')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
