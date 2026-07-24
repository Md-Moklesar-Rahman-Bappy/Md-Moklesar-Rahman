<?php

namespace Database\Seeders;

use App\Models\{Profile, Theme, ThemeCustomization, PageSection};
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profile = Profile::first();
        $theme = Theme::where('slug', 'developer')->first();

        if ($profile && $theme) {
            ThemeCustomization::create([
                'profile_id' => $profile->id,
                'theme_id' => $theme->id,
                'primary_color' => '#6366f1',
                'secondary_color' => '#8b5cf6',
                'accent_color' => '#06b6d4',
                'background_color' => '#0f172a',
                'text_color' => '#e2e8f0',
                'font_family' => 'Inter',
                'font_size' => '16px',
                'border_radius' => '0.75rem',
                'layout_width' => '1200px',
                'header_style' => 'standard',
                'footer_style' => 'standard',
            ]);

            $sections = [
                ['name' => 'Hero', 'slug' => 'hero', 'section_type' => 'hero', 'is_active' => true, 'sort_order' => 0],
                ['name' => 'About', 'slug' => 'about', 'section_type' => 'about', 'is_active' => true, 'sort_order' => 1],
                ['name' => 'Skills', 'slug' => 'skills', 'section_type' => 'skills', 'is_active' => true, 'sort_order' => 2],
                ['name' => 'Experience', 'slug' => 'experience', 'section_type' => 'experience', 'is_active' => true, 'sort_order' => 3],
                ['name' => 'Education', 'slug' => 'education', 'section_type' => 'education', 'is_active' => true, 'sort_order' => 4],
                ['name' => 'Projects', 'slug' => 'projects', 'section_type' => 'projects', 'is_active' => true, 'sort_order' => 5],
                ['name' => 'Services', 'slug' => 'services', 'section_type' => 'services', 'is_active' => true, 'sort_order' => 6],
                ['name' => 'Testimonials', 'slug' => 'testimonials', 'section_type' => 'testimonials', 'is_active' => true, 'sort_order' => 7],
                ['name' => 'Blog', 'slug' => 'blog', 'section_type' => 'blog', 'is_active' => true, 'sort_order' => 8],
                ['name' => 'Contact', 'slug' => 'contact', 'section_type' => 'contact', 'is_active' => true, 'sort_order' => 9],
            ];

            foreach ($sections as $section) {
                PageSection::create(array_merge($section, [
                    'profile_id' => $profile->id,
                    'theme_id' => $theme->id,
                    'content' => [],
                    'settings' => [],
                ]));
            }
        }
    }
}
