<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username', // Kolom 'username'
        'email',
        'password',
        'avatar', // Kolom 'avatar'
        'bio',     // Kolom 'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The posts that belong to the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The votes that belong to the user.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * The saved posts that belong to the user.
     */
    public function savedPosts()
    {
        return $this->hasMany(SavedPost::class);
    }

    /**
     * The notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function followCategory($categoryId)
    {
        $this->categories()->attach($categoryId);
    }

    public function unfollowCategory($categoryId)
    {
        $this->categories()->detach($categoryId);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_category_followers');
    }


    /**
     * Ensure the username is unique and properly validated.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Ensure username is unique
            $user->username = strtolower($user->username);
        });
    }
}