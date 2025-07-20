<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'id' => 1,
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => password_hash('password', PASSWORD_BCRYPT)
        ];
        DB::table('users')->insert($data);
    }
}
