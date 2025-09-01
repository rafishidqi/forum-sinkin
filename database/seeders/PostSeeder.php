<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $category = Category::first();

        Post::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Selamat datang di Forum Sinkin!',
            'slug' => Str::slug('Selamat datang di Forum Sinkin!'),
            'content' => 'Ini adalah postingan pertama. Silakan berdiskusi dan buat komunitas kalian!',
            'type' => 'text',
            'is_published' => true
        ]);
    }
}