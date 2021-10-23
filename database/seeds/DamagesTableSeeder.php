<?php

use Illuminate\Database\Seeder;

class DamagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Damage::class, 100)->create();
    }
}
