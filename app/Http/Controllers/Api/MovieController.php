<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Models\MovieDetail;

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
        $data = Movie::with('detail.casters.images', 'detail.categories', 'detail.languages', 'detail.images')->get();

        // if($data->count > 0){
        //     $listMovieIsNowShowing = [];
        //     foreach($data as $movie) {
        //         if( ) {

        //         }
        //     }
        // }

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
