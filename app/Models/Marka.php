<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marka extends Model
{
    protected $fillable = [
        'title',
        'image',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'marka_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'marka_id');
    }
}
