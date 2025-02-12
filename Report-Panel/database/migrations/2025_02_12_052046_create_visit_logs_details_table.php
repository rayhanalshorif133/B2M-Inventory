<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_logs_details', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 45)->nullable();
            $table->string('page_name', 2083)->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->string('duration', 255)->nullable();
            $table->string('page_url', 2083)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_logs_details');
    }
};
