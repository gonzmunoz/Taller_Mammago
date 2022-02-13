<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articulos_pedidos')->insert([
            'id_articulo' => 2,
            'id_pedido' => 1,
            'cantidad' => 1,
            'precio' => 114.79,
        ]);

        DB::table('articulos_pedidos')->insert([
            'id_articulo' => 1,
            'id_pedido' => 2,
            'cantidad' => 2,
            'precio' => 114.79,
        ]);

        DB::table('articulos_pedidos')->insert([
            'id_articulo' => 3,
            'id_pedido' => 2,
            'cantidad' => 1,
            'precio' => 38.88,
        ]);

        DB::table('articulos_pedidos')->insert([
            'id_articulo' => 5,
            'id_pedido' => 3,
            'cantidad' => 1,
            'precio' => 30.00,
        ]);

    }
}
