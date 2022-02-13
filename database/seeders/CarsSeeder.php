<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coches')->insert([
            'id_cliente' => 6,
            'id_motor' => 22,
            'anio' => 2003,
            'matricula' => '1234ABC',
            'bastidor' => 'ABFGFSD45SDRFTFFG',
        ]);

        DB::table('coches')->insert([
            'id_cliente' => 6,
            'id_motor' => 8,
            'anio' => 2008,
            'matricula' => '5678ABC',
            'bastidor' => 'CGFG32D45SDRFTFFG',
        ]);

        DB::table('coches')->insert([
            'id_cliente' => 10,
            'id_motor' => 38,
            'anio' => 2016,
            'matricula' => '6742CLV',
            'bastidor' => '45FA32D45SDRFTFFG',
        ]);

        DB::table('coches')->insert([
            'id_cliente' => 10,
            'id_motor' => 32,
            'anio' => 2005,
            'matricula' => '7329JDF',
            'bastidor' => 'XYFA32D12SDRFTFFG',
        ]);
    }
}
