<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleManager = new Role();
        $roleManager->reference = 'admin';
        $roleManager->name = 'Admin';
        $roleManager->type = 1;
        $roleManager->status = 1;
        $roleManager->save();

        $roleEmployee = new Role();
        $roleEmployee->reference = 'customer';
        $roleEmployee->name = 'Customer';
        $roleEmployee->type = 2;
        $roleEmployee->status = 1;
        $roleEmployee->save();

    }
}
