<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [

            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'address' => fake()->address(),
                'avatar' => fake()->image(),
                'phone' => fake()->phoneNumber(),
                'password' => static::$password ??= Hash::make('123'),
            ],
            [
                'name' => 'teacher',
                'email' => 'teacher@gmail.com',
                'role' => 'teacher',
                'address' => fake()->address(),
                'avatar' => fake()->image(),
                'phone' => fake()->phoneNumber(),
                'password' => static::$password ??= Hash::make('123'),
            ],
            [
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'role' => 'student',
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'avatar' => fake()->image(),
                'password' => static::$password ??= Hash::make('123'),
            ],
        ];
        User::insert($users);
    }
}
