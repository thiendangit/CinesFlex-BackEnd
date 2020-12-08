<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;
use App\Models\Movie;
use App\Models\MovieScreen;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MovieScreensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMovie  = Movie::all();
        $listScreen  = Screen::all();
        foreach($listScreen as $screen)
        {
            $hour = 1;
            foreach($listMovie as $movie)
            {
                $model = new MovieScreen();
                $model->movie_id = $movie->id;
                $model->screen_id = $screen->id;
                $model->show_time = Carbon::now()->addHour($hour);
                $model->type = 1;
                $model->status = 1;
                $model->save();
                $hour++;
            }
        }
    }
}
