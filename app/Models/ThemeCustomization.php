<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemeCustomization extends Model
{
    protected $fillable = [
        'profile_id',
        'theme_id',
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_color',
        'text_color',
        'font_family',
        'font_size',
        'border_radius',
        'layout_width',
        'header_style',
        'footer_style',
        'custom_css',
        'custom_js',
        'logo',
        'favicon',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
