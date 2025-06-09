<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'firstname' => 'Admin',
                'lastname' => 'One',
                'email' => 'lawrencebaron027+1@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Admin',
                'lastname' => 'Two',
                'email' => 'lawrencebaron027+2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Social',
                'lastname' => 'WorkerOne',
                'email' => 'lawrencebaron027+3@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'social-worker',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Social',
                'lastname' => 'WorkerTwo',
                'email' => 'lawrencebaron027+4@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'social-worker',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}