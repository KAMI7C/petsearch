<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'category_id', 'breed_id', 'district_id',
        'name', 'gender', 'age', 'description', 'lost_date', 'photo',
        'contact_phone', 'is_active', 'views'
    ];

    protected $casts = [
        'lost_date' => 'date',
        'is_active' => 'boolean',
        'views' => 'integer',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

   // порода
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }


    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'post_colors')
                    ->withTimestamps();
    }


    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }


    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withTimestamps();
    }


    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }


    public function scopeFound($query)
    {
        return $query->where('status', 'found');
    }


    public function scopeByDistrict($query, $districtId)
    {
        return $query->where('district_id', $districtId);
    }


    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }


    public function incrementViews(): void
    {
        $this->increment('views');
    }


    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}