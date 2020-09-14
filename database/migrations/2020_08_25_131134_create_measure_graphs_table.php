<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasureGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measure_graphs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('graph_type', array('line', 'bar'))->default('line');
            $table->unsignedBigInteger('id_measure')->nullable();
            $table->foreign('id_measure')
                ->references('id')
                ->on('measures')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_graph')->nullable();
            $table->foreign('id_graph')
                ->references('id')
                ->on('graphs')
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
        Schema::dropIfExists('measure_graphs');
    }
}
