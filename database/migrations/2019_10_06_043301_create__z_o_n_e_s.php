<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZONES extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('latitude');
            $table->integer('longitude');
            /*  "farmId": 0,
                "pumpSystemId": 0, */
            $table->integer('kc');
            $table->integer('theorical_flow');

            $table->string('unit_theoretical_flow');
            $table->integer('efficiency');
            $table->integer('humidity_retention');
            $table->integer('max');
            $table->integer('min');
            $table->integer('critical_point1');
            $table->integer('critical_point2');

            $table->timestamps();

            $table->integer('type_zone_id')->unsigned()->index();
            $table->foreign('type_zone_id')->references('id')->on('type_zones');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
}
