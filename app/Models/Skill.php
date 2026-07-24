<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'profile_id',
        'category_id',
        'name',
        'percentage',
        'icon',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'percentage' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }
}
