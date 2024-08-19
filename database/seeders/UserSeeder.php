<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@simcorp.com',
            'password' => Hash::make('test@123'), // Hash the password
        ]);
    }
}
