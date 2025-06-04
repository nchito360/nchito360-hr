<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'John Admin',
            'email' => 'admin@pikotech.com',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'company' => 'Piko Tech Services',
        ]);

        User::create([
            'name' => 'Alice HR',
            'email' => 'alice@tradesmart.com',
            'password' => Hash::make('password'),
            'company_id' => 2,
            'company' => 'Tradesmart Supplies Ltd',
        ]);

        User::create([
            'name' => 'Bob Developer',
            'email' => 'bob@zamtech.com',
            'password' => Hash::make('password'),
            'company_id' => 3,
            'company' => 'ZamTech Innovations',
        ]);
    }
}
