<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;
use App\Models\Region;
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
        foreach($listRegion as $region)
        {
            for($i = 0; $i < 2; $i++)
            {
                $model = new Cinema();
                $model->region_id = $region->id;
                $model->name = Str::random(10);
                $model->description = Str::random(100);
                $model->type = 1;
                $model->status = 1;
                $model->save();
            }
        }
    }
}
