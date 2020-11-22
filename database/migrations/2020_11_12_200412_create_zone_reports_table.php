<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_zone')->unsigned();
            $table->foreign('id_zone')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('probe_name'); //nombre de sonda
            $table->string('surface'); //superficie
            $table->string('species'); //especie
            $table->string('variety'); //variedad
            $table->string('planting_year'); //año de platacion
            $table->string('emitter_flow'); //caudal del emisor
            $table->string('distance_between_emitters'); //distancia entre emisores
            $table->string('plantation_frame'); //marco de plantacion
            $table->string('probe_type'); //tipo de sondan
            $table->string('type_irrigation'); //tipo de riego
            $table->string('weather'); //clima
            $table->string('soil_type'); //tipo de suelo
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
        Schema::dropIfExists('zone_reports');
    }
}
