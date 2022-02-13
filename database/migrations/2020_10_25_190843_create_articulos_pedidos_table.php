<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_articulo');
            $table->unsignedBigInteger('id_pedido');
            $table->integer('cantidad');
            $table->double('precio');

            $table->primary(['id_articulo', 'id_pedido']);

            $table->foreign('id_articulo')->references('id')->on('articulos');
            $table->foreign('id_pedido')->references('id')->on('pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos_pedidos');
    }
}
