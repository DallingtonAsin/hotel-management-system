<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceGuest;

class InvoiceGuestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceGuest::factory()->count(100)->create();
    }
}
