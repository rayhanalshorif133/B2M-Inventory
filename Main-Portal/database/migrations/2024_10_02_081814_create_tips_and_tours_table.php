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
        Schema::create('tips_and_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Track the user
            $table->foreignId('company_id')->constrained('companies');
            $table->boolean('is_viewed')->default(false); // Track if the tip has been viewed
            $table->boolean('is_skipped')->default(false); // Track if the tip has been skipped
            $table->boolean('is_favorite')->default(false); // Mark as favorite
            $table->timestamp('first_viewed_at')->nullable(); // When the user first viewed this tip
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips_and_tours');
    }
};
