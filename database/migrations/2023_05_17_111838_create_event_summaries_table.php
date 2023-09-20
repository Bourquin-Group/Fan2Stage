<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_summaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->bigInteger('artist_id')->unsigned();
            $table->foreign('artist_id')->references('user_id')->on('artist_profiles')->onDelete('cascade');
            $table->string('actid1')->nullable();
            $table->string('actid2')->nullable();
            $table->string('actid3')->nullable();
            $table->string('actid4')->nullable();
            $table->string('actid5')->nullable();
            $table->string('actid6')->nullable();
            $table->string('onlinecount')->nullable();
            $table->string('actioncount')->nullable();
            $table->string('reviewedcount')->nullable();
            $table->string('ratedcount')->nullable();
            $table->string('ratings')->nullable();
            $table->string('tipstotal')->nullable();
            $table->timestamp('lasttiptime')->nullable();
            $table->bigInteger('lasttipfanid')->unsigned();
            $table->foreign('lasttipfanid')->references('id')->on('users')->onDelete('cascade');
            $table->string('lasttipamount')->nullable();
            $table->timestamp('eventstarttime')->nullable();
            $table->timestamp('eventendtime')->nullable();
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
        Schema::dropIfExists('event_summaries');
    }
}
