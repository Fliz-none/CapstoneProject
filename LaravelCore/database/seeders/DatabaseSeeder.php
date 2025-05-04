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
            CompanySeeder::class,
            BranchSeeder::class,
            WarehouseSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            AnimalSeeder::class,
            PetSeeder::class,

            CatalogueSeeder::class,
            AttributeSeeder::class,
            ProductSeeder::class,
            VariableSeeder::class,
            UnitSeeder::class,
            SupplierSeeder::class,

            ImportSeeder::class,
            ImportDetailSeeder::class,
            StockSeeder::class,
            ExportSeeder::class,
            ExportDetailSeeder::class,
            OrderSeeder::class,
            DetailSeeder::class,
            TransactionSeeder::class,

            MajorSeeder::class,
            CriterialSeeder::class,
            ServiceSeeder::class,

            SettingsSeeder::class,
            ImageSeeder::class,
            MedicalSeeder::class,

            BookingSeeder::class,
            ExpenseSeeder::class,
            NotificationSeeder::class,
            VersionSeeder::class,
            InfoSeeder::class,

            SuBeoSeeder::class
        ]);
    }
}
