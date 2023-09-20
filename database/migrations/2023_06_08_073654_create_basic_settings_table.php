<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('funid')->nullable();
            $table->string('funcode')->nullable();
            $table->string('funname')->nullable();
            $table->string('fundesc')->nullable();
            $table->string('funval1')->nullable();
            $table->string('funval2')->nullable();
            $table->string('funval3')->nullable();
            $table->tinyInteger('funlogin')->default(0)->comment('0-backend,1-frontend');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('funstatus')->default(0)->comment('0-in active,1-active');
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
        Schema::dropIfExists('basic_settings');
    }
}
