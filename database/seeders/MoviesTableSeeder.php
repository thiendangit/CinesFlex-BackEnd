<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use Illuminate\Support\Str;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movieNames = ['Justice League 2', 'Justice League', 'The Arrows', 'Spider-Man: Far From Home', 'Spider-Man: Home Coming', 'The Batman', 'The Flash'];
        foreach($movieNames as $name) {
            $model = new Movie();
            $model->name = $name;
            $model->type = rand(Movie::NOWSHOWING, Movie::ISCOMMING);
            $model->status = 1;
            $model->save();
        }
    }
}
