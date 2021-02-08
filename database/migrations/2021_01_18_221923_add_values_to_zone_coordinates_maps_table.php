<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValuesToZoneCoordinatesMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zone_coordinates_maps', function (Blueprint $table) {
            $table->string('bookmark_name')->nullable();
            $table->unsignedBigInteger('id_farm_google_maps_file')->unsigned();
            $table->foreign('id_farm_google_maps_file')
                ->references('id')
                ->on('farm_google_maps_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zone_coordinates_maps', function (Blueprint $table) {
            //
        });
    }
}
