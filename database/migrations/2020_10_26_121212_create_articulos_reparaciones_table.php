<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_reparaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_reparacion');
            $table->unsignedBigInteger('id_articulo');
            $table->integer('cantidad');
            $table->double('precio');

            $table->primary(['id_reparacion', 'id_articulo']);

            $table->foreign('id_reparacion')->references('id')->on('reparaciones');
            $table->foreign('id_articulo')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repuestos_coche');
    }
}
