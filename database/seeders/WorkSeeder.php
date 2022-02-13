<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trabajos')->insert([
            'descripcion' => 'Cambio de aceite y filtro',
            'tiempo_empleado' => 0.5,
        ]);

        DB::table('trabajos')->insert([
            'descripcion' => 'Cambio de numáticos delanteros',
            'tiempo_empleado' => 1.5,
        ]);
    }
}
