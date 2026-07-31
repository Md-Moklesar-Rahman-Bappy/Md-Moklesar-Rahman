<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    protected function createAdmin(): User
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->profile()->create([
            'full_name' => $user->name,
            'slug' => Str::slug($user->name),
        ]);

        return $user;
    }

    public function test_all_admin_get_routes_return_200(): void
    {
        $admin = $this->createAdmin();

        $routes = [
            'admin.dashboard' => [],
            'admin.profile.edit' => [],
            'admin.about.edit' => [],
            'admin.skills.index' => [],
            'admin.experiences.index' => [],
            'admin.educations.index' => [],
            'admin.projects.index' => [],
            'admin.services.index' => [],
            'admin.testimonials.index' => [],
            'admin.certifications.index' => [],
            'admin.blog-posts.index' => [],
            'admin.blog-categories.index' => [],
            'admin.messages.index' => [],
            'admin.newsletter.index' => [],
            'admin.media.index' => [],
            'admin.seo.index' => [],
            'admin.analytics.index' => [],
            'admin.settings.index' => [],
        ];

        foreach ($routes as $routeName => $params) {
            try {
                $response = $this->actingAs($admin)->get(route($routeName, $params));
                if ($response->getStatusCode() !== 200) {
                    $exc = $response->exception;
                    $msg = $exc ? $exc->getMessage().' @ '.$exc->getFile().':'.$exc->getLine() : 'status '.$response->getStatusCode();
                    $this->fail("Route [$routeName] failed: $msg");
                }
            } catch (\Throwable $e) {
                $this->fail("Route [$routeName] threw: {$e->getMessage()}".($e->getPrevious() ? " PREV: {$e->getPrevious()->getMessage()}" : ''));
            }
        }

        $this->assertTrue(true);
    }
}
