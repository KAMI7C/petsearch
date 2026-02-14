<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'is_verified'];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Связь с категорией (многие к одному)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с объявлениями (один ко многим)
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}