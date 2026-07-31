<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Services\ThemeManager;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\ThemeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DebugThemeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(ThemeSeeder::class);
    }

    public function test_theme_manager_resolves_fresh_per_request(): void
    {
        $themes = Theme::all();
        fwrite(STDERR, "\n== themes ==\n");
        foreach ($themes as $t) {
            fwrite(STDERR, "{$t->id} {$t->slug} active={$t->is_active}\n");
        }

        Route::get('/debug-active', function () {
            $tm = app(ThemeManager::class);
            $active = $tm->getActiveTheme();
            $manager2 = app(ThemeManager::class);

            return response()->json([
                'active' => $active?->slug,
                'active_id' => $active?->id,
                'manager_same_instance' => $tm === $manager2,
                'db_active' => Theme::where('is_active', true)->pluck('slug'),
            ]);
        });

        // First request: developer should be active
        $first = $this->getJson('/debug-active')->json();
        fwrite(STDERR, "\n== first request ==\n".json_encode($first)."\n");

        // Now activate modern
        Theme::query()->update(['is_active' => false]);
        Theme::where('slug', 'modern')->update(['is_active' => true]);
        fwrite(STDERR, "\n== after update ==\nDB active: ".Theme::where('is_active', true)->pluck('slug')->implode(',')."\n");

        // Second request: modern should be active
        $second = $this->getJson('/debug-active')->json();
        fwrite(STDERR, "\n== second request ==\n".json_encode($second)."\n");

        $this->assertSame('modern', $second['active']);
    }
}
