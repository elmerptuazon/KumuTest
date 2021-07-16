<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'=>'6a72de8b-4db1-4d8a-ab43-1cb4873451fr',
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('test'),
        ]);
    }
}
