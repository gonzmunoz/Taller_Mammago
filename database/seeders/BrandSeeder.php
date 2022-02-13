<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create([
            'id' => 1,
            'nombre' => 'AUDI',
        ]);

        Marca::create([
            'id' => 2,
            'nombre' => 'CITRÖEN',
        ]);

        Marca::create([
            'id' => 3,
            'nombre' => 'FORD',
        ]);

        Marca::create([
            'id' => 4,
            'nombre' => 'MERCEDES-BENZ',
        ]);

        Marca::create([
            'id' => 5,
            'nombre' => 'PEUGEOT',
        ]);

        Marca::create([
            'id' => 6,
            'nombre' => 'SEAT',
        ]);
    }
}
