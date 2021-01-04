<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Region;

use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Cinema::with('region', 'images')->orderBy('name', 'asc')->paginate(5);
        return view('cinemas.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        return view('cinemas.create', ['collection' => $regions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['name', 'description', 'region_id']);
        $inputs['type'] = 1;
        $inputs['status'] = 1;
        $cinema = Cinema::firstOrCreate($inputs);

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/cinemas', 'public');
            if(isset($path)) {
                $cinema->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('cinemas')->with('message', trans('message.cinemas.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function show(Cinema $cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function edit(Cinema $cinema)
    {
        $regions = Region::all();

        return view('cinemas.edit', ['model' => $cinema, 'collection' => $regions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cinema $cinema)
    {
        $inputs = $request->only(['name', 'description', 'region_id']);

        $cinema->update($inputs);
        $cinema->save();

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/cinemas', 'public');
            if(isset($path)) {
                $cinema->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $cinema->refresh();

        return redirect('cinemas')->with('message', trans('message.cinemas.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cinema $cinema)
    {
        $cinema->images()->delete();
        $cinema->delete();
        return redirect('cinemas')->with('message', trans('message.cinemas.delete_success'));
    }
}
