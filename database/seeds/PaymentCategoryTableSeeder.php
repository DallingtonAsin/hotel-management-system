<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentCategory;
use App\Models\Staff;

class PaymentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_by = Staff::inRandomOrder()->first()->id;

        PaymentCategory::create([
           'name' => 'Salary',
           'transaction_type' => 'credit',
           'created_by' => $created_by
        ]);

        PaymentCategory::create([
            'name' => 'Overtime',
           'transaction_type' => 'credit',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Bonus',
           'transaction_type' => 'credit',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Commission',
            'transaction_type' => 'credit',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Allowances',
           'transaction_type' => 'credit',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Benefits',
           'transaction_type' => 'credit',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Taxes',
           'transaction_type' => 'debt',
            'created_by' => $created_by
         ]);

         PaymentCategory::create([
            'name' => 'Deductions',
           'transaction_type' => 'debt',
            'created_by' => $created_by
         ]);

    }
}
