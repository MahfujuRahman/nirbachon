<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ashon extends Model
{
    protected $fillable = [
        'title',
    ];

    public function centars(): HasMany
    {
        return $this->hasMany(Centars::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
