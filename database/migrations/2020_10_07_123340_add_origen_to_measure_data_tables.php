<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrigenToMeasureDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measure_data', function (Blueprint $table) {
            $table->enum('origen', array('dia', 'historico'))->default('dia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measure_data', function (Blueprint $table) {
            $table->dropColumn('origen');
        });
    }
}
