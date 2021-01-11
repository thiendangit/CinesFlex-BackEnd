<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use App\Models\Cinema;
use App\Models\SeatRow;
use App\Models\Seat;

use Illuminate\Http\Request;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Screen::with('cinema')->orderBy('name', 'asc')->paginate(5);
        return view('screens.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cinema = Cinema::all();
        return view('screens.create', ['collection' => $cinema]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['name', 'description', 'cinema_id']);
        $inputs['type'] = 1;
        $inputs['status'] = 1;
        $screen = Screen::firstOrCreate($inputs);
        $listSeatRow  = SeatRow::all();
        $vipCol = [1, 2, 3, 4];
        $vipRow = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach($listSeatRow as $seatRow) {
            for($i = 0; $i <= 5; $i++) {
                if(in_array($i, $vipCol) && in_array($seatRow->reference, $vipRow)) {
                    $type = Seat::VIP;
                } else {
                    $type = Seat::NORMAL;
                }
                $model = new Seat();
                $model->seat_row_id = $seatRow->id;
                $model->screen_id = $screen->id;
                $model->name = $seatRow->reference . ($i + 1);
                $model->type = $type;
                $model->status = 1;
                $model->save();
            }
        }

        return redirect('screens')->with('message', trans('message.screens.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function show(Screen $screen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function edit(Screen $screen)
    {
        return view('screens.edit', ['model' => $screen]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Screen $screen)
    {
        $inputs = $request->only(['name', 'description']);

        $screen->update($inputs);
        $screen->save();
        $screen->refresh();

        return redirect('screens')->with('message', trans('message.screens.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Screen $screen)
    {
        $screen->seats()->detach();
        $screen->delete();
        return redirect('screens')->with('message', trans('message.screens.delete_success'));
    }
}
