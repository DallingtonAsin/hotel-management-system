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
            'country' => 'Uganda',
            'code' => 'UGX',
            'rate' => 3700,
            "created_by"  => 1
        ]);

        Currency::create([
            'country' => 'Kenya',
            'code' => 'KES',
            'rate' => 2000,
            "created_by"  => 2
        ]);

        Currency::create([
            'country' => 'Tanzania',
            'code' => 'TZS',
            'rate' => 3000,
            "created_by"  => 1
        ]);
    }
}
