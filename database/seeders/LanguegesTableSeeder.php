<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use Illuminate\Support\Str;

class LanguegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = ['Vietnamese', 'English'];
        foreach($languages as $language) {
            $model = new Language();
            $model->title = $language;
            $model->description = Str::random(25);
            $model->type = rand(Language::SUB ,Language::DEMONSTRATOR);
            $model->status = 1;
            $model->save();
        }
    }
}
