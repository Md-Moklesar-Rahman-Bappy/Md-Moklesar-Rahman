<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminAccessTest extends TestCase
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

    protected function createUser(): User
    {
        $user = User::factory()->create();
        $user->assignRole('editor');
        $user->profile()->create([
            'full_name' => $user->name,
            'slug' => Str::slug($user->name),
        ]);

        return $user;
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_non_admin_is_forbidden_from_admin_dashboard(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_skill_index(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get(route('admin.skills.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_skill(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->post(route('admin.skills.store'), [
            'name' => 'Laravel',
            'percentage' => 90,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('skills', ['name' => 'Laravel', 'profile_id' => $admin->profile->id]);
    }

    public function test_idor_prevention_on_skill_update(): void
    {
        $admin1 = $this->createAdmin();
        $admin2 = $this->createAdmin();

        $skill = Skill::create([
            'profile_id' => $admin2->profile->id,
            'name' => 'PHP',
            'percentage' => 80,
        ]);

        $response = $this->actingAs($admin1)->put(route('admin.skills.update', $skill), [
            'name' => 'Hacked Skill',
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'name' => 'PHP']);
    }

    public function test_idor_prevention_on_skill_delete(): void
    {
        $admin1 = $this->createAdmin();
        $admin2 = $this->createAdmin();

        $skill = Skill::create([
            'profile_id' => $admin2->profile->id,
            'name' => 'Laravel',
            'percentage' => 70,
        ]);

        $response = $this->actingAs($admin1)->delete(route('admin.skills.destroy', $skill));
        $response->assertStatus(403);
        $this->assertDatabaseHas('skills', ['id' => $skill->id]);
    }
}
