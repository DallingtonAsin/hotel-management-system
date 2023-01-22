<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseType;

class ExpenseTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseType::create([
            'name' => 'Travel',
            'created_by' => 1,
        ]);


        ExpenseType::create([
            'name' => 'Utilities',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Taxes and fees',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Marketing and Advertising',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Linen and Laundry',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Technology and equipment',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Insurance',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Maintenance and repairs',
            'created_by' => 1,
        ]);

        ExpenseType::create([
            'name' => 'Staff salaries',
            'created_by' => 1,
        ]);
    }
}
