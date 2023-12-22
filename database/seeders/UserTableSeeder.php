<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Delete user if exists in database
        User::truncate();

        // 1. Register admin user
        $user = new User();

        $user->fill([
            'username' => 'admin',
            'email' => 'admin2023@gmail.com',
            'password' => '12345678',
            'admin' => true,
        ]);

        // Save user
        $user->save();

        $user->profile()->create([

            'name' => 'admon',
            'lastname' => 'superadmin',
            'address' => 'calle admin 123', 
            'phone' => '555-5555', 
            'gender' => 'N/A',

        ]);

    }
}
