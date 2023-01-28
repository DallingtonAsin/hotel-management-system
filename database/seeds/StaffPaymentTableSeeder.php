<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Models\Staff;
use App\Models\PaymentCategory;
use App\Models\StaffPayment;

class StaffPaymentTableSeeder extends Seeder
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
        $staff_members = Staff::all();
        foreach ($staff_members as $member) {
            $this->createPayment($member);
        }
    }

    private function createPayment($staff)
    {
        $payment_category_id = PaymentCategory::inRandomOrder()->first()->id;

        $payment = [
            'staff_id' => $staff->id,
            'payment_category_id' => $payment_category_id,
            'amount' => $this->faker->numberBetween(254000, 950000),
            'payment_date' => $this->faker->date('Y-m-d', 'now'),
            'created_by' => 1
        ];

        StaffPayment::create($payment);
    }
}
