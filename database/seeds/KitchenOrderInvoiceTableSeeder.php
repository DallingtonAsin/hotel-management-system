<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KitchenMenuItem;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use App\Models\KitchenOrderInvoice;
use Carbon\Carbon;


class KitchenOrderInvoiceTableSeeder extends Seeder
{
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
                $payment_method = $this->getRandomValue(config('payment-methods'));
                $payment_date = Carbon::now();
            }else{
                $data['status'] = $status;
                $payment_method = null;
                $payment_date = null;
            }

            $data['payment_method'] = $payment_method;
            $data['payment_date'] = $payment_date;

            KitchenOrderInvoice::create($data);
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

    private function getRandomValue($arr)
    {
        $random_key = array_rand($arr);
        $random_value = $arr[$random_key];
        return $random_value;
    }
}
