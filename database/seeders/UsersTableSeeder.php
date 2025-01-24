<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $super = Role::where('name','super')->first();

        $user = new User();
        $user->name = "Sidharth";
        $user->email = "sidharth@startupmission.in";
        $user->role_id = $super->id;
        $user->save();

    }
}
