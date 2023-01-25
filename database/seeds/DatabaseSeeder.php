<?php

namespace Database\Seeders;

use App\Models\KitchenOrderInvoice;
use App\Models\RoomStatusHistory;
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
          
            StaffTableSeeder::class,
          
            RoomTypeTableSeeder::class,
            RoomStatusTableSeeder::class,
            RoomTableSeeder::class,
            RoomStatusHistoryTableSeeder::class,
            GuestTypeTableSeeder::class,
            GuestTableSeeder::class,
            ReservationTableSeeder::class,
            ReservationInvoiceTableSeeder::class,
            SalaryTableSeeder::class,
            // PaymentTableSeeder::class,

            KitchenMenuItemCategoryTableSeeder::class,
            KitchenMenuItemTableSeeder::class,
            KitchenOrderTableSeeder::class,
            KitchenOrderInvoiceTableSeeder::class,
         
            CurrencyTableSeeder::class,
            FrequentContactTableSeeder::class,

            PermissionsTableSeeder::class,
            StaffPermissionsTableSeeder::class,

            CommodityCategoryTableSeeder::class,
            GoodsTableSeeder::class,
            StockCategoriesTableSeeder::class,
            SuppliersTableSeeder::class,
            StockTableSeeder::class,
            PurchasesTableSeeder::class,
            CustomersTableSeeder::class,
            DamagesTableSeeder::class,
            ExpenseTypeTableSeeder::class,
            ExpensesTableSeeder::class,
            SalesTableSeeder::class,

        ]);
        
    }
    
    
}
