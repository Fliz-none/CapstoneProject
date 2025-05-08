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
            LocalSeeder::class,
            BranchSeeder::class,
            WarehouseSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,

            CatalogueSeeder::class,
            AttributeSeeder::class,
            ProductSeeder::class,
            VariableSeeder::class,
            UnitSeeder::class,
            SupplierSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
