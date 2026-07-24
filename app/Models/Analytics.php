<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analytics extends Model
{
    protected $fillable = [
        'profile_id',
        'url',
        'ip_address',
        'country',
        'city',
        'device',
        'browser',
        'operating_system',
        'referrer',
        'user_agent',
        'visitor_id',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
