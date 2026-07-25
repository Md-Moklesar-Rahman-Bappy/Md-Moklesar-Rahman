<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    protected Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->profile = $user->profile()->create([
            'full_name' => 'Test User',
            'slug' => 'test-user',
            'tagline' => 'Test Tagline',
            'designation' => 'Developer',
            'bio' => 'Test bio content',
        ]);
    }

    public function test_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_blog_page_loads(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    public function test_contact_page_loads(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_blog_post_page_loads(): void
    {
        $post = BlogPost::create([
            'profile_id' => $this->profile->id,
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
            'content' => '<p>Test content</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/blog/test-blog-post');
        $response->assertStatus(200);
    }

    public function test_project_page_loads(): void
    {
        $project = Project::create([
            'profile_id' => $this->profile->id,
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'A test project',
            'is_active' => true,
        ]);

        $response = $this->get('/project/test-project');
        $response->assertStatus(200);
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Hello, this is a test message.',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'name' => 'Test Contact',
            'email' => 'test@example.com',
        ]);
    }

    public function test_newsletter_subscription(): void
    {
        $response = $this->post('/subscribe', [
            'email' => 'subscriber@example.com',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('newsletters', ['email' => 'subscriber@example.com']);
    }
}
