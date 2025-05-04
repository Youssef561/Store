<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
           'name' => 'Youssef Khaled',
           'email' => 'youssef@gmail.com',
           'password' => Hash::make('password'),
           'phone_number' => '01012345678'
        ]);

        // another way to insert
        DB::table('users')->insert([
           'name' => 'Ahmed',
           'email' => 'ahmed@gmail.com',
           'password' => Hash::make('password'),
           'phone_number' => '01012345679'
        ]);

    }
}
