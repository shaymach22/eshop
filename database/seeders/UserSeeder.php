<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@shop.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'User Test',
            'email'             => 'user@shop.com',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'email_verified_at' => now(),
        ]);
    }
}