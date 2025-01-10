<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ferry Febrian',
            'email' => 'ferryfebrian@gmail.com',
            'password' => 'Ferry123?',
            'gender' => 'Male',
            'hobbies' => 'Turu, Sleep, Tidur',
            'ig_username' => 'https://www.instagram.com/ferry',
            'mobile_number' => '08123456789',
            'registration_fee' => '10000'
        ]);

        for ($i = 1; $i < 6; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => 'user123',
                'gender' => rand(0, 2) == 0 ? 'Female' : 'Male',
                'hobbies' => rand(0, 2) == 0 ? ('Makan, Tidur, Main') : ('Makan, Minum, Belajar'),
                'ig_username' => 'https://www.linkedin.com/in/diki',
                'mobile_number' => '12345678900',
                'registration_fee' => random_int(100000, 125000)
            ]);
        }
    }
}
