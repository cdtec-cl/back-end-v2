<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdviserAndAgentValuesToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('adviser_name', 45)->nullable();
            $table->string('adviser_rut', 45)->nullable();
            $table->string('adviser_telefono', 45)->nullable();
            $table->string('agent_name', 45)->nullable();
            $table->string('agent_rut', 45)->nullable();
            $table->string('agent_telefono', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {            
            $table->dropColumn('adviser_name');
            $table->dropColumn('adviser_rut');
            $table->dropColumn('adviser_telefono');            
            $table->dropColumn('agent_name');
            $table->dropColumn('agent_rut');
            $table->dropColumn('agent_telefono');
        });
    }
}
