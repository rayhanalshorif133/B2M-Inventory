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
        Schema::create('payment_executes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->unsignedBigInteger('payment_create_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('keyword')->nullable();
            $table->date('date')->default(today());
            $table->string('user_msisdn')->nullable();
            $table->string('bkash_msisdn')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('trxID')->nullable();
            $table->string('transaction_status')->default('pending');
            $table->string('error_code')->default('00');
            $table->string('error_message')->default('pending');
            $table->json('response')->nullable();
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
        Schema::dropIfExists('payment_executes');
    }
};
