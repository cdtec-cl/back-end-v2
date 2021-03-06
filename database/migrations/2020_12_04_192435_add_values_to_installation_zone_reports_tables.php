<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValuesToInstallationZoneReportsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_zone_reports', function (Blueprint $table) {
            $table->string('download_url')->nullable(); //superficie
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
            $table->dropColumn('download_url');
        });
    }
}
