<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadGenreTable extends Migration
{
    public function up()
    {
        Schema::create('upload_genre', function (Blueprint $table) {
            $table->unsignedBigInteger('upload_id');
            $table->unsignedBigInteger('genre_id');

            $table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');

            // Define a composite primary key
            $table->primary(['upload_id', 'genre_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_genre');
    }
}
