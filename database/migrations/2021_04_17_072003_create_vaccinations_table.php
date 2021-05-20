<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->integer('max_persons');
            $table->dateTime('date_time')->default("2021-05-12 12:00:00");
            $table->timestamps();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            //Zweite Möglichkeit
            //$table->bigInteger('location_id')->unsigned();
            //$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccinations');
    }
}
