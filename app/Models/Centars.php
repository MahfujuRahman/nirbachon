<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Centars extends Model
{
    protected $fillable = [
        'ashon_id',
        'title',
        'address',
    ];

    public function ashon(): BelongsTo
    {
        return $this->belongsTo(Ashon::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'centar_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'centar_id');
    }
}
