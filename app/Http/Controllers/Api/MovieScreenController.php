<?php

namespace App\Http\Controllers\Api;

use App\Models\MovieScreen;
use App\Models\Cinema;
use App\Models\Screen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieScreenController extends Controller
{
    /**
     * Display a listing by day, movie_id, region_id.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTimesByMovieNRegion(Request $request)
    {
        $inputs = $request->all();

        $check = $this->checkExist($inputs, ['region_id']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }

        $listCinema = Cinema::where('region_id', $inputs['region_id'])->with('show_times')->get();
        $listShowTime = [];
        if (isset($inputs['movie_id'])) {
            if(sizeof($listCinema) > 0) {
                foreach($listCinema as $cinema) {
                    if(isset($cinema->show_times)) {
                        foreach($cinema->show_times as $showtime) {
                            if($showtime->movie_id === $inputs['movie_id']) {
                                array_push($listShowTime, $showtime);
                            }
                        }
                        unset($cinema->show_times);
                        $cinema->show_times = $listShowTime;
                    } 
                }
            }
        }

        $response = [
            'data' => $listCinema,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
    }

    /**
     * Display a listing by 5 day, movie_id, cinema_id.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTimesByMovieNCinema(Request $request)
    {
        $inputs = $request->all();

        $check = $this->checkExist($inputs, ['movie_id', 'cinema_id']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }

        $listShowTimeGroupByDay = [];
        $cinema = Cinema::find($inputs['cinema_id'])->with('show_times_in_5_day')->first();
        if(isset($cinema)) {
            // get 5 day from today
            $today = Carbon::now();
            $next5Day = Carbon::now()->addDays(5);
            $dayOfWeeks = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            $list5Day = [];
            while ($today->diffInDays($next5Day)){
                array_push($list5Day, [
                    'day' => $today->day,
                    'day_of_week' => $today->dayOfWeek
                ]);
                $today->addDay();
            }

            // group by day
            foreach($cinema->show_times_in_5_day as $show_time) {
                foreach($list5Day as $key=>$day) {
                    if(!isset($listShowTimeGroupByDay[$key])){
                        $listGroupByDay[$key]['day_of_week'] = $dayOfWeeks[$day['day_of_week']];
                        $listGroupByDay[$key]['day'] =$day['day'];
                        if($day['day'] == $show_time->day) {
                            if(isset($listGroupByDay[$key]['show_times']) && sizeof($listGroupByDay[$key]['show_times']) > 0 && $inputs['movie_id']) {
                                if ($show_time->movie_id === $inputs['movie_id']) {
                                    array_push($listGroupByDay[$key]['show_times'], $show_time);
                                }
                            } else {
                                if ($show_time->movie_id === $inputs['movie_id']) {
                                    $listGroupByDay[$key]['show_times'] = [$show_time];
                                }
                            }
                        }
                    } else {
                        if($day['day'] == $show_time->day) {
                            if(isset($listGroupByDay[$key]['show_times']) && sizeof($listGroupByDay[$key]['show_times']) > 0 && $inputs['movie_id']) {
                                if ($show_time->movie_id === $inputs['movie_id']) {
                                    array_push($listGroupByDay[$key]['show_times'], $show_time);
                                }
                            } else {
                                if ($show_time->movie_id === $inputs['movie_id']) {
                                    $listGroupByDay[$key]['show_times'] = [$show_time];
                                }
                            }
                        }
                    }
                }
            }
        }

        $response = [
            'data' => $listGroupByDay,
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
        $data = MovieScreen::all();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
