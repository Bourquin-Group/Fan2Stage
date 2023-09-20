<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'Admin',
                'email'     => 'admin123@yopmail.com',
                'password'  =>  Hash::make('admin@123'),
                'user_type' => 'admin',
                'status'    =>  1
            ]
        ]);

    }
}
