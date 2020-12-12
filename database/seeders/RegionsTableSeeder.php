<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use Illuminate\Support\Str;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = ['Ha Noi', 'Ho Chi Minh'];
        foreach($regions as $region) {
            $model = new Region();
            $model->name = $region;
            $model->description = Str::random(100);
            $model->type = 1;
            $model->status = 1;
            $model->save();
        }
    }
}
