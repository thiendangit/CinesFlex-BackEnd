<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Caster;
use App\Models\Category;
use App\Models\Language;
use App\Models\MovieDetail;
use App\Models\Screen;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Movie::with('detail', 'detail.images')->orderBy('name', 'asc')->paginate(5);
        return view('movies.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $casters = Caster::all() ?? [];
        $categories = Category::all() ?? [];
        $languages = Language::all() ?? [];
        $cinemas = Cinema::all() ?? [];
        for($i = 0; $i < 24; $i++) {
            $showTimes[$i] = (strlen($i) == 1 ? '0' . $i : $i) . ':' . '00';
        }

        $listCinema = [];
        if(sizeof($cinemas) > 0) {
            foreach($cinemas as $cinema) {
                $screens = [];
                if($cinema->screens && sizeof($cinema->screens) > 0) {
                    foreach($cinema->screens as $screen) {
                        array_push($screens, [
                            'id' => $screen->id,
                            'name' => $screen->name
                        ]);
                    }
                }

                array_push($listCinema, [
                    'id' => $cinema->id,
                    'name' => $cinema->name,
                    'children' => $screens
                ]);
            }
        }
        return view('movies.create', [
            'casters' => $casters, 
            'categories' => $categories, 
            'languages' => $languages, 
            'screens' => $listCinema, 
            'show_times' => $showTimes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only([
            'name', 
            'description', 
            'date_begin', 
            'date_end', 
            'caster_ids', 
            'category_ids', 
            'language_ids', 
            'show_times', 
            'director', 
            'duration_min',
            'trailer_path',
            'rated',
            'price',
            'rating',
            'screen_ids'
        ]);
        $inputs['type'] = 1;
        $inputs['status'] = 1;

        $movie = new Movie();
        $movie->name = $inputs['name'];
        $movie->type = 1;
        $movie->status = 1;
        $movie->save();

        $movieDetail = new MovieDetail();
        $movieDetail->movie_id = $movie->id;
        $movieDetail->description = $inputs['description'];
        $movieDetail->director = $inputs['director'];
        $movieDetail->duration_min = $inputs['duration_min'];
        $movieDetail->date_begin = $inputs['date_begin'];
        $movieDetail->date_end = $inputs['date_end'];
        $movieDetail->rated = $inputs['rated'];
        $movieDetail->trailer_path = $inputs['trailer_path'];
        $movieDetail->price = $inputs['price'];
        $movieDetail->rating = $inputs['rating'];
        $movieDetail->save();

        if(isset($inputs['caster_ids'])) {
            $listCaster = Caster::whereIn('id', $inputs['caster_ids'])->get();
            $movieDetail->casters()->attach($listCaster, ['name'=> 'Actor']);
        }

        if(isset($inputs['category_ids'])) {
            $listCategory = Category::whereIn('id', $inputs['category_ids'])->get();
            $movieDetail->categories()->attach($listCategory);
        }

        if(isset($inputs['language_ids'])) {
            $listLanguage = Language::whereIn('id', $inputs['language_ids'])->get();
            $movieDetail->languages()->attach($listLanguage);
        }

        if(isset($inputs['show_times']) && isset($inputs['screen_ids'])) {
            for($i = 0; $i < 24; $i++) {
                $showTimes[$i] = (strlen($i) == 1 ? '0' . $i : $i) . ':' . '00';
            }

            $date_begin = new Carbon($inputs['date_begin']);
            $date_end = new Carbon($inputs['date_end']);
            $listDateTime = [];
            while ($date_begin->diffInDays($date_end)){
                array_push($listDateTime, $date_begin->toDateString());
                $date_begin->addDay(1);
            }

            $listShowTimeInputs = [];
            // each screen have many show time
            foreach ($inputs['screen_ids'] as $screen_id) {
                $screen = Screen::find($screen_id);
                foreach ($listDateTime as $date) {
                    foreach ($inputs['show_times'] as $showTime) {
                        $date_time = $date . ' ' .$showTimes[$showTime] . ':00';
                        array_push($listShowTimeInputs, [
                            'movie_id' => $movie->id,
                            'screen_id' => $screen_id,
                            'cinema_id' => $screen->cinema_id,
                            'show_time' => new Carbon($date_time),
                            'type' => 1,
                            'status' => 1,
                        ]);
                    }
                    
                }
            }
            $movie->show_times()->createMany($listShowTimeInputs);
        }
    
        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/movies', 'public');
            if(isset($path)) {
                $movie->detail->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('movies')->with('message', trans('message.movies.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $casters = Caster::all() ?? [];
        $categories = Category::all() ?? [];
        $languages = Language::all() ?? [];
        $cinemas = Cinema::all() ?? [];

        for($i = 0; $i < 24; $i++) {
            $showTimes[$i] = (strlen($i) == 1 ? '0' . $i : $i) . ':' . '00';
        }

        $castersMovie = [];
        if($movie->detail->casters && sizeof($movie->detail->casters) > 0) {
            foreach($movie->detail->casters as $caster) {
                array_push($castersMovie, $caster->id);
            }
        }

        $categoriesMovie = [];
        if($movie->detail->categories && sizeof($movie->detail->categories) > 0) {
            foreach($movie->detail->categories as $category) {
                array_push($categoriesMovie, $category->id);
            }
        }

        $languagesMovie = [];
        if($movie->detail->languages && sizeof($movie->detail->languages) > 0) {
            foreach($movie->detail->languages as $language) {
                array_push($languagesMovie, $language->id);
            }
        }

        $showTimesMovie = [];
        if($movie->show_times && sizeof($movie->show_times) > 0) {
            foreach($movie->show_times as $showTime) {
                array_push($showTimesMovie, $showTime->show_time->format('H:i'));
            }
        }

        $listCinema = [];
        if(sizeof($cinemas) > 0) {
            foreach($cinemas as $cinema) {
                $screens = [];
                if($cinema->screens && sizeof($cinema->screens) > 0) {
                    foreach($cinema->screens as $screen) {
                        array_push($screens, [
                            'id' => $screen->id,
                            'name' => $screen->name
                        ]);
                    }
                }

                array_push($listCinema, [
                    'id' => $cinema->id,
                    'name' => $cinema->name,
                    'children' => $screens
                ]);
            }
        }

        $screensMovie = [];
        if($movie->show_times && sizeof($movie->show_times) > 0) {
            foreach($movie->show_times as $showTime) {
                if(!isset($screensMovie[$showTime->screen_id])) {   
                    $screensMovie[$showTime->screen_id] = $showTime->screen_id;
                }
            }
        }

        return view('movies.edit', [
            'model' => $movie,
            'casters' => $casters, 
            'castersMovie' => $castersMovie ?? [], 
            'categories' => $categories, 
            'categoriesMovie' => $categoriesMovie ?? [], 
            'languages' => $languages, 
            'languagesMovie' => $languagesMovie ?? [], 
            'show_times' => $showTimes,
            'showTimesMovie' => $showTimesMovie ?? [], 
            'screens' => $listCinema,
            'screensMovie' => $screensMovie
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $inputs = $request->only([
            'name', 
            'description', 
            'date_begin', 
            'date_end', 
            'caster_ids', 
            'category_ids', 
            'language_ids', 
            'show_times', 
            'director', 
            'duration_min',
            'trailer_path',
            'rated',
            'price',
            'rating',
            'screen_ids'
        ]);

        $movie->update(['name' => $inputs['name']]);
        $movie->save();
        $movie->detail->update([
            'description' => $inputs['description'],
            'director' => $inputs['director'],
            'duration_min' => $inputs['duration_min'],
            'date_begin' => $inputs['date_begin'],
            'date_end' => $inputs['date_end'],
            'rated' => $inputs['rated'],
            'trailer_path' => $inputs['trailer_path'],
            'price' => $inputs['price'],
            'rating' => $inputs['rating']
        ]);
        $movie->detail->save();

        if(isset($inputs['caster_ids'])) {
            $listCaster = Caster::whereIn('id', $inputs['caster_ids'])->get();
            $movie->detail->casters()->sync($listCaster, ['name'=> 'Actor']);
        }

        if(isset($inputs['category_ids'])) {
            $listCategory = Category::whereIn('id', $inputs['category_ids'])->get();
            $movie->detail->categories()->sync($listCategory);
        }

        if(isset($inputs['language_ids'])) {
            $listLanguage = Language::whereIn('id', $inputs['language_ids'])->get();
            $movie->detail->languages()->sync($listLanguage);
        }

        if(isset($inputs['show_times']) && isset($inputs['screen_ids'])) {
            for($i = 0; $i < 24; $i++) {
                $showTimes[$i] = (strlen($i) == 1 ? '0' . $i : $i) . ':' . '00';
            }

            $date_begin = new Carbon($inputs['date_begin']);
            $date_end = new Carbon($inputs['date_end']);
            $listDateTime = [];
            while ($date_begin->diffInDays($date_end)){
                array_push($listDateTime, $date_begin->toDateString());
                $date_begin->addDay();
            }

            $listShowTimeInputs = [];
            // each screen have many show time
            foreach ($inputs['screen_ids'] as $screen_id) {
                $screen = Screen::find($screen_id);
                foreach ($listDateTime as $date) {
                    foreach ($inputs['show_times'] as $showTime) {
                        $date_time = $date . ' ' .$showTimes[$showTime] . ':00';
                        array_push($listShowTimeInputs, [
                            'movie_id' => $movie->id,
                            'screen_id' => $screen_id,
                            'cinema_id' => $screen->cinema_id,
                            'show_time' => new Carbon($date_time),
                            'type' => 1,
                            'status' => 1,
                        ]);
                    }
                    
                }
            }
            $movie->show_times()->delete();
            $movie->show_times()->createMany($listShowTimeInputs);
        }

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/movies', 'public');
            if(isset($path)) {
                $movie->detail->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $movie->refresh();

        return redirect('movies')->with('message', trans('message.movies.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->detail->images()->delete();
        $movie->detail->casters()->detach();
        $movie->detail->categories()->detach();
        $movie->detail->languages()->detach();
        $movie->show_times()->delete();
        $movie->detail->delete();
        $movie->delete();
        return redirect('movies')->with('message', trans('message.movies.delete_success'));
    }
}
