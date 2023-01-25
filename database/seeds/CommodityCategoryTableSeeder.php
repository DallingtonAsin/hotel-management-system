<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommodityCategory;

class CommodityCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
     CommodityCategory::create([
        'name' => 'Wine',
        'code' => '50202203',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Beer',
        'code' => '50202201',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Coffee, green',
        'code' => '50201717',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Alcohol cocktails or drink mixes',
        'code' => '50202207',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Water',
        'code' => '50202301',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Tea drinks',
        'code' => '50201712',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Coffee drinks',
        'code' => '50201708',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Fresh juice',
        'code' => '50202305',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Ice',
        'code' => '50202302',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Soft drinks',
        'code' => '50202306',
        'created_by' => 1
     ]);

     CommodityCategory::create([
        'name' => 'Spirits or liquors',
        'code' => '50202206',
        'created_by' => 1
     ]);




    }
}
