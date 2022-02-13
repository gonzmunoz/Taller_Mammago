<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pedidos')->insert([
            'id_usuario' => 5,
            'fecha' => '2021-02-19 13:49:59',
        ]);

        DB::table('pedidos')->insert([
            'id_usuario' => 5,
            'fecha' => '2021-02-21 11:08:44',
        ]);

        DB::table('pedidos')->insert([
            'id_usuario' => 4,
            'fecha' => '2021-02-22 11:11:33',
        ]);
    }
}
