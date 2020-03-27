<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->string('id', 27)->primary();
            $table->string('name');
            $table->string('address');
            $table->integer('reviews');
            $table->float('rating', 2, 1);
            $table->string('explicit_location')->nullable();
            $table->json('types')->nullable();
            $table->string('tel')->nullable();
            $table->string('website')->nullable();
            $table->string('consult_text');
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
        Schema::dropIfExists('places');
    }
}
