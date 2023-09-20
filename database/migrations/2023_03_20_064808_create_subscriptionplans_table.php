<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptionplans', function (Blueprint $table) {
            $table->id();
            $table->string('f2s_plan')->nullable();
            $table->string('fans_per_event')->nullable();
            $table->string('events_per_month')->nullable();
            $table->string('push_notification')->nullable();
            $table->string('favorite_link')->nullable();
            $table->string('cost')->nullable();
            $table->string('cost_value')->nullable();
            $table->string('anual_plan')->nullable();
            $table->string('hardware_required')->nullable();
            $table->boolean('status')->default(0)->comment('1 - Active, 0 - Deactive');
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
        Schema::dropIfExists('subscriptionplans');
    }
}
