<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleRepair extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articulos_reparaciones')->insert([
            'id_reparacion' => 1,
            'id_articulo' => 12,
            'cantidad' => 1,
            'precio' => 31.00,
        ]);

        DB::table('articulos_reparaciones')->insert([
            'id_reparacion' => 1,
            'id_articulo' => 7,
            'cantidad' => 1,
            'precio' => 24.33,
        ]);

        DB::table('articulos_reparaciones')->insert([
            'id_reparacion' => 2,
            'id_articulo' => 11,
            'cantidad' => 2,
            'precio' => 24.67,
        ]);
    }
}
