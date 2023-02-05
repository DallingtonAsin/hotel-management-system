<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenMenuItem;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use App\Models\KitchenOrderInvoice;
use Faker\Generator;
use Illuminate\Container\Container;
use Carbon\Carbon;
use App\Helpers\Helper;


class KitchenOrderInvoiceTableSeeder extends Seeder
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

        $order_numbers = DB::table('kitchen_orders')->pluck('order_number');
        foreach ($order_numbers as $number) {

            $random_menu_item = KitchenMenuItem::inRandomOrder()->first();
            $menu_item_id = $random_menu_item->id;
            $price = $random_menu_item->price;
            $quantity = rand(1, 6);
            $total = $price * $quantity;

            KitchenOrderItem::create([
                'order_number' => $number,
                'item_id' =>  $menu_item_id,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total
            ]);
        }

        foreach ($order_numbers as $number) {

            $data = $this->getInvoiceDetails($number);
            $status = KitchenOrder::where('order_number', $number)->value('status');
            $payment_method = null;

            if ($status == config('kitchen-order-statuses')['completed']) {
                $data['status'] = config('kitchen-order-statuses')['completed'];
                $payment_method = Helper::getRandomValue(config('payment-methods'));
                $data['paid_at'] = $this->faker->dateTimeBetween('-30 years',  'now', 'Africa/Kampala');
                $data['completed_by'] = 1;
                
            } else {
                $data['status'] = $status;
                $payment_method = null;
                $data['paid_at'] = null;
                $data['completed_by'] = null;
            }

            if ($status == config('kitchen-order-statuses')['cancelled']) {
                $reason = $this->faker->paragraph(4, true);
                $data['cancelled_by'] = 1;
                $data['cancelled_at'] = $this->faker->dateTimeBetween('-30 years',  'now', 'Africa/Kampala');

            } else {
                $reason = null;
                $data['cancelled_by'] = null;
                $data['cancelled_at'] = null;
            }

            $data['payment_method'] = $payment_method;
            $data['cancelled_for'] = $reason;

            KitchenOrderInvoice::create($data);
        }

           $paid_invoices = KitchenOrderInvoice::where('status', 'paid')->get();
            foreach($paid_invoices as $invoice){
                DB::update(
                    "UPDATE kitchen_order_invoices SET paid_at=DATE_FORMAT(paid_at,'2023-%m-%d %T')"
                );
            }

            $cancelled_invoices = KitchenOrderInvoice::whereNotNull('cancelled_at')->get();
            foreach($cancelled_invoices as $invoice){
                DB::update(
                    "UPDATE kitchen_order_invoices SET cancelled_at=DATE_FORMAT(cancelled_at,'2023-%m-%d %T')"
                );
            }
    }

    private function getInvoiceDetails($order_number)
    {
        $sub_total = KitchenOrderItem::where('order_number', $order_number)->value('total');
        $tax = 0.18 * $sub_total;
        $total = $sub_total + $tax;

        return [
            'order_number' => $order_number,
            'sub_total' => $sub_total,
            'tax' => $tax,
            'total' => $total
        ];
    }
}
