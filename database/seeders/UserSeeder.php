<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('123'),
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No.1, Kota Contoh',
            'city' => 'Purwokerto',
            'pos' => '111',
        ]);

        User::create([
            'name' => 'Imran',
            'email' => 'user2@example.com',
            'password' => Hash::make('123'),
            'phone' => '0818181',
            'address' => 'Jl. IN No.1, Kota IN',
            'city' => 'pewete',
            'pos' => '222',
        ]);
    }
}
