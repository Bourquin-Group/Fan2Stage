<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('subscriptionplans_id')->unsigned();
            $table->foreign('subscriptionplans_id')->references('id')->on('subscriptionplans')->onDelete('cascade');
            $table->timestamp('payment_date')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0-tips,1-plan');
            $table->tinyInteger('payment_status')->default(0)->comment('0-failed,1-success');
            $table->double('amount')->default(0.00);
            $table->double('total')->default(0.00);
            $table->string('fans_per_event')->nullable();
            $table->string('events_per_month')->nullable();
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_charge_id')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
