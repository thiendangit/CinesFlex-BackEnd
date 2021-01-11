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

        $movie_id = $inputs['movie_id'] ?? '';
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $listCinema = Cinema::where('region_id', $inputs['region_id'])->with(['images','show_times' => function($query) use ($movie_id, $today, $tomorrow) {
            if($movie_id !== '') {
                $query->where('movie_id', $movie_id);
            }   
            $query->whereDate('show_time', '>=', $today);
            $query->whereDate('show_time', '<', $tomorrow);
            $query->orderBy('show_time', 'asc');
        }])->get();

        $data = [];
        if(sizeof($listCinema)) {
            foreach($listCinema as $cinema) {
                $showTime = [];
                if($cinema->show_times) {
                    foreach($cinema->show_times as $show_time) {
                        array_push($showTime, [
                            'id' => $show_time->id,
                            'movie_id' => $show_time->movie_id,
                            'screen_id' => $show_time->screen_id,
                            'cinema_id' => $show_time->cinema_id,
                            'show_time' => $show_time->show_time->format('H:i'),
                            'type' => $show_time->type,
                            'status' => $show_time->status,
                            'day' => $show_time->day,
                            'day_of_week' => $show_time->day_of_week,
                            'price' => $show_time->price,
                            'date' => $show_time->date,
                        ]);
                    }
                }
                array_push($data, [
                    'id' => $cinema->id,
                    'region_id' => $cinema->region_id,
                    'name' => $cinema->name,
                    'description' => $cinema->description,
                    'type' => $cinema->type,
                    'status' => $cinema->status,
                    'show_times' => $showTime,
                    'images' => $cinema->images
                
                ]);
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

        // get 5 day from today
        $today = Carbon::today();
        $next5Day = Carbon::today()->addDays(5);

        $listGroupByDay = [];
        $movie_id = $inputs['movie_id'];
        $cinemas = Cinema::where('id', $inputs['cinema_id'])->with(['show_times' => function($query) use ($movie_id, $today, $next5Day) {
            $query->where('movie_id', $movie_id);
            $query->whereBetween('show_time',[$today, $next5Day]);
            $query->orderBy('show_time', 'asc');
        }])->get();

        $dayOfWeeks = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $list5Day = [];
        while ($today->diffInDays($next5Day)){
            array_push($list5Day, [
                'day' => $today->day,
                'day_of_week' => $today->dayOfWeek
            ]);
            $today->addDay();
        }

        foreach($list5Day as $key=>$day) {
            $listGroupByDay[$key]['day_of_week'] = $dayOfWeeks[$day['day_of_week']];
            $listGroupByDay[$key]['day'] =$day['day'];
        }

        if(sizeof($cinemas) > 0) {
            foreach($cinemas as $cinema) {
               // group by day
                foreach($cinema->show_times as $show_time) {
                    $showTime = [
                        'id' => $show_time->id,
                        'movie_id' => $show_time->movie_id,
                        'screen_id' => $show_time->screen_id,
                        'cinema_id' => $show_time->cinema_id,
                        'show_time' => $show_time->show_time->format('H:i'),
                        'type' => $show_time->type,
                        'status' => $show_time->status,
                        'day' => $show_time->day,
                        'day_of_week' => $show_time->day_of_week,
                        'price' => $show_time->price,
                        'date' => $show_time->date,
                    ];

                    foreach($list5Day as $key=>$day) {
                        if(!isset($listGroupByDay[$key])){
                            if($day['day'] == $show_time->day) {
                                if(isset($listGroupByDay[$key]['show_times']) && sizeof($listGroupByDay[$key]['show_times']) > 0 && $inputs['movie_id']) {
                                    if ($show_time->movie_id === $inputs['movie_id']) {
                                        array_push($listGroupByDay[$key]['show_times'], $showTime);
                                    }
                                } else {
                                    if ($show_time->movie_id === $inputs['movie_id']) {
                                        $listGroupByDay[$key]['show_times'] = [$showTime];
                                    }
                                }
                            }
                        } else {
                            if($day['day'] == $show_time->day) {
                                if(isset($listGroupByDay[$key]['show_times']) && sizeof($listGroupByDay[$key]['show_times']) > 0 && $inputs['movie_id']) {
                                    if ($show_time->movie_id === $inputs['movie_id']) {
                                        array_push($listGroupByDay[$key]['show_times'], $showTime);
                                    }
                                } else {
                                    if ($show_time->movie_id === $inputs['movie_id']) {
                                        $listGroupByDay[$key]['show_times'] = [$showTime];
                                    }
                                }
                            }
                        }
                    }
                    $showTime = [];
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
