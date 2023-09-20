<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_files', function (Blueprint $table) {
            $table->id();
            $table->string('action_name')->nullable();
            $table->string('action_desc')->nullable();
            $table->string('action_file')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('action_status')->default(0)->comment('0-in active,1-active');
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
        Schema::dropIfExists('action_files');
    }
}
