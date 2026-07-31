<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PageSection;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use App\Models\Theme;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\ThemeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeRenderTest extends TestCase
{
    use RefreshDatabase;

    protected Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(ThemeSeeder::class);

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

    public function test_all_themes_render_with_array_based_section_data(): void
    {
        $this->createModelData();
        $this->createArrayBasedSections();

        foreach (Theme::all() as $theme) {
            Theme::query()->update(['is_active' => false]);
            $theme->update(['is_active' => true]);

            $response = $this->get('/');
            $response->assertOk();
            $response->assertSee($this->themeMarker($theme->slug), false);
        }
    }

    public function test_all_themes_render_with_empty_section_data(): void
    {
        foreach (Theme::all() as $theme) {
            Theme::query()->update(['is_active' => false]);
            $theme->update(['is_active' => true]);

            $response = $this->get('/');
            $response->assertOk();
        }
    }

    public function test_frontend_subpages_render_active_theme_layout(): void
    {
        $this->createModelData();

        $active = Theme::where('slug', 'agency')->first();
        Theme::query()->update(['is_active' => false]);
        $active->update(['is_active' => true]);

        $this->get('/')->assertOk()->assertSee('agency');
        $this->get('/blog')->assertOk();
        $this->get('/contact')->assertOk();
        $this->get('/blog/test-blog-post')->assertOk();
        $this->get('/project/test-project')->assertOk();
    }

    protected function themeMarker(string $slug): string
    {
        return [
            'developer' => 'dev-section',
            'modern' => 'mod-section',
            'creative' => 'cre-section',
            'freelancer' => 'fre-section',
            'agency' => 'agency-line',
            'corporate' => 'corp-divider',
            'minimal' => 'min-line',
            'premium-saas' => 'feature-card',
        ][$slug] ?? $slug;
    }

    protected function createModelData(): void
    {
        $category = SkillCategory::create(['profile_id' => $this->profile->id, 'name' => 'Backend', 'slug' => 'backend']);
        Skill::create([
            'profile_id' => $this->profile->id,
            'name' => 'Laravel',
            'percentage' => 90,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        Experience::create([
            'profile_id' => $this->profile->id,
            'company_name' => 'Acme Inc',
            'position' => 'Senior Developer',
            'location' => 'Dhaka',
            'start_date' => '2022-07-01',
            'description' => 'Built products',
            'technologies' => ['Laravel', 'Vue', 'MySQL'],
            'sort_order' => 1,
        ]);

        Education::create([
            'profile_id' => $this->profile->id,
            'institution' => 'Example University',
            'degree' => 'BSc',
            'group_or_field' => 'Computer Science',
            'result' => '3.8',
            'start_date' => '2018-01-01',
            'end_date' => '2022-01-01',
        ]);

        Project::create([
            'profile_id' => $this->profile->id,
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'A test project',
            'technologies' => ['Laravel', 'Vue', 'React', 'Node', 'PostgreSQL'],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Service::create([
            'profile_id' => $this->profile->id,
            'title' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Full-stack web apps',
            'icon' => 'code-slash',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Testimonial::create([
            'profile_id' => $this->profile->id,
            'client_name' => 'John Doe',
            'company' => 'Acme',
            'review' => 'Great work!',
            'rating' => 5,
            'is_active' => true,
        ]);

        Certification::create([
            'profile_id' => $this->profile->id,
            'name' => 'AWS Certified',
            'organization' => 'Amazon',
            'issue_date' => '2025-06-15',
            'verification_url' => 'https://example.com',
            'is_active' => true,
        ]);

        BlogPost::create([
            'profile_id' => $this->profile->id,
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
            'content' => '<p>Test content</p>',
            'excerpt' => 'Test excerpt',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    protected function createArrayBasedSections(): void
    {
        $sections = [
            'hero' => ['heading' => 'Hello', 'subheading' => 'World'],
            'about' => ['heading' => 'Who I am', 'content' => 'About me text'],
            'skills' => [
                'skills' => [
                    ['name' => 'Laravel', 'percentage' => 90, 'category' => 'Backend'],
                    ['name' => 'Vue.js', 'percentage' => 80, 'category' => 'Frontend'],
                ],
            ],
            'experience' => [
                'experiences' => [
                    ['company_name' => 'Acme Inc', 'position' => 'Senior Developer', 'location' => 'Dhaka', 'start_date' => '2022-07-01', 'end_date' => null, 'description' => 'Built things', 'technologies' => ['Laravel', 'Vue', 'MySQL']],
                ],
            ],
            'education' => [
                'educations' => [
                    ['institution' => 'MIT', 'degree' => 'BSc', 'group_or_field' => 'CS', 'result' => '3.8', 'start_date' => '2018-01-01', 'end_date' => '2022-01-01'],
                ],
            ],
            'projects' => [
                'projects' => [
                    ['title' => 'E-commerce', 'description' => 'A store', 'technologies' => ['Laravel', 'Vue', 'React', 'Node', 'PostgreSQL'], 'live_url' => 'https://example.com', 'github_url' => 'https://github.com'],
                ],
            ],
            'services' => [
                'services' => [
                    ['title' => 'Web Dev', 'description' => 'Full-stack', 'icon' => 'code-slash', 'price' => 500],
                ],
            ],
            'testimonials' => [
                'testimonials' => [
                    ['client_name' => 'John', 'review' => 'Great work', 'rating' => 5],
                ],
            ],
            'certifications' => [
                'certifications' => [
                    ['name' => 'AWS', 'organization' => 'Amazon', 'issue_date' => '2025-06-15', 'verification_url' => 'https://example.com'],
                ],
            ],
            'blog' => [
                'blog_posts' => [
                    ['title' => 'My Post', 'excerpt' => 'Excerpt', 'published_at' => '2026-01-15', 'slug' => 'my-post', 'featured_image' => null],
                ],
            ],
        ];

        foreach (Theme::all() as $theme) {
            foreach ($sections as $type => $content) {
                PageSection::create([
                    'profile_id' => $this->profile->id,
                    'theme_id' => $theme->id,
                    'name' => ucfirst($type),
                    'slug' => $type,
                    'section_type' => $type,
                    'content' => $content,
                    'is_active' => true,
                    'sort_order' => 1,
                ]);
            }
        }
    }
}
