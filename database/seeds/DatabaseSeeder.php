<?php

use Illuminate\Database\Seeder;
//use pos\User;
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
        UserTableSeeder::class,
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
