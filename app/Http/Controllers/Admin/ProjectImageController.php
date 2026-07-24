<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends AdminController
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'images'         => 'required|array|max:10',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'images.*.caption' => 'nullable|string|max:255',
        ]);

        $maxOrder = $project->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('projects/images', 'public');

            ProjectImage::create([
                'project_id'  => $project->id,
                'path'        => $path,
                'caption'     => $request->input("images.{$index}.caption"),
                'sort_order'  => $maxOrder + $index + 1,
            ]);
        }

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Project images uploaded successfully.');
    }

    public function destroy(ProjectImage $image)
    {
        $project = $image->project;

        if ($image->path) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Project image deleted successfully.');
    }
}
