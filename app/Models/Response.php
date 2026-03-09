<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'post_id', 'guest_name', 'guest_phone',
        'guest_social', 'message', 'preferred_time', 'status', 'is_archived'
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Проверка, авторизованный ли пользователь оставил отклик
     */
    public function isFromRegisteredUser(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * Проверка, гость ли оставил отклик
     */
    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    /**
     * Получить имя откликнувшегося
     * Если пользователь авторизован - берем из его профиля, иначе из guest_name
     */
    public function getResponderNameAttribute(): string
    {
        if ($this->isFromRegisteredUser() && $this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?? 'Аноним';
    }

    /**
     * Получить телефон для связи
     */
    public function getResponderPhoneAttribute(): ?string
    {
        if ($this->isFromRegisteredUser() && $this->user) {
            return $this->user->phone;
        }
        return $this->guest_phone;
    }

    /**
     * Получить соцсеть для связи
     */
    public function getResponderSocialAttribute(): ?string
    {
        if ($this->isFromRegisteredUser() && $this->user) {
            return $this->user->social;
        }
        return $this->guest_social;
    }

    /**
     * Получить все контактные данные
     */
    public function getContactInfoAttribute(): array
    {
        $contacts = [];
        
        if ($this->isFromRegisteredUser() && $this->user) {
            if ($this->user->phone) $contacts['phone'] = $this->user->phone;
            if ($this->user->social) $contacts['social'] = $this->user->social;
            if ($this->user->email) $contacts['email'] = $this->user->email;
        } else {
            if ($this->guest_phone) $contacts['phone'] = $this->guest_phone;
            if ($this->guest_social) $contacts['social'] = $this->guest_social;
        }
        
        return $contacts;
    }
}