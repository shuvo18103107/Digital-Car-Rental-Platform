<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Owner — Faisal Rasheed
        User::updateOrCreate(
            ['email' => 'faisalrasheed1994@gmail.com'],
            [
                'name' => 'Faisal Rasheed',
                'password' => Hash::make('password'),
            ]
        );

        // Admin — Dayyan
        User::updateOrCreate(
            ['email' => 'infodayyan786@gmail.com'],
            [
                'name' => 'Dayyan',
                'password' => Hash::make('password'),
            ]
        );
    }
}
