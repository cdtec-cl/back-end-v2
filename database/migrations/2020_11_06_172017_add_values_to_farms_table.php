<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValuesToFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->float('total_area')->nullable();//superficie total
            $table->integer('amount_equipment_irrigation')->default(0);//Cantidad de equipos de Riego
            $table->integer('number_sectors_irrigation')->default(0);//Cantidad de sectores de Riego
            $table->integer('quantity_wells')->default(0);//cantidad de pozos
            $table->dateTime('start_installation')->nullable();//inicio de instalacion
            $table->dateTime('end_installation')->nullable();//fin de instalacion
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn('total_area');
            $table->dropColumn('amount_equipment_irrigation');
            $table->dropColumn('number_sectors_irrigation');
            $table->dropColumn('quantity_wells');
            $table->dropColumn('start_installation');
            $table->dropColumn('end_installation');
        });
    }
}
