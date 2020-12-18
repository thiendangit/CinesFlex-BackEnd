<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('movie_id');
            $table->string('description')->nullable();
            $table->string('director')->nullable();
            $table->integer('duration_min');
            $table->dateTime('date_begin')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->integer('rated')->nullable();
            $table->string('trailer_path')->nullable();
            $table->integer('price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_details');
    }
}
