<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('Users')->insert([
            'email' => 'pelatih@gmail.com',
            'password' => Hash::make('pelatih123'), 
            'role' => 'trainer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
