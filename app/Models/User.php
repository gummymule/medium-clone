<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $fillable = [
        'name',
        'username',
        'bio',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100)
              ->sharpen(10);
              
        $this->addMediaConversion('avatar')
              ->width(400)
              ->height(400)
              ->sharpen(10);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
             ->singleFile()
             ->useDisk('public')
             ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function getAvatarUrl()
    {
        if ($this->hasMedia('avatar')) {
            return $this->getFirstMediaUrl('avatar', 'avatar');
        }
        return null;
    }

    public function isFollowedBy(?User $user)
    {
        if (!$user) {
            return false;
        }
        return $this->followers->contains($user);
    }

    public function hasClapped(Post $post)
    {
        return $post->claps()->where('user_id', $this->id)->exists();
    }
}