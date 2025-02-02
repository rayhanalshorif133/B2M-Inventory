<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('payment_creates', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('payment_id')->nullable();
            $table->string('user_msisdn');
            $table->string('bkash_msisdn')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->date('date')->default(today());
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->string('keyword');
            $table->json('response')->nullable();
            $table->string('status')->default('pending');
            $table->longText('token');
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
        Schema::dropIfExists('payment_creates');
    }
};
