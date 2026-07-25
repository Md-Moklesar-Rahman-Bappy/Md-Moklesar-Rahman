<?php

namespace App\Services;

use App\Models\PageSection;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\ThemeCustomization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ThemeManager
{
    protected ?Theme $activeTheme = null;

    protected ?ThemeCustomization $customization = null;

    protected ?Profile $profile = null;

    public function __construct()
    {
        $this->activeTheme = Theme::where('is_active', true)->first();
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;
        $this->customization = ThemeCustomization::where('profile_id', $profile->id)
            ->where('theme_id', $this->activeTheme?->id)
            ->first();

        return $this;
    }

    public function getActiveTheme(): ?Theme
    {
        return $this->activeTheme;
    }

    public function getCustomization(): ?ThemeCustomization
    {
        return $this->customization;
    }

    public function getSections(): Collection
    {
        if (! $this->profile || ! $this->activeTheme) {
            return collect();
        }

        return PageSection::where('profile_id', $this->profile->id)
            ->where('theme_id', $this->activeTheme->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function renderSection(string $type, array $data = []): string
    {
        $themeSlug = $this->activeTheme?->slug ?? 'developer';
        $viewPath = "themes.{$themeSlug}.sections.{$type}";

        if (! View::exists($viewPath)) {
            $viewPath = "themes.developer.sections.{$type}";
        }

        return view($viewPath, array_merge($data, [
            'theme' => $this->activeTheme,
            'customization' => $this->customization,
            'profile' => $this->profile,
        ]))->render();
    }

    public function renderPage(string $page, array $data = []): string
    {
        $themeSlug = $this->activeTheme?->slug ?? 'developer';
        $viewPath = "themes.{$themeSlug}.{$page}";

        if (! View::exists($viewPath)) {
            $viewPath = "themes.developer.{$page}";
        }

        return view($viewPath, array_merge($data, [
            'theme' => $this->activeTheme,
            'customization' => $this->customization,
            'profile' => $this->profile,
        ]))->render();
    }

    public function getThemePath(): string
    {
        $slug = $this->activeTheme?->slug ?? 'developer';

        return resource_path("views/themes/{$slug}");
    }

    public function getCssVariables(): string
    {
        $c = $this->customization;
        if (! $c) {
            return '';
        }

        return "
        :root {
            --pb-primary: {$this->sanitizeCssValue($c->primary_color)};
            --pb-secondary: {$this->sanitizeCssValue($c->secondary_color)};
            --pb-accent: {$this->sanitizeCssValue($c->accent_color)};
            --pb-bg: {$this->sanitizeCssValue($c->background_color)};
            --pb-text: {$this->sanitizeCssValue($c->text_color)};
            --pb-font: {$this->sanitizeCssValue($c->font_family)};
            --pb-font-size: {$this->sanitizeCssValue($c->font_size)};
            --pb-radius: {$this->sanitizeCssValue($c->border_radius)};
            --pb-width: {$this->sanitizeCssValue($c->layout_width)};
        }";
    }

    protected function sanitizeCssValue(?string $value): string
    {
        if (! $value) {
            return '';
        }

        $value = trim($value);

        $value = preg_replace('/[;{}<>"\'`]/', '', $value);

        $value = preg_replace('/expression\s*\(/i', '', $value);
        $value = preg_replace('/url\s*\(/i', '', $value);
        $value = preg_replace('/@import/i', '', $value);
        $value = preg_replace('/javascript\s*:/i', '', $value);

        return $value;
    }

    public static function getThemeDirectoryPath(string $slug): string
    {
        return resource_path("views/themes/{$slug}");
    }
}
