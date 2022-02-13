<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_coche');
            $table->unsignedBigInteger('id_cita');
            $table->enum('estado', ['En proceso', 'Completada']);
            $table->dateTime('fecha_fin')->nullable();
            $table->boolean('pagada');

            $table->foreign('id_coche')->references('id')->on('coches');
            $table->foreign('id_cita')->references('id')->on('citas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparaciones');
    }
}
