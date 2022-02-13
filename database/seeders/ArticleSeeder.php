<?php

namespace Database\Seeders;

use App\Models\Articulo;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articulo::create([
            'nombre' => 'Aceite Castrol EDGE 0W-20',
            'descripcion' => 'Aceite de categoría 0W-20',
            'id_motor' => 14,
            'precio' => 56.62,
            'id_categoria' => 1,
            'stock' => 10,
            'imagen' => 'articulo1.jpeg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Batería YUASA 112 Ah',
            'descripcion' => 'Batería de 112 Ah',
            'id_motor' => 22,
            'precio' => 114.79,
            'id_categoria' => 2,
            'stock' => 2,
            'imagen' => 'articulo2.jpeg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Bombillas PHILIPS H7 RACINGVISION',
            'descripcion' => 'Juego de dos bombillas H7',
            'id_motor' => 8,
            'precio' => 38.88,
            'id_categoria' => 2,
            'stock' => 5,
            'imagen' => 'articulo3.jpeg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Escobillas BOSCH - 3 397 007 586',
            'descripcion' => 'Juego de dos limpiaparabrisas para el aprabrisas delantero',
            'id_motor' => 38,
            'precio' => 24.67,
            'id_categoria' => 3,
            'stock' => 1,
            'imagen' => 'articulo4.jpeg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Tapa de combustible Valeo',
            'descripcion' => 'Tapa para el depósito del coche',
            'id_motor' => 14,
            'precio' => 30.00,
            'id_categoria' => 5,
            'stock' => 4,
            'imagen' => 'articulo5.jpeg',
            'visible' => false,
        ]);

        Articulo::create([
            'nombre' => 'Alternador Hella 124',
            'descripcion' => 'Alternador a correa de 150 A',
            'id_motor' => 20,
            'precio' => 158.58,
            'id_categoria' => 2,
            'stock' => 10,
            'imagen' => 'articulo6.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Filtro de aceite Quinton QFL',
            'descripcion' => 'Filtro cartucho papel de 84 mm',
            'id_motor' => 22,
            'precio' => 24.33,
            'id_categoria' => 1,
            'stock' => 4,
            'imagen' => 'articulo7.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Amortiguadores Nippon',
            'descripcion' => 'Juego de dos amortiguadores delanteros',
            'id_motor' => 90,
            'precio' => 196.44,
            'id_categoria' => 6,
            'stock' => 4,
            'imagen' => 'articulo8.jpg',
            'visible' => false,
        ]);

        Articulo::create([
            'nombre' => 'Discos de freno BREMBO',
            'descripcion' => 'Juego de dos discos de freno ventilados',
            'id_motor' => 38,
            'precio' => 108.60,
            'id_categoria' => 4,
            'stock' => 10,
            'imagen' => 'articulo9.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Pastillas de freno BOSCH - 494 027',
            'descripcion' => 'Juego de cuatro pastillas de freno',
            'id_motor' => 38,
            'precio' => 18.71,
            'id_categoria' => 4,
            'stock' => 4,
            'imagen' => 'articulo10.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Neumático MICHELIN PRIMACY',
            'descripcion' => 'Neumático 185/65 R15 88 H',
            'id_motor' => 32,
            'precio' => 67.00,
            'id_categoria' => 10,
            'stock' => 8,
            'imagen' => 'articulo11.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Aceite Repsol 5W40',
            'descripcion' => 'Garrafa de 5 litros de aceite 5W40. Protege el motor de forma eficaz',
            'id_motor' => 22,
            'precio' => 31.00,
            'id_categoria' => 1,
            'stock' => 6,
            'imagen' => 'articulo12.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Neumático Goodyear Efficient Grip Performance',
            'descripcion' => 'Se caracteriza por la alta elasticidad y flexibilidad de la banda de rodadura, esto permite menos fracturas causadas por las irregularidades de la carretera.',
            'id_motor' => 32,
            'precio' => 57.50,
            'id_categoria' => 10,
            'stock' => 16,
            'imagen' => 'articulo13.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Aceite SHELL - Helix Ultra ',
            'descripcion' => 'Garrafa de 5 litros 5W40 SN+A3B4. Reduce la fricción que reduce la potencía en todas las velocidades y condiciones del motor',
            'id_motor' => 32,
            'precio' => 30.60,
            'id_categoria' => 1,
            'stock' => 25,
            'imagen' => 'articulo14.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Aceite Castrol',
            'descripcion' => 'Garrafa de 4 litros Magnatec 10W-40. Lubricante sintético ahorrador de carburante de muy altas prestaciones destinado a la lubricación de los vehículos de turismo',
            'id_motor' => 32,
            'precio' => 29.32,
            'id_categoria' => 1,
            'stock' => 17,
            'imagen' => 'articulo15.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Batería Magneti Marelli',
            'descripcion' => 'La capacidad es de 66 Ah, como ventaja, tiene un indicador de carga visual y como desventaja no tiene la funcion de star and stop, ',
            'id_motor' => 32,
            'precio' => 77.05,
            'id_categoria' => 2,
            'stock' => 7,
            'imagen' => 'articulo16.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Alternador Hella',
            'descripcion' => 'Modelo 8EL 011 710-511, con una intensidad de carga de 90A y tiene un diametro de 56mm',
            'id_motor' => 32,
            'precio' => 99.63,
            'id_categoria' => 2,
            'stock' => 3,
            'imagen' => 'articulo17.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Limpiaparabrisas Valeo Service',
            'descripcion' => 'La posicion es delantera, del lado del conductor al lado del pasajero, y tiene contacto de aviso de desgaste incorporado ',
            'id_motor' => 32,
            'precio' => 15.32,
            'id_categoria' => 3,
            'stock' => 10,
            'imagen' => 'articulo18.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Limpiaparabrisas Denso',
            'descripcion' => 'Modelo DM-565, 650mm de largo, del lado del conductor al lado del pasajero ',
            'id_motor' => 32,
            'precio' => 14.23,
            'id_categoria' => 3,
            'stock' => 13,
            'imagen' => 'articulo19.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Juego de 4 pastillas de freno, Bosch',
            'descripcion' => 'Estan hechas de metal sintetizado, el diámetro del disco de freno es de 266mm y la pinza de freno/montaje de origen:
            Bendix/Bosch',
            'id_motor' => 32,
            'precio' => 18.87,
            'id_categoria' => 4,
            'stock' => 24,
            'imagen' => 'articulo20.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Juego de 4 pastillas de freno, Ferodo',
            'descripcion' => 'También llevan el soporte para las pastillas de freno, la posicion es trasera y la pinza de freno/montaje de origen
            Lucas/Girling/TRW',
            'id_motor' => 32,
            'precio' => 29.33,
            'id_categoria' => 4,
            'stock' => 2,
            'imagen' => 'articulo21.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Motor de arranque Magneti Marelli',
            'descripcion' => 'La potencia es de 1,4KW, consta de 3 de taladores roscados y la tension es de 12V ',
            'id_motor' => 32,
            'precio' => 85.85,
            'id_categoria' => 2,
            'stock' => 7,
            'imagen' => 'articulo22.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Motor de arranque Hella',
            'descripcion' => 'Tiene engranaje reductor, gira en el sentido horario , la potencia es de 1,4KW, consta de 3 de taladores roscados y la tension es de 12V  ',
            'id_motor' => 32,
            'precio' => 327.73,
            'id_categoria' => 2,
            'stock' => 6,
            'imagen' => 'articulo23.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Barra de suspensión Mapco',
            'descripcion' => 'La posición es delantera, derecha, es de acero fundido e incluye rótula de suspensión y Silentblock de suspensión',
            'id_motor' => 32,
            'precio' => 36.65,
            'id_categoria' => 6,
            'stock' => 8,
            'imagen' => 'articulo24.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Silentblock de Suspensión Quinton Hazell',
            'descripcion' => 'Es para la suspensión trasera o para un vehículo que tenga brazo de suspensión',
            'id_motor' => 32,
            'precio' => 12.35,
            'id_categoria' => 6,
            'stock' => 12,
            'imagen' => 'articulo25.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Juego de articulación, árbol de transmisión RCA France',
            'descripcion' => 'Para un vehículo con ABS, la gama del fabricante es CV JOINT / JOINT HOMOCINETIQUE NEUF y el tipo es de Junta del cardán',
            'id_motor' => 32,
            'precio' => 25.35,
            'id_categoria' => 7,
            'stock' => 5,
            'imagen' => 'articulo26.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Juego de articulación, árbol de transmisión ERA Benelux N.V.',
            'descripcion' => 'Para un vehículo con ABS, que su transmisión se automática, y la gama del fabricante es "THE NEWLINE" by ERA Benelux.',
            'id_motor' => 32,
            'precio' => 97.77,
            'id_categoria' => 7,
            'stock' => 18,
            'imagen' => 'articulo27.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Soporte Motor Quinton Hazell',
            'descripcion' => 'Soporte de la goma del sistema de escape, hecho de acero',
            'id_motor' => 32,
            'precio' => 8.45,
            'id_categoria' => 8,
            'stock' => 20,
            'imagen' => 'articulo28.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Tubo de escape Imasaf S.P.A',
            'descripcion' => 'En algunos casos, las piezas de escape pueden presentar marcas ennegrecidas originadas durante la soldadura. Se trata de un fenómeno completamente normal que se produce durante la fabricación de la pieza nueva. Durante el proceso industrial de fabricación, el humo de la soldadura puede depositarse sobre la pieza.',
            'id_motor' => 32,
            'precio' => 68.98,
            'id_categoria' => 8,
            'stock' => 4,
            'imagen' => 'articulo29.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Travesaños/Barra de dirección Metzger',
            'descripcion' => 'La posición es delante, derecha e izquierda, incluye articulación angular y un juego de barras de acoplamiento ambos con fabricante KIT+',
            'id_motor' => 32,
            'precio' => 29.28,
            'id_categoria' => 9,
            'stock' => 11,
            'imagen' => 'articulo30.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Cremallera de dirección Mapco',
            'descripcion' => 'Para un vehículo con dirección asistida, el tipo de funcionamiento de la dirección deber ser hidráulico y la técnica de conexión debe es Gesteckt',
            'id_motor' => 32,
            'precio' => 516.63,
            'id_categoria' => 9,
            'stock' => 7,
            'imagen' => 'articulo31.PNG',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Kit de distribución SKF',
            'descripcion' => 'Kit de bomba y correa de distribución',
            'id_motor' => 32,
            'precio' => 84.12,
            'id_categoria' => 5,
            'stock' => 3,
            'imagen' => 'articulo32.jpg',
            'visible' => true,
        ]);

        Articulo::create([
            'nombre' => 'Inyector BOSCH 445',
            'descripcion' => 'Inyector marcas BOSCH para common rail',
            'id_motor' => 32,
            'precio' => 258.72,
            'id_categoria' => 5,
            'stock' => 7,
            'imagen' => 'articulo33.jpg',
            'visible' => true,
        ]);

    }
}
