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

    }
}
