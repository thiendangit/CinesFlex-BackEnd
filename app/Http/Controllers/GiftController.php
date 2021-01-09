<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Gift::with('images')->orderBy('title', 'asc')->paginate(5);
        return view('gifts.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['title', 'description', 'coin', 'discount']);
        $inputs['type'] = 1;
        $inputs['status'] = 1;
        $gift = Gift::firstOrCreate($inputs);

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/gifts', 'public');
            if(isset($path)) {
                $gift->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('gifts')->with('message', trans('message.gifts.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        return view('gifts.edit', ['model' => $gift]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {
        $inputs = $request->only(['title', 'description', 'coin', 'discount']);
        $gift->update($inputs);
        $gift->save();

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/gifts', 'public');
            if(isset($path)) {
                $gift->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $gift->refresh();

        return redirect('gifts')->with('message', trans('message.gifts.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        $gift->images()->delete();
        $gift->delete();
        return redirect('gifts')->with('message', trans('message.gifts.delete_success'));
    }
}
