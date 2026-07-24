<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutSection extends Model
{
    protected $fillable = [
        'profile_id',
        'heading',
        'content',
        'counters',
        'achievements',
        'image',
        'sort_order',
    ];

    protected $casts = [
        'counters' => 'array',
        'achievements' => 'array',
        'sort_order' => 'integer',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
