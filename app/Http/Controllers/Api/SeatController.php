<?php

namespace App\Http\Controllers\Api;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display a list seat by screen_id,.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListByScreen(Request $request)
    {
        $inputs = $request->all();

        $check = $this->checkExist($inputs, ['screen_id']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }

        $listSeat = [];
        $seats = Seat::where('screen_id', $inputs['screen_id'])->with('seatRow')->orderBy('name')->get();
        if(sizeof($seats) > 0){
            foreach($seats as $seat) {
                array_push($listSeat, [
                    'id' => $seat->id,
                    'name' => $seat->name,
                    'seat_row' => $seat->seatRow->reference,
                    'type' => $seat->type,
                    'status' => $seat->status,
                    'fee_percent' => $seat->fee_percent ?? 0
                ]);
            }
        }

        $response = [
            'data' => $listSeat,
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
        $data = Seat::all();
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
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function show(Seat $seat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function edit(Seat $seat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seat $seat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seat $seat)
    {
        //
    }

    private function checkExist($inputs, array $array) {
        foreach($array as $key){
            if(!isset($inputs[$key])){
                return [
                    'failed' => true,
                    'message' => $key
                ];
            }
        }
        return [
            'failed' => false
        ];
    }
}
