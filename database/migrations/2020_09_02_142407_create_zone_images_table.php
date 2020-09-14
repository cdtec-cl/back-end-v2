<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->unsignedBigInteger('id_zone')->unsigned();
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
        Schema::dropIfExists('zone_image');
    }
}
