<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;
use App\Models\Region;
use App\Models\Image;
use Illuminate\Support\Str;

class CinemasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listRegion  = Region::all();
        $listUrl = ['/storage/images/cinema.jpg'];

        foreach($listRegion as $region)
        {
            for($i = 0; $i < 2; $i++)
            {
                $model = new Cinema();
                $model->region_id = $region->id;
                $model->name = $region->name . ' ' .$i;
                $model->description = Str::random(100);
                $model->type = 1;
                $model->status = 1;
                $model->save();

                $image = new Image();
                $image->url = $listUrl[0];
                $model->images()->save($image);
            }
        }
    }
}
