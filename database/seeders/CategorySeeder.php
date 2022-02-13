<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Aceites',
        ]);

        Categoria::create([
            'nombre' => 'Sistema eléctrico',
        ]);

        Categoria::create([
            'nombre' => 'Limpieza de cristales',
        ]);

        Categoria::create([
            'nombre' => 'Frenado',
        ]);

        Categoria::create([
            'nombre' => 'Motor',
        ]);

        Categoria::create([
            'nombre' => 'Suspensión',
        ]);

        Categoria::create([
            'nombre' => 'Transmisión',
        ]);

        Categoria::create([
            'nombre' => 'Escape',
        ]);

        Categoria::create([
            'nombre' => 'Dirección',
        ]);

        Categoria::create([
            'nombre' => 'Neumáticos',
        ]);
    }
}
