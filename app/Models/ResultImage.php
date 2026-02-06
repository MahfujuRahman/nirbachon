<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultImage extends Model
{
    protected $fillable = [
        'result_id',
        'image',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }
}
