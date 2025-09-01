<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan username untuk pengguna pertama
        User::factory()->create([
            'name' => 'Rafi Shidqi',
            'username' => 'rafishidqi', // Menambahkan username
            'email' => 'rafi@gmail.com',
            'password' => Hash::make('rafi'),
        ]);

        // Tambahkan pengguna dummy dengan username
        User::factory()->count(5)->create();
    }
}