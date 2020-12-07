<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementZoneReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_zone_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_zone')->unsigned();
            $table->foreign('id_zone')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('farm_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_email')->nullable();
            $table->string('account_telefono')->nullable();
            $table->string('poscosecha_2019')->nullable();
            $table->string('caida_de_hoja')->nullable();
            $table->string('brotacion')->nullable();
            $table->string('cuaja')->nullable();
            $table->string('maduracion')->nullable();
            $table->string('tecnica_y_administracion')->nullable();
            $table->string('first_general_remarks')->nullable();
            $table->string('graph1_url')->nullable();
            $table->string('second_general_remarks')->nullable();
            $table->string('kc_sonda')->nullable();
            $table->string('huella_agua')->nullable();
            $table->string('tecnica_administracion')->nullable();
            $table->string('estacion_de_clima')->nullable();
            $table->string('equipo_de_riego')->nullable();
            $table->string('raices')->nullable();
            $table->string('third_general_remarks')->nullable();
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
        Schema::dropIfExists('management_zone_reports');
    }
}
