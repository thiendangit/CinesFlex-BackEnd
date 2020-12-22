<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(2)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(CinemasTableSeeder::class);
        $this->call(ScreensTableSeeder::class);
        $this->call(SeatRowsTableSeeder::class);
        $this->call(SeatsTableSeeder::class);
        $this->call(CastersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(LanguegesTableSeeder::class);
        $this->call(MoviesTableSeeder::class);
        $this->call(MovieDetailsTableSeeder::class);
        $this->call(MovieScreensTableSeeder::class);
        $this->call(ProductsTableSeeder::class);


    }
}
