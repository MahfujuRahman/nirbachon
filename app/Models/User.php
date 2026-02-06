<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'phone',
        'centar_id',
        'marka_id',
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
            'role' => Roles::class,
        ];
    }

    public function centar(): BelongsTo
    {
        return $this->belongsTo(Centars::class, 'centar_id');
    }

    public function marka(): BelongsTo
    {
        return $this->belongsTo(Marka::class, 'marka_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === Roles::ADMIN;
    }

    public function isAgent(): bool
    {
        return $this->role === Roles::AGENT;
    }
}
