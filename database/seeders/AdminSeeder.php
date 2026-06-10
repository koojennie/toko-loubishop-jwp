<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@loubishop.site'],
            [
                'name' => 'Admin Toko LoubiShop',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        Category::create(['name' => 'Besi Beton']);
        Category::create(['name' => 'Baja Ringan']);
        Category::create(['name' => 'Pipa Besi']);

        Product::create([
            'category_id' => 1,
            'code' => 'BJ-001',
            'name' => 'Besi Beton 10 mm',
            'unit' => 'batang',
            'stock' => 25,
            'minimum_stock' => 10,
        ]);
    }
}
