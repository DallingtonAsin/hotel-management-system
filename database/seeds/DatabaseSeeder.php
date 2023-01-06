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
            DepartmentTableSeeder::class,
            DesignationTableSeeder::class,
            UserTableSeeder::class,
            RoomTypeTableSeeder::class,
            RoomTableSeeder::class,
            GuestTypeTableSeeder::class,
            StockTableSeeder::class,
            CustomersTableSeeder::class,
            DamagesTableSeeder::class,
            EventsTableSeeder::class,
            ExpensesTableSeeder::class,
            SalesTableSeeder::class,
            StockCategoriesTableSeeder::class,
            SuppliersTableSeeder::class,
            PurchasesTableSeeder::class,
        ]);
        
    }
    
    
}
