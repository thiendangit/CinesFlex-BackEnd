<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caster;
use Illuminate\Support\Str;

class CastersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $casters = ['Chris Evans', 'Chris Hemsworth', 'Chris Pratt', 'Robert Downey Jr.', 'Mark Ruffalo'];
        foreach($casters as $caster) {
            $model = new Caster();
            $model->name = $caster;
            $model->description = Str::random(25);
            $model->type = 1;
            $model->status = 1;
            $model->save();
        }
    }
}
