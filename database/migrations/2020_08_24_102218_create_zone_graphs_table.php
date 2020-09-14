<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_graphs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_graph')->nullable();
            $table->foreign('id_graph')
                ->references('id')
                ->on('graphs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_zone')->nullable();
            $table->foreign('id_zone')
                ->references('id')
                ->on('zones')
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
        Schema::dropIfExists('zone_graphs');
    }
}
