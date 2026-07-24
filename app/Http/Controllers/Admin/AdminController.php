<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AdminController extends Controller
{
    protected $profile;

    public function __construct()
    {
        $this->resolveProfile();
    }

    protected function resolveProfile(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        if (! $user->hasRole('admin')) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $this->profile = $user->profile;
        if (! $this->profile) {
            $this->profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'slug' => Str::slug($user->name),
            ]);
        }
        view()->share('profile', $this->profile);
    }

    protected function getProfile()
    {
        return $this->profile;
    }

    protected function authorizeOwnership(Model $model, string $ownerKey = 'profile_id'): void
    {
        if (! $this->profile) {
            abort(403, 'Unauthorized. No profile found.');
        }

        if ((string) $model->{$ownerKey} !== (string) $this->profile->id) {
            abort(403, 'Unauthorized. You do not own this resource.');
        }
    }
}
