<?php

use App\Models\Profile;
use App\Models\Theme;
use App\Services\ThemeManager;

Theme::query()->update(['is_active' => false]);
$modern = Theme::where('slug', 'modern')->first();
$modern->update(['is_active' => true]);

$tm = new ThemeManager;
echo 'active: '.($tm->getActiveTheme()?->slug ?? 'NULL').PHP_EOL;

$p = Profile::first();
echo 'profile: '.($p->id ?? 'NULL').PHP_EOL;
$tm->setProfile($p);
echo 'sections after setProfile: '.$tm->getSections()->count().PHP_EOL;

$sec = $tm->getSections()->first();
echo 'section: '.($sec->section_type ?? 'NONE').' / theme_id: '.($sec->theme_id ?? 'NONE').' / activeTheme id: '.($tm->getActiveTheme()?->id ?? 'NULL').PHP_EOL;
