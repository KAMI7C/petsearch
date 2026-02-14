<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    /**
     * Связь с породами (один ко многим)
     */
    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class);
    }

    /**
     * Связь с объявлениями (один ко многим)
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}