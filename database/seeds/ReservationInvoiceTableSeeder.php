<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationInvoice;

class ReservationInvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReservationInvoice::factory()->count(100)->create();
    }
}
