<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeatRow;
use Illuminate\Support\Str;

class SeatRowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alphaBet = ['A', 'B', 'C', 'D', 'E'];
        foreach($alphaBet as $char) {
            $model = new SeatRow();
            $model->reference = $char;
            $model->name = $char;
            $model->description = Str::random(25);
            $model->save();
        }
    }
}
