<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurfaceZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->string('surface')->nullable();
            $table->string('species')->nullable();
            $table->string('variety')->nullable();
            $table->string('plantation_year')->nullable();
            $table->string('emitter_flow')->nullable();
            $table->string('distance_between_emitters')->nullable();
            $table->string('plantation_frame')->nullable();
            $table->string('probe_type')->nullable();
            $table->string('type_irrigation')->nullable();
            $table->string('weather')->nullable();
            $table->string('soil_type')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
