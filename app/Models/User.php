<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'about',
        'social',       
        'role',         
        'banned',       
        'ban_reason',   
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned' => 'boolean',  
        ];
    }


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }


    public function favoritePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorites')
                    ->withTimestamps();
    }


    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBanned(): bool
    {
        return $this->banned;
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }


    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

 
    public function getContactInfoAttribute(): array
    {
        $contacts = [];
        
        if ($this->phone) {
            $contacts['phone'] = $this->phone;
        }
        
        if ($this->social) {
            $contacts['social'] = $this->social;
        }
        
        if ($this->email) {
            $contacts['email'] = $this->email;
        }
        
        return $contacts;
    }


    public function scopeActive($query)
    {
        return $query->where('banned', false);
    }


    public function scopeBanned($query)
    {
        return $query->where('banned', true);
    }


    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }


    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }


    public function getActivePostsCountAttribute(): int
    {
        return $this->posts()->where('is_active', true)->count();
    }


    public function getLostPostsCountAttribute(): int
    {
        return $this->posts()->where('status', 'lost')->count();
    }


    public function getFoundPostsCountAttribute(): int
    {
        return $this->posts()->where('status', 'found')->count();
    }


    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }


    public function hasFavorited(Post $post): bool
    {
        return $this->favorites()->where('post_id', $post->id)->exists();
    }


    public function ban(string $reason): bool
    {
        return $this->update([
            'banned' => true,
            'ban_reason' => $reason
        ]);
    }


    public function unban(): bool
    {
        return $this->update([
            'banned' => false,
            'ban_reason' => null
        ]);
    }
}