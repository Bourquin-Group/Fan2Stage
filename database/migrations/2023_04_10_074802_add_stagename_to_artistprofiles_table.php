<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStagenameToArtistprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artist_profiles', function (Blueprint $table) {
            $table->string('country_code')->after('genre')->nullable();
            $table->string('d_stagename')->after('country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artist_profiles', function (Blueprint $table) {
            //
        });
    }
}
