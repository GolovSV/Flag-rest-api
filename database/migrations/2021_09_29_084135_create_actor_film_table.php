<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('film_id');
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->foreign('film_id')->references('id')->on('films');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_film');
    }
}
