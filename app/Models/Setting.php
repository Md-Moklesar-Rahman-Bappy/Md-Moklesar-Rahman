<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'profile_id',
        'group',
        'key',
        'value',
        'type',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public static function get(int $profileId, string $group, string $key, mixed $default = null): mixed
    {
        $setting = static::where('profile_id', $profileId)
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(int $profileId, string $group, string $key, mixed $value, string $type = 'text'): static
    {
        return static::updateOrCreate(
            [
                'profile_id' => $profileId,
                'group' => $group,
                'key' => $key,
            ],
            [
                'value' => $value,
                'type' => $type,
            ]
        );
    }
}
