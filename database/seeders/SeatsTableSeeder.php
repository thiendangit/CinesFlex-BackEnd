<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\SeatRow;
use App\Models\Screen;
use Illuminate\Support\Str;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listScreen  = Screen::all();
        $listSeatRow  = SeatRow::all();

        foreach($listScreen as $screen) {
            foreach($listSeatRow as $seatRow) {
                for($i = 0; $i < 2; $i++) {
                    $model = new Seat();
                    $model->seat_row_id = $seatRow->id;
                    $model->screen_id = $screen->id;
                    $model->name = $seatRow->reference . ($i + 1);
                    $model->description = Str::random(25);
                    $model->type = 1;
                    $model->status = 1;
                    $model->save();
                }
            }
        }
    }
}
