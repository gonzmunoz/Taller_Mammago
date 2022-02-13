<?php

namespace Database\Seeders;

use App\Models\Modelo;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modelo::create([
            'id' => 1,
            'nombre' => '100',
            'id_marca' => 1,
        ]);

        Modelo::create([
            'id' => 2,
            'nombre' => 'A1',
            'id_marca' => 1,
        ]);

        Modelo::create([
            'id' => 3,
            'nombre' => 'A2',
            'id_marca' => 1,
        ]);

        Modelo::create([
            'id' => 4,
            'nombre' => 'A3',
            'id_marca' => 1,
        ]);

        Modelo::create([
            'id' => 5,
            'nombre' => 'Berlingo',
            'id_marca' => 2,
        ]);

        Modelo::create([
            'id' => 6,
            'nombre' => 'C4 Cactus',
            'id_marca' => 2,
        ]);

        Modelo::create([
            'id' => 7,
            'nombre' => 'C5 II',
            'id_marca' => 2,
        ]);

        Modelo::create([
            'id' => 8,
            'nombre' => 'XSARA PICASSO',
            'id_marca' => 2,
        ]);

        Modelo::create([
            'id' => 9,
            'nombre' => 'CORTINA',
            'id_marca' => 3,
        ]);

        Modelo::create([
            'id' => 10,
            'nombre' => 'ESCORT IV',
            'id_marca' => 3,
        ]);

        Modelo::create([
            'id' => 11,
            'nombre' => 'FIESTA VII',
            'id_marca' => 3,
        ]);

        Modelo::create([
            'id' => 12,
            'nombre' => 'MONDEO V FASTBACK',
            'id_marca' => 3,
        ]);

        Modelo::create([
            'id' => 13,
            'nombre' => 'AMG GT',
            'id_marca' => 4,
        ]);

        Modelo::create([
            'id' => 14,
            'nombre' => 'CLASE C',
            'id_marca' => 4,
        ]);

        Modelo::create([
            'id' => 15,
            'nombre' => 'CLASE S COUPÉ',
            'id_marca' => 4,
        ]);

        Modelo::create([
            'id' => 16,
            'nombre' => 'CLS',
            'id_marca' => 4,
        ]);

        Modelo::create([
            'id' => 17,
            'nombre' => '207',
            'id_marca' => 5,
        ]);

        Modelo::create([
            'id' => 18,
            'nombre' => '306',
            'id_marca' => 5,
        ]);

        Modelo::create([
            'id' => 19,
            'nombre' => '508',
            'id_marca' => 5,
        ]);

        Modelo::create([
            'id' => 20,
            'nombre' => 'Partner Tepee',
            'id_marca' => 5,
        ]);

        Modelo::create([
            'id' => 21,
            'nombre' => 'ALTEA XL',
            'id_marca' => 6,
        ]);

        Modelo::create([
            'id' => 22,
            'nombre' => 'CORDOBA',
            'id_marca' => 6,
        ]);

        Modelo::create([
            'id' => 23,
            'nombre' => 'IBIZA IV ST',
            'id_marca' => 6,
        ]);

        Modelo::create([
            'id' => 24,
            'nombre' => 'LEON',
            'id_marca' => 6,
        ]);



    }
}
