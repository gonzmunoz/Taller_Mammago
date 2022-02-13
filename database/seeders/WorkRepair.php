<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkRepair extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trabajos_reparaciones')->insert([
            'id_trabajo' => 1,
            'id_reparacion' => 1,
        ]);

        DB::table('trabajos_reparaciones')->insert([
            'id_trabajo' => 2,
            'id_reparacion' => 2,
        ]);
    }
}
