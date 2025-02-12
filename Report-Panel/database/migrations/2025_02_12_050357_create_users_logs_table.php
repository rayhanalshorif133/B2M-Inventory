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
        Schema::create('users_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('msisdn', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->date('created_date')->nullable();
            $table->time('created_time')->nullable();
            $table->date('last_login_date')->nullable();
            $table->time('last_login_time')->nullable();
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
        Schema::dropIfExists('users_logs');
    }
};
