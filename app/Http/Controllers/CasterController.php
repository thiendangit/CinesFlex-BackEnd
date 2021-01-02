<?php

namespace App\Http\Controllers;

use App\Models\Caster;
use Illuminate\Http\Request;

class CasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Caster::with('images')->orderBy('name', 'asc')->paginate(5);
        return view('casters.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('casters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['name', 'description']);
        $inputs['type'] = 1;
        $inputs['status'] = 1;
        $caster = Caster::firstOrCreate($inputs);

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/casters', 'public');
            if(isset($path)) {
                $caster->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('casters')->with('message', trans('message.casters.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caster  $caster
     * @return \Illuminate\Http\Response
     */
    public function show(Caster $caster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caster  $caster
     * @return \Illuminate\Http\Response
     */
    public function edit(Caster $caster)
    {
        return view('casters.edit', ['model' => $caster]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caster  $caster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caster $caster)
    {
        $inputs = $request->only(['name', 'description']);

        $caster->update($inputs);
        $caster->save();

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/casters', 'public');
            if(isset($path)) {
                $caster->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $caster->refresh();

        return redirect('casters')->with('message', trans('message.casters.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caster  $caster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caster $caster)
    {
        $caster->images()->delete();
        $caster->movie_details()->detach();
        $caster->delete();
        return redirect('casters')->with('message', trans('message.casters.delete_success'));
    }
}
