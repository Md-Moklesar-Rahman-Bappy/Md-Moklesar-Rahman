<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends AdminController
{
    public function store(Request $request, Project $project)
    {
        $profile = $this->getProfile();

        if ((int) $project->profile_id !== (int) $profile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $maxOrder = $project->projectImages()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('projects/images', 'public');

            ProjectImage::create([
                'project_id' => $project->id,
                'image_path' => $path,
                'caption' => $request->input("captions.{$index}"),
                'sort_order' => $maxOrder + $index + 1,
            ]);
        }

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Project images uploaded successfully.');
    }

    public function destroy(ProjectImage $projectImage)
    {
        $profile = $this->getProfile();

        if ((int) $projectImage->project->profile_id !== (int) $profile->id) {
            abort(403);
        }

        $project = $projectImage->project;

        if ($projectImage->image_path) {
            Storage::disk('public')->delete($projectImage->image_path);
        }

        $projectImage->delete();

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Project image deleted successfully.');
    }
}
