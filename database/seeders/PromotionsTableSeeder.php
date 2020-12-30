<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromotionsTableSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 6; $i++) {
            $model = new Promotion();
            $model->title = Str::random(15);
            $model->description = Str::random(100);
            $model->date_begin = Carbon::now();
            $model->date_end = Carbon::now()->addDay($i);
            $model->type = 1;
            $model->status = 1;
            $model->save();

            $modelVoucher = new Voucher();
            $modelVoucher->reference = Str::random(6);
            $modelVoucher->title = $model->title;
            $modelVoucher->value = rand(10, 20);
            $modelVoucher->type = 1;
            $modelVoucher->status = 1;
            $model->vouchers()->save($modelVoucher);
        }
    }
}
