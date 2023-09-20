<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
       $this->call(UserTableSeeder::class);
            // DB::table('users')->insert([
            //     [
            //         'name'      => 'Admin',
            //         'email'     => 'admin@yopmail.com',
            //         'password'  =>  Hash::make('admin@123'),
            //         'user_type' => 'admin',
            //         'status'    =>  1
            //     ]
            // ]);
    }
}
