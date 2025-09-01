<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategoryFollower extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id'];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}