<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactcms', function (Blueprint $table) {
            $table->id();
            $table->longText('title1')->nullable();
            $table->longText('title2')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('location')->nullable();
            $table->longText('map')->nullable();
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
        Schema::dropIfExists('contactcms');
    }
}
