<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pimpinan@loubishop.site'],
            [
                'name' => 'Pimpinan Toko LoubiShop',
                'password' => Hash::make('pimpinan@123'),
                'role' => 'pimpinan',
            ]
        );
    }
}
