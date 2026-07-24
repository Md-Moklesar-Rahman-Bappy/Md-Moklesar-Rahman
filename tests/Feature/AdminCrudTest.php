<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        Profile::create([
            'user_id' => $this->admin->id,
            'full_name' => $this->admin->name,
            'slug' => Str::slug($this->admin->name),
        ]);
    }

    // === Skills ===
    public function test_skill_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.skills.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('admin.skills.store'), [
            'name' => 'PHP',
            'percentage' => 85,
        ]);
        $skill = Skill::where('name', 'PHP')->first();
        $this->assertNotNull($skill);

        $response = $this->actingAs($this->admin)->get(route('admin.skills.edit', $skill));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->put(route('admin.skills.update', $skill), [
            'name' => 'PHP 8',
            'percentage' => 90,
        ]);
        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'name' => 'PHP 8']);

        $response = $this->actingAs($this->admin)->delete(route('admin.skills.destroy', $skill));
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    // === Experiences ===
    public function test_experience_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.experiences.store'), [
            'company_name' => 'Acme Corp',
            'position' => 'Developer',
            'start_date' => '2020-01-01',
            'is_current' => true,
        ]);
        $exp = Experience::where('company_name', 'Acme Corp')->first();
        $this->assertNotNull($exp);

        $response = $this->actingAs($this->admin)->put(route('admin.experiences.update', $exp), [
            'company_name' => 'Acme Inc',
            'position' => 'Senior Developer',
            'start_date' => '2020-01-01',
            'is_current' => true,
        ]);
        $this->assertDatabaseHas('experiences', ['id' => $exp->id, 'company_name' => 'Acme Inc']);

        $response = $this->actingAs($this->admin)->delete(route('admin.experiences.destroy', $exp));
        $this->assertDatabaseMissing('experiences', ['id' => $exp->id]);
    }

    // === Education ===
    public function test_education_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.educations.store'), [
            'institution' => 'MIT',
            'degree' => 'BS Computer Science',
            'start_date' => '2016-09-01',
        ]);
        $edu = Education::where('institution', 'MIT')->first();
        $this->assertNotNull($edu);

        $response = $this->actingAs($this->admin)->delete(route('admin.educations.destroy', $edu));
        $this->assertDatabaseMissing('educations', ['id' => $edu->id]);
    }

    // === Projects (uses SoftDeletes) ===
    public function test_project_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'My Project',
            'description' => 'A test project',
            'is_active' => true,
        ]);
        $project = Project::where('title', 'My Project')->first();
        $this->assertNotNull($project);

        $response = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), [
            'title' => 'Updated Project',
            'description' => 'Updated description',
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Project']);

        $response = $this->actingAs($this->admin)->delete(route('admin.projects.destroy', $project));
        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }

    // === Services ===
    public function test_service_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Web Design',
            'description' => 'Beautiful websites',
        ]);
        $service = Service::where('title', 'Web Design')->first();
        $this->assertNotNull($service);

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    // === Testimonials ===
    public function test_testimonial_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'client_name' => 'John Doe',
            'review' => 'Great work!',
            'rating' => 5,
        ]);
        $testimonial = Testimonial::where('client_name', 'John Doe')->first();
        $this->assertNotNull($testimonial);

        $response = $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testimonial));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    // === Certifications ===
    public function test_certification_full_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.certifications.store'), [
            'name' => 'AWS Certified',
            'organization' => 'Amazon',
            'issue_date' => '2023-01-15',
        ]);
        $cert = Certification::where('name', 'AWS Certified')->first();
        $this->assertNotNull($cert);

        $response = $this->actingAs($this->admin)->delete(route('admin.certifications.destroy', $cert));
        $this->assertDatabaseMissing('certifications', ['id' => $cert->id]);
    }

    // === Blog Categories ===
    public function test_blog_category_crud(): void
    {
        $profileId = $this->admin->profile->id;

        $response = $this->actingAs($this->admin)->post(route('admin.blog-categories.store'), [
            'name' => 'Technology',
        ]);
        $cat = BlogCategory::where('name', 'Technology')->first();
        $this->assertNotNull($cat);
        $this->assertEquals($profileId, $cat->profile_id);

        $response = $this->actingAs($this->admin)->delete(route('admin.blog-categories.destroy', $cat));
        $this->assertDatabaseHas('profiles', ['user_id' => $this->admin->id]);
        $this->assertEquals(1, Profile::where('user_id', $this->admin->id)->count(), 'Should have exactly 1 profile');
        $this->assertDatabaseMissing('blog_categories', ['id' => $cat->id]);
    }

    // === Blog Tags ===
    public function test_blog_tag_crud(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blog-tags.store'), [
            'name' => 'Laravel',
        ]);
        $tag = BlogTag::where('name', 'Laravel')->first();
        $this->assertNotNull($tag);

        $response = $this->actingAs($this->admin)->delete(route('admin.blog-tags.destroy', $tag));
        $this->assertDatabaseMissing('blog_tags', ['id' => $tag->id]);
    }

    // === Blog Posts (uses SoftDeletes) ===
    public function test_blog_post_full_crud(): void
    {
        $cat = BlogCategory::create(['profile_id' => $this->admin->profile->id, 'name' => 'Dev', 'slug' => 'dev']);

        $response = $this->actingAs($this->admin)->post(route('admin.blog-posts.store'), [
            'title' => 'My Blog Post',
            'content' => '<p>Content here</p>',
            'status' => 'draft',
            'category_id' => $cat->id,
        ]);
        $post = BlogPost::where('title', 'My Blog Post')->first();
        $this->assertNotNull($post);

        $response = $this->actingAs($this->admin)->put(route('admin.blog-posts.update', $post), [
            'title' => 'Updated Post',
            'content' => '<p>Updated content</p>',
            'status' => 'published',
            'category_id' => $cat->id,
        ]);
        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'title' => 'Updated Post']);

        $response = $this->actingAs($this->admin)->delete(route('admin.blog-posts.destroy', $post));
        $this->assertSoftDeleted('blog_posts', ['id' => $post->id]);
    }

    // === Blog Post slug collision (known issue - documents current behavior) ===
    public function test_blog_post_slug_is_not_guaranteed_unique(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blog-posts.store'), [
            'title' => 'Same Title',
            'content' => '<p>First</p>',
            'status' => 'draft',
        ]);
        $post1 = BlogPost::where('title', 'Same Title')->first();
        $this->assertNotNull($post1);
        $this->assertEquals('same-title', $post1->slug);

        $response = $this->actingAs($this->admin)->post(route('admin.blog-posts.store'), [
            'title' => 'Same Title',
            'content' => '<p>Second</p>',
            'status' => 'draft',
        ]);
        $post2 = BlogPost::where('title', 'Same Title')->orderBy('id', 'desc')->first();
        // Known issue: slug collision not handled - both posts get the same slug
        $this->assertEquals($post1->slug, $post2->slug);
    }
}
