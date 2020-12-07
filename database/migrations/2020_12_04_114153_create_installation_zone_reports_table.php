<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationZoneReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_zone_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_zone')->unsigned();
            $table->foreign('id_zone')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('zone_name')->nullable();
            $table->string('farm_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_email')->nullable();
            $table->string('account_telefono')->nullable();
            $table->string('general_detail')->nullable();
            $table->string('species')->nullable();
            $table->string('variety')->nullable();
            $table->string('HA_surface')->nullable();
            $table->string('planting_year')->nullable();
            $table->string('soil_monitoring')->nullable();
            $table->string('irrigation_system')->nullable();
            $table->string('system_precipitation')->nullable();
            $table->string('distance_between_emitters')->nullable();
            $table->string('sector_plantation_frame')->nullable();
            $table->string('plant')->nullable();
            $table->string('plant_probe_distance')->nullable();
            $table->string('probe_dropper_distance')->nullable();
            $table->string('zone_plantation_frame')->nullable();
            $table->string('type_installation')->nullable();
            $table->string('general_remarks')->nullable();
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
        Schema::dropIfExists('installation_zone_reports');
    }
}
