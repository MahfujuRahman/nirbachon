<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultImage extends Model
{
    protected $fillable = [
        'result_id',
        'ashon_id',
        'centar_id',
        'marka_id',
        'user_id',
        'image',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

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
        return $this->belongsTo(Marka::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
