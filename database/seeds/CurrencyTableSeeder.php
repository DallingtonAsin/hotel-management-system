<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'code' => 'UGX',
            'efris_code' => '101',
            'country' => 'Uganda',
            'rate' => 1,
            'description' => 'shilling,shillings,cent,cents',
            "created_by"  => 1
        ]);

        Currency::create([
            'code' => 'USD',
            'efris_code' => '102',
            'country' => 'USA',
            'rate' => 3700,
            'description' => 'dollar,dollars,cent,cents',
            "created_by"  => 1
        ]);

        Currency::create([
            'code' => 'KES',
            'efris_code' => '108',
            'country' => 'Kenya',
            'rate' => 1500,
            'description' => 'shilling,shillings,cent,cents',
            "created_by"  => 1
        ]);

        Currency::create([
            'code' => 'TZS',
            'efris_code' => '110',
            'country' => 'Tanzania',
            'description' => 'shilling,shillings,cent,cents',
            'rate' => 1000,
            "created_by"  => 1
        ]);
    }
}
