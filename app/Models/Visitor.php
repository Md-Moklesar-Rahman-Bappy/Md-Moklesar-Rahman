<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $fillable = [
        'profile_id',
        'ip_address',
        'country',
        'city',
        'device',
        'browser',
        'operating_system',
        'referrer',
        'page_url',
        'visitor_id',
        'session_id',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
