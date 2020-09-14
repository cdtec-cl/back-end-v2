<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstallationInformationToZonesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->dateTime('installation_date')->nullable();
            $table->string('number_roots')->nullable();
            $table->string('plant')->nullable();
            $table->string('probe_plant_distance')->nullable();
            $table->string('sprinkler_probe_distance')->nullable();
            $table->string('installation_type')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->dropColumn('installation_date');
            $table->dropColumn('number_roots');
            $table->dropColumn('plant');
            $table->dropColumn('probe_plant_distance');
            $table->dropColumn('sprinkler_probe_distance');
            $table->dropColumn('installation_type');
        });
    }
}
