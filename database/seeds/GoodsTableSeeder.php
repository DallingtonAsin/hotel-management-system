<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Good;
use App\Models\CommodityCategory;
use App\Models\Currency;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $random_category = CommodityCategory::inRandomOrder()->first();
       $random_currency = Currency::inRandomOrder()->first();



        Good::create([
            'goods_name' => 'apple',
            'goods_code' => '001',
            'measure_unit' => '101',
            'unit_price' => 1600,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'mango',
            'goods_code' => '002',
            'measure_unit' => '101',
            'unit_price' => 1200,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'orange',
            'goods_code' => '003',
            'measure_unit' => '101',
            'unit_price' => 5500,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);


        Good::create([
            'goods_name' => 'Beer',
            'goods_code' => '004',
            'measure_unit' => '101',
            'unit_price' => 2000,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'Tusker',
            'goods_code' => '005',
            'measure_unit' => '101',
            'unit_price' => 4000,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'Pineapple',
            'goods_code' => '006',
            'measure_unit' => '101',
            'unit_price' => 3000,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'sugar',
            'goods_code' => '007',
            'measure_unit' => '101',
            'unit_price' => 9000,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);

        Good::create([
            'goods_name' => 'Red Wine',
            'goods_code' => '008',
            'measure_unit' => '101',
            'unit_price' => 15000,
            'currency_id' => $random_currency->id,
            'commodity_category_id' => $random_category->id,
            'have_excise_tax' => '102',
            'stock_prewarning' => 10,
            'have_piece_unit' => '102',
            'created_by' => 1
        ]);
    }
}
