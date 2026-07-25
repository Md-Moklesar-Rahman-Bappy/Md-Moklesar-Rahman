<?php

namespace App\Http\Controllers\Admin;

use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $sections = PageSection::where('profile_id', $profile->id)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.page-sections.index', compact('sections', 'profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'content' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['profile_id'] = $profile->id;

        if (! isset($validated['sort_order'])) {
            $validated['sort_order'] = PageSection::where('profile_id', $profile->id)->max('sort_order') + 1;
        }

        PageSection::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.page-builder.index')
            ->with('success', 'Section created successfully.');
    }

    public function update(Request $request, PageSection $pageSection)
    {
        $this->authorizeOwnership($pageSection);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'content' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $pageSection->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.page-builder.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(PageSection $pageSection, Request $request)
    {
        $this->authorizeOwnership($pageSection);
        $pageSection->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.page-builder.index')
            ->with('success', 'Section deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:page_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['sections'] as $item) {
            PageSection::where('id', $item['id'])
                ->where('profile_id', $profile->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
