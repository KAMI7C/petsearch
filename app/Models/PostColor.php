<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostColor extends Model
{
    use HasFactory;

    protected $table = 'post_colors';

    protected $fillable = ['post_id', 'color_id'];

    /**
     * Связь с объявлением
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}