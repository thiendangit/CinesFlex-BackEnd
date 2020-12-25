<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Action', 'Adventure'];
        foreach($categories as $category) {
            $model = new Category();
            $model->title = $category;
            $model->description = Str::random(25);
            $model->type = 1;
            $model->status = 1;
            $model->save();
        }
    }
}
