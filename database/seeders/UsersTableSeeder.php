<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleManager  = Role::where('reference', 'admin')->first();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->phone = '0123456789';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('123456'); // 123456
        $admin->remember_token = Str::random(10);
        $admin->point = 0;
        $admin->type = 1;
        $admin->status = 1;
        $admin->save();

        $admin->roles()->attach($roleManager);
    }
}
