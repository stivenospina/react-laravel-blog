<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => config('app.ADMIN_NAME'),
            'email' => config('app.ADMIN_EMAIL'),
            'password' => Hash::make(config('app.ADMIN_PASS')),
        ]);
    }
}
