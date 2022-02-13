<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reparaciones')->insert([
            'id_coche' => 1,
            'id_cita' => 1,
            'estado' => 'Completada',
            'fecha_fin' => '2021-03-12 12:24:42',
            'pagada' => true,
        ]);

        DB::table('reparaciones')->insert([
            'id_coche' => 3,
            'id_cita' => 2,
            'estado' => 'Completada',
            'fecha_fin' => '2021-03-10 12:24:42',
            'pagada' => true,
        ]);

        DB::table('reparaciones')->insert([
            'id_coche' => 3,
            'id_cita' => 4,
            'estado' => 'En Proceso',
            'fecha_fin' => null,
            'pagada' => false,
        ]);


    }
}
