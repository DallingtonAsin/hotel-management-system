<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KitchenMenuItemCategory;

class KitchenMenuItemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KitchenMenuItemCategory::create([
            'name' => 'Beverages',
            'created_by' => 1
        ]);

        KitchenMenuItemCategory::create([
            'name' => 'Side Dishes',
            'created_by' => 1
        ]);

        KitchenMenuItemCategory::create([
            'name' => 'Desserts',
            'created_by' => 1
        ]);

        KitchenMenuItemCategory::create([
            'name' => 'Appetizers',
            'created_by' => 1
        ]);

        KitchenMenuItemCategory::create([
            'name' => 'Entrees',
            'created_by' => 1
        ]);
    }
}
