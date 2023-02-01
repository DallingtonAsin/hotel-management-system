<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationInvoice;
use App\Models\Reservation;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Models\Staff;
use App\Helpers\Helper;
use Carbon\Carbon;


class ReservationInvoiceTableSeeder extends Seeder
{

         /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservations = Reservation::all();
        foreach($reservations as $reservation){
             $data = $this->generateData($reservation->id);
             ReservationInvoice::create($data);
        }
    }

    private function generateData($reservation_id){

        $date =  $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $issued_on = $this->faker->dateTimeBetween($date, $date->format('Y-m-d H:i:s').' +2 days');
        $guestInvoiceNumber  = Helper::generateUniqueNumber('reservation_invoices', 'invoice_number', 10, 'CMH');
        $issued_by = $completed_by = $cancelled_by =  Staff::inRandomOrder()->first()->id;
        
        $amount = $this->faker->numberBetween(10000, 90000);
        $tax = 0.18*$amount;

        $data = [
            'invoice_number' => $guestInvoiceNumber,
            'reservation_id' => $reservation_id,
            'amount' => $amount,
            'tax' => $tax,
            'issued_on' => $issued_on,
            "issued_by"  => $issued_by
        ];

        $status = Helper::getRandomValue(config('reservation-statuses'));

        if ($status == config('reservation-statuses')['completed']) {

            $data['status'] = config('reservation-statuses')['completed'];
            $data['payment_method'] = Helper::getRandomValue(config('payment-methods'));
            $data['paid_on'] = Carbon::now();
            $data['completed_by'] = $completed_by;
            
        } else if($status == config('reservation-statuses')['cancelled']) {
            $data['status'] = config('reservation-statuses')['cancelled'];
            $data['cancelled_by'] = $cancelled_by;
            $data['cancelled_for'] = 'decision change';

        }

       return $data;

    }
}
