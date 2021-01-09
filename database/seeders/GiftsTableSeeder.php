<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\Gift;

class GiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listUrl = ['/storage/images/promotion.jpg'];
        for($i = 0; $i < 6; $i++) {
            $model = new Gift();
            $model->title = Str::random(15);
            $model->description = Str::random(100);
            $model->coin = 100; // integer
            $model->discount = 10; // percent
            $model->type = 1;
            $model->status = 1;
            $model->save();

            $image = new Image();
            $image->url = $listUrl[0];
            $model->images()->save($image);
        }
    }
}
