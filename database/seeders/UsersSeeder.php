<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(Faker $faker)
    {

        DB::table('tipos_usuario')->insert([
            'tipo_usuario' => 'administrador',
        ]);

        DB::table('tipos_usuario')->insert([
            'tipo_usuario' => 'administrativo',
        ]);

        DB::table('tipos_usuario')->insert([
            'tipo_usuario' => 'mecanico',
        ]);

        DB::table('tipos_usuario')->insert([
            'tipo_usuario' => 'cliente',
        ]);

        // Usuario Administrador

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 1,
            'nombre_usuario' => 'admin',
            'nombre' => 'Fernando',
            'apellidos' => 'Alonso Díaz',
            'email' => 'fernando@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Calle Manríquez',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 666666666,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        // Usuarios Administrativos

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 2,
            'nombre_usuario' => 'administrativo1',
            'nombre' => 'Maria',
            'apellidos' => 'Romero Rodríguez',
            'email' => 'maria@mail.com',
            'password' => Hash::make('adMMin56'),
            'direccion' => 'Avenida de los Aguijones 12',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 667456765,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 2,
            'nombre_usuario' => 'administrativo2',
            'nombre' => 'Raúl',
            'apellidos' => 'Pérez',
            'email' => 'raul@mail.com',
            'password' => Hash::make('adMMin56'),
            'direccion' => 'Avenida de Cádiz 12',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 627453765,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        // Usuarios Mecánicos

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 3,
            'nombre_usuario' => 'mecanico1',
            'nombre' => 'Luis',
            'apellidos' => 'García Gutiérrez',
            'email' => 'luis@mail.com',
            'password' => Hash::make('MMeca81'),
            'direccion' => 'Calle los Omeyas 16',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 667766666,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 3,
            'nombre_usuario' => 'mecanico2',
            'nombre' => 'Eduardo',
            'apellidos' => 'Callejón',
            'email' => 'eduardo@mail.com',
            'password' => Hash::make('MMeca81'),
            'direccion' => 'Calle Portugal 3',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 663766386,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        // Usuarios Cliente Manual

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'paco',
            'nombre' => 'Francisco',
            'apellidos' => 'Rodríguez',
            'email' => 'fran1@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Calle Aguijon 3',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 667556765,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'josel67',
            'nombre' => 'José Luis',
            'apellidos' => 'Vázquez',
            'email' => 'josel@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Calle Gondomar',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 631246765,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'vincent',
            'nombre' => 'Vicente',
            'apellidos' => 'Amigo',
            'email' => 'vincent@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Avenida América 21',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 797546765,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'paula93',
            'nombre' => 'Paula',
            'apellidos' => 'Esquinas',
            'email' => 'pau93@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Avenida Arroyo del moro 8',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 640256765,
            'foto' => 'images/users/paula93.jpeg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'ana',
            'nombre' => 'Ana',
            'apellidos' => 'Pérez Vázquez',
            'email' => 'anaclientamammago@gmail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Calle Martín  12',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 680356725,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'ele12',
            'nombre' => 'Elena',
            'apellidos' => 'Márquez',
            'email' => 'elena@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Avenida Medina Azahara 3',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 690256755,
            'foto' => 'images/users/user.jpg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        DB::table('usuarios')->insert([
            'id_tipo_usuario' => 4,
            'nombre_usuario' => 'pedro',
            'nombre' => 'Pedro',
            'apellidos' => 'Expósito',
            'email' => 'pedro@mail.com',
            'password' => Hash::make('maMMago56'),
            'direccion' => 'Calle Gondomar 6',
            'pais' => 'España',
            'provincia' => 'Córdoba',
            'ciudad' => 'Córdoba',
            'telefono' => 660258765,
            'foto' => 'images/users/pedro.jpeg',
            'confirmada' => 1,
            'codigo_confirmacion' => Str::random(25),
        ]);

        // Usuarios Clientes Faker

        for ($i = 0; $i < 20; $i++) {
            DB::table('usuarios')->insert([
                'id_tipo_usuario' => 4,
                'nombre_usuario' => $faker->userName,
                'nombre' => $faker->name,
                'apellidos' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('ciri'),
                'foto' => 'images/users/user.jpg',
                'confirmada' => 1,
                'codigo_confirmacion' => Str::random(25),
            ]);
        }

    }
}
