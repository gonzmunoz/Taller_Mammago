<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PayPal\Api\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BrandSeeder::class,
            ModelSeeder::class,
            EngineSeeder::class,
            UsersSeeder::class,
            CarsSeeder::class,
            AppointmentsSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            OrderSeeder::class,
            ArticleOrderSeeder::class,
            RepairSeeder::class,
            WorkSeeder::class,
            WorkRepair::class,
            ArticleRepair::class,
        ]);
    }
}
