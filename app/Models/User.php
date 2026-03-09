<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',        
        'social',       
        'role',         
        'banned',       
        'ban_reason',   
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
     * @return array<string, string>
     */
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

 
    public function isUser(): bool
    {
        return $this->role === 'user';
    }


    public function isBanned(): bool
    {
        return $this->banned;
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

    /**
     * Скоуп для активных пользователей (не забаненных)
     */
    public function scopeActive($query)
    {
        return $query->where('banned', false);
    }

    /**
     * Скоуп для забаненных пользователей
     */
    public function scopeBanned($query)
    {
        return $query->where('banned', true);
    }

    /**
     * Скоуп для администраторов
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Скоуп для обычных пользователей
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * Получить количество активных объявлений пользователя
     */
    public function getActivePostsCountAttribute(): int
    {
        return $this->posts()->where('is_active', true)->count();
    }

    /**
     * Получить количество объявлений пользователя (пропавших)
     */
    public function getLostPostsCountAttribute(): int
    {
        return $this->posts()->where('status', 'lost')->count();
    }

    /**
     * Получить количество объявлений пользователя (найденных)
     */
    public function getFoundPostsCountAttribute(): int
    {
        return $this->posts()->where('status', 'found')->count();
    }

    /**
     * Получить количество избранных объявлений
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }

    /**
     * Проверка, добавил ли пользователь конкретное объявление в избранное
     */
    public function hasFavorited(Post $post): bool
    {
        return $this->favorites()->where('post_id', $post->id)->exists();
    }

    /**
     * Бан пользователя с указанием причины
     */
    public function ban(string $reason): bool
    {
        return $this->update([
            'banned' => true,
            'ban_reason' => $reason
        ]);
    }

    /**
     * Разбан пользователя
     */
    public function unban(): bool
    {
        return $this->update([
            'banned' => false,
            'ban_reason' => null
        ]);
    }
}