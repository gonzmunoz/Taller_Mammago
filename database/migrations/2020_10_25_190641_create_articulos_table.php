<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_motor');
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->double('precio');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('stock');
            $table->string('imagen');
            $table->boolean('visible');

            $table->foreign('id_motor')->references('id')->on('motorizaciones_coche');
            $table->foreign('id_categoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
