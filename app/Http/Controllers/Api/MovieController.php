<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Models\MovieDetail;
use Carbon\Carbon;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Search function.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $inputs = $request->all();

        $query = Movie::where('status', 1);
        if(isset($inputs['name'])) {
            $query->where('name', 'like', '%' . $inputs['name']. '%');
        }
        
        $query->with('detail.casters.images', 'detail.categories', 'detail.languages', 'detail.images');
        $data = $query->get();
        
        $response = [
            'data' => $data,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with('detail.casters.images', 'detail.categories', 'detail.languages', 'detail.images')->get();
        $now = Carbon::now();

        $data = [];
        if($movies->count() > 0){
            $listMovieIsNowShowing = [];
            foreach($movies as $movie) {
                if (isset($movie->detail) && $now->gt($movie->detail->date_begin)) {
                    $movie->update(['type' => Movie::IS_COMMING]);
                    $movie->save();
                } else {
                    $movie->update(['type' => Movie::NOW_SHOWING]);
                    $movie->save();
                }

                if(isset($movie->detail) && $now->gt($movie->detail->date_end)) {
                    $movie->update(['status' => 2]); // not available
                    $movie->save();
                } else {
                    $movie->update(['status' => 1]); // available
                    $movie->save();
                }

                if($movie->status == 1) {
                    array_push($data, $movie); 
                }
            }
        }

        $response = [
            'data' => $data,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
