<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('downloads',function(Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('file_id')->nullable();
        $table->unsignedInteger('folder_id')->nullable();
        $table->unsignedInteger('user_id');
        $table->dateTime('timestamp');

        $table->foreign('file_id')->references('id')->on('files')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('folder_id')->references('id')->on('folders')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}
