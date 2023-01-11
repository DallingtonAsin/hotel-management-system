<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KitchenMenuItem;

class KitchenMenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KitchenMenuItem::create([
            'name' => 'French Toast',
            'description' =>  'Thick slices of bread dipped in a rich egg and milk mixture and grilled to perfection, served with maple syrup and butter.',
            'price' => 25000,
            'category' => 'Breakfast',
            'created_by' => 1
        ]);

        KitchenMenuItem::create([
            'name' => 'Classic American Breakfast',
            'description' =>  'Two eggs cooked to your liking, crispy bacon, sausage links, hash browns, and toast.',
            'price' => 35000,
            'category' => 'Breakfast',
            'created_by' => 2
        ]);

        KitchenMenuItem::create([
            'name' => 'Fried Calamari',
            'description' =>  'Lightly fried calamari strips served with a spicy marinara sauce for dipping.',
            'price' => 15000,
            'category' => 'Appetizers',
            'created_by' => 1

        ]);

        KitchenMenuItem::create([
            'name' => ' Spinach and Artichoke Dip',
            'description' =>  'A creamy blend of spinach, artichoke, and parmesan cheese, served with warm pita bread.',
            'price' => 10000,
            'category' => 'Appetizers',
            'created_by' => 2
        ]);



        KitchenMenuItem::create([
            'name' => 'Grilled New York Strip Steak',
            'description' =>  'A 12 oz. New York strip steak, grilled to your liking and served with a herb butter.',
            'price' => 8000,
            'category' => 'Entrees',
            'created_by' => 1
        ]);


        KitchenMenuItem::create([
            'name' => ' Chicken Parmesan',
            'description' =>  'Breaded chicken breast topped with marinara sauce and melted mozzarella, served over spaghetti.',
            'price' => 12000,
            'category' => 'Entrees',
            'created_by' => 1
        ]);

        KitchenMenuItem::create([
            'name' => 'Chocolate Brownie Sundae',
            'description' =>  'A warm chocolate brownie topped with vanilla ice cream, chocolate sauce, and whipped cream.',
            'price' => 19500,
            'category' => 'Desserts',
            'created_by' => 2
        ]);



    }
}
