<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stock;
use App\Models\Staff;
use App\Models\StockCat;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Models\CommodityCategory;
use App\Models\Good;


class StockFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Stock::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {

    $random_supplier = Supplier::inRandomOrder()->first();
    $created_by = Staff::inRandomOrder()->first()->id;
    $rand_goods_type_code = Helper::getRandomValue(config('goods-type-codes'));
    $rand_stockin_type_code = Helper::getRandomValue(config('stockin-types'));
    $random_good = Good::inRandomOrder()->first();


    return [
      'item_name' => Str::random(7),
      'item_code' => $random_good->goods_code,
      'goods_type_code' => $rand_goods_type_code,
      'stockin_type_code' => $rand_stockin_type_code,
      'quantity' => $this->faker->randomDigit,
      'threshold_qty' => $this->faker->randomDigit,
      'buying_price' => $this->faker->numberBetween($min=4000, $max=6000),
      'selling_price' => $this->faker->numberBetween($min=6000, $max=9000),
      'supplier_id' => $random_supplier->id,
      'date_of_entry' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
      'expiry_date' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
      'created_by' => $created_by
    ];

  }
}
