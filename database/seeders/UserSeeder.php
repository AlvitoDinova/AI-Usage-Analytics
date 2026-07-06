<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Administrator',
                'email' => 'admin@ainsight.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Manager',
                'email' => 'manager@ainsight.test',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Employee',
                'email' => 'employee@ainsight.test',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
