<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Ditambahkan: Import HasFactory
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory; // Ditambahkan: Menggunakan trait HasFactory

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'reason',
        'status', // Pastikan 'status' ada di sini agar bisa di-mass assign
    ];

    /**
     * Get the user who reported.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that was reported.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the comment that was reported.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}