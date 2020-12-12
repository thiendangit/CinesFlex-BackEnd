<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // even is food, odd is drink
        $products = ['Popcorn', 'Cocacola', 'Chicken', 'Mirinda', 'Potato','7up'];
        foreach($products as $key=>$product) {
            $model = new Product();
            $model->reference = 'PRO' . Str::random(6);
            $model->name = $product;
            $model->description = Str::random(100);
            if ($key % 2 == 0) {
                $model->price = rand(43, 52) . '000';
                $model->type = Product::FASTFOOD;
            } else {
                $model->price = rand(20, 25) . '000';
                $model->type = Product::SOFTDRINK;
            }
            $model->status = 1;
            $model->save();
        }
    }
}
