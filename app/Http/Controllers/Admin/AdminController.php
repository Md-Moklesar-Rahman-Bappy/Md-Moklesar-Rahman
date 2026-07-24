<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Str;

abstract class AdminController extends Controller
{
    protected $profile;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->profile = auth()->user()->profile;
            if (!$this->profile) {
                $this->profile = Profile::create([
                    'user_id' => auth()->id(),
                    'full_name' => auth()->user()->name,
                    'slug' => Str::slug(auth()->user()->name),
                ]);
            }
            view()->share('profile', $this->profile);
            return $next($request);
        });
    }

    protected function getProfile()
    {
        return $this->profile;
    }
}
