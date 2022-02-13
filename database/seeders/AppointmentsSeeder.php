<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('citas')->insert([
            'id_cliente' => 6,
            'id_coche' => 1,
            'fecha' => '2021-03-10 10:00:00',
            'motivo' => 'Quiero cambiar el aceite',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 10,
            'id_coche' => 3,
            'fecha' => '2021-03-08 12:00:00',
            'motivo' => 'Cambio de neumáticos',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 6,
            'id_coche' => 2,
            'fecha' => '2021-03-12 14:30:00',
            'motivo' => 'Escucho un ruido extraño',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 10,
            'id_coche' => 4,
            'fecha' => '2021-03-18 15:00:00',
            'motivo' => 'Escucho un ruido extraño',
            'confirmada' => false,
        ]);

        /////////////////////////CITAS DIA COMPLETO//////////////////////////

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 07:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 07:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 08:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 08:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 09:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 09:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 10:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 10:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 4,
            'id_coche' => 2,
            'fecha' => '2021-03-25 11:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 11:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 12:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 12:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 13:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 13:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 14:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 14:30:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);

        DB::table('citas')->insert([
            'id_cliente' => 5,
            'id_coche' => 3,
            'fecha' => '2021-03-25 15:00:00',
            'motivo' => 'Revisión',
            'confirmada' => false,
        ]);
    }
}
