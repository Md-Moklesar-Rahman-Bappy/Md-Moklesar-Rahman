<?php

namespace Database\Seeders;

use App\Models\{Theme, ThemeCustomization};
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            ['name' => 'Developer', 'slug' => 'developer', 'description' => 'Dark terminal-style theme for developers with monospace fonts and code-like decorations.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => true],
            ['name' => 'Modern', 'slug' => 'modern', 'description' => 'Clean, professional theme with gradient hero and smooth animations.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Creative', 'slug' => 'creative', 'description' => 'Bold, colorful theme with split-screen layouts and vibrant gradients.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Freelancer', 'slug' => 'freelancer', 'description' => 'Warm, friendly theme with timeline layouts and pricing cards.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Agency', 'slug' => 'agency', 'description' => 'Professional theme for agencies with service cards and stat counters.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Corporate', 'slug' => 'corporate', 'description' => 'Conservative, business-like theme with structured layout.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Minimal', 'slug' => 'minimal', 'description' => 'Ultra-clean theme with whitespace and typography focus.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
            ['name' => 'Premium SaaS', 'slug' => 'premium-saas', 'description' => 'Tech startup theme with gradients, glassmorphism, and SaaS styling.', 'version' => '1.0.0', 'author' => 'Portfolio Builder', 'is_active' => false],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
