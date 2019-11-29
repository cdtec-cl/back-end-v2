<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealIrrigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_irrigations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('initTime', 45);
            $table->string('endTime', 45);
            $table->string('status', 45);
            $table->unsignedBigInteger('id_irrigation')->unsigned();
            $table->foreign('id_irrigation')
                ->references('id')
                ->on('irrigations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_farm')->unsigned();
            $table->foreign('id_farm')
                ->references('id')
                ->on('farms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_zone')->unsigned();
            $table->foreign('id_zone')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->unsignedBigInteger('id_pump_system')->unsigned();
            $table->foreign('id_pump_system')
                ->references('id')
                ->on('pump_systems')
                ->onDelete('cascade')
                ->onUpdate('cascade');                
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
        Schema::dropIfExists('real_irrigations');
    }
}
