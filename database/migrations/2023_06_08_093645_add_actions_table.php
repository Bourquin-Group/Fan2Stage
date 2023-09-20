<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_files', function (Blueprint $table) {
            $table->string('fromcount')->after('audio_file')->nullable();
            $table->string('tocount')->after('fromcount')->nullable();
            $table->string('factcount')->after('tocount')->nullable();
            $table->string('tactcount')->after('factcount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_files', function (Blueprint $table) {
            //
        });
    }
}
