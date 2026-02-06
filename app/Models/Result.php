<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    protected $fillable = [
        'ashon_id',
        'centar_id',
        'marka_id',
        'user_id',
        'total_vote',
        'candidate_name',
    ];

    protected $casts = [
        'total_vote' => 'double',
    ];

    public function ashon(): BelongsTo
    {
        return $this->belongsTo(Ashon::class);
    }

    public function centar(): BelongsTo
    {
        return $this->belongsTo(Centars::class, 'centar_id');
    }

    public function marka(): BelongsTo
    {
        return $this->belongsTo(Marka::class, 'marka_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ResultImage::class, 'result_id');
    }
}
