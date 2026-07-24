<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'author',
        'screenshot',
        'is_active',
        'is_installed',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_installed' => 'boolean',
    ];

    public function themeCustomizations(): HasMany
    {
        return $this->hasMany(ThemeCustomization::class);
    }

    public function pageSections(): HasMany
    {
        return $this->hasMany(PageSection::class);
    }

    public static function getActive(): ?static
    {
        return static::where('is_active', true)->first();
    }
}
