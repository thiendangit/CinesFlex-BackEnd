<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Caster;
use App\Models\Category;
use App\Models\Language;
use App\Models\MovieDetail;
use App\Models\Image;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MovieDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMovie  = Movie::all();
        $listCaster  = Caster::all();
        $listCategory  = Category::all();
        $listLanguage = Language::all();

        // the number in last is a size of array
        $listDirector = ['Jon Watts', 'Ari Aster', 'James Mangold', 'Jordan Peele', 'Martin Scorsese', 'Zack Snyder'];
        $listUrl = ['/storage/images/end-game.jpg'];

        foreach($listMovie as $movie)
        {
            $model = new MovieDetail();
            $model->movie_id = $movie->id;
            $model->description = Str::random(25);
            $model->director = $listDirector[rand(0, sizeof($listDirector) - 1)];
            $model->duration_min = rand(183, 205);
            $model->date_begin = Carbon::now();
            $model->date_end = Carbon::now()->addMonth(1);
            $model->rated = rand(10, 18);
            $model->trailer_path = json_encode('https://www.youtube.com/watch?v=mrcONTmLm5k');
            $model->price = 50000;
            $model->rating = rand(7, 12);
            $model->save();

            $model->casters()->attach($listCaster, ['name'=> 'Actor']);
            $model->categories()->attach($listCategory);
            $model->languages()->attach($listLanguage);

            $image = new Image();
            $image->url = $listUrl[0];
            $model->images()->save($image);
        }
    }
}
