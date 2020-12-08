<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValuesGeneralRemarksToInstallationZoneReportsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_zone_reports', function (Blueprint $table) {
            $table->string('first_general_remarks')->nullable();
            $table->string('second_general_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installation_zone_reports', function (Blueprint $table) {
            $table->dropColumn('first_general_remarks');
            $table->dropColumn('second_general_remarks');
        });
    }
}
