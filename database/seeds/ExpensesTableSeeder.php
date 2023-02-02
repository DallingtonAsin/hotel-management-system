<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Expense::factory()->count(50)->create();

        $expenses = Expense::all();
        foreach($expenses as $expense){
            DB::update("UPDATE expenses SET date_of_expenditure=DATE_FORMAT(date_of_expenditure,'2023-%m-%d')");
        }

    }
}
