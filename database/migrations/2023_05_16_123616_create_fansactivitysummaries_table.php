<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFansactivitysummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fansactivitysummaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->bigInteger('artist_id')->unsigned();
            $table->foreign('artist_id')->references('user_id')->on('artist_profiles')->onDelete('cascade');
            $table->timestamp('activitytime')->nullable();
            $table->string('actid1')->nullable();
            $table->string('actid2')->nullable();
            $table->string('actid3')->nullable();
            $table->string('actid4')->nullable();
            $table->string('actid5')->nullable();
            $table->string('actid6')->nullable();
            $table->tinyInteger('activitystatus')->default(0)->comment('0-in active,1-active');
            $table->timestamp('lastsumtime')->nullable();
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
        Schema::dropIfExists('fansactivitysummaries');
    }
}
