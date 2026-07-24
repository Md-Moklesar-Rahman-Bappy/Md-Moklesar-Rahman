<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $services = Service::where('profile_id', $profile->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.services.index', compact('services', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.services.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:255',
            'features'    => 'nullable|array',
            'features.*'  => 'string|max:255',
            'price'       => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['profile_id'] = $profile->id;

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $profile = $this->getProfile();

        return view('admin.services.edit', compact('service', 'profile'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:255',
            'features'    => 'nullable|array',
            'features.*'  => 'string|max:255',
            'price'       => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
