<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;
use App\Models\Screen;
use Illuminate\Support\Str;

class ScreensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listCinema  = Cinema::all();
        foreach($listCinema as $cinema)
        {
            for($i = 0; $i < 2; $i++)
            {
                $model = new Screen();
                $model->cinema_id = $cinema->id;
                $model->name = 'Screen ' . ($i + 1);
                $model->description = Str::random(25);
                $model->type = 1;
                $model->status = 1;
                $model->save();
            }
        }
    }
}
