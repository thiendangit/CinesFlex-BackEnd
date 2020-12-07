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
        for($i = 0; $i < 2; $i++) {
            $model = new Region();
            $model->name = Str::random(10);
            $model->description = Str::random(100);
            $model->type = 1;
            $model->status = 1;
            $model->save();
        }
    }
}
