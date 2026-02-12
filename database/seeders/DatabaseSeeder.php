<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            RolSeeder::class,
            AdminSeeder::class,
            ProveedorSeeder::class,
            // ProductoSeeder::class,
            // InventarioSeeder::class,
            ClienteSeeder::class,
//            VentaSeeder::class,
//            DetalleVentaSeeder::class,
            // ProductoTagRfidSeeder::class,
        ]);
    }
}
