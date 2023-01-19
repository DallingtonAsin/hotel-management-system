<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\Helper;

class ReservationInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $date =  $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $issued_on = $this->faker->dateTimeBetween($date, $date->format('Y-m-d H:i:s').' +2 days');
        $guestInvoiceNumber  = Helper::generateUniqueNumber('reservation_invoices', 'invoice_number', 10, 'CMH');

        $amount = $this->faker->numberBetween(10000, 90000);
        $tax = 0.18*$amount;

        return [
            'invoice_number' => $guestInvoiceNumber,
            'reservation_id' => $this->faker->randomElement([1,2]),
            'amount' => $amount,
            'tax' => $tax,
            'issued_on' => $issued_on,
            "issued_by"  => $this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
