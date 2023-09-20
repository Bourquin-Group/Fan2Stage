<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->bigInteger('favourite_id')->unsigned()->nullable();
            $table->foreign('favourite_id')->references('id')->on('favourites')->onDelete('cascade');
            $table->bigInteger('event_booking_id')->unsigned()->nullable();
            $table->foreign('event_booking_id')->references('id')->on('eventbookings')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('type')->comment('0-Receive notifications, 1- Favourite Events, 2- Event Remainder, 3-Event Cancelation, 4-Event Booking Cancel Confirmation')->default('0');  
            $table->tinyInteger('status')->comment('0- not send, 1- send')->default(0);
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
        Schema::dropIfExists('notification');
    }
}
