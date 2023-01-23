<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Support\Str;

class PurchaseFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Purchase::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {

    $random_stock = Stock::inRandomOrder()->first();
    $random_supplier = Supplier::inRandomOrder()->first();
    $random_staff = Supplier::inRandomOrder()->first();

    return [
        'item_code' => $random_stock->item_code,
        'item_name' => $random_stock->item_name,
        'quantity' => $this->faker->randomDigitNot(0),
        'cost_price_per_item' => $random_stock->buying_price,
        'supplier_id' => $random_supplier->id,
        'created_by' => $random_staff->id,
    ];
  }
}
