<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentstatus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('fanpayment')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('payment_status')->comment('0- failure, 1- success')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->comment('0- not send, 1- send')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paymentstatus');
    }
}
