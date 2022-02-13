<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos_reparaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_trabajo');
            $table->unsignedBigInteger('id_reparacion');

            $table->primary(['id_trabajo', 'id_reparacion']);

            $table->foreign('id_trabajo')->references('id')->on('trabajos');
            $table->foreign('id_reparacion')->references('id')->on('reparaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos_reparaciones');
    }
}
