<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $certifications = Certification::where('profile_id', $profile->id)
            ->orderBy('issue_date', 'desc')
            ->paginate(15);

        return view('admin.certifications.index', compact('certifications', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.certifications.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'verification_url' => 'nullable|url|max:255',
            'credential_id' => 'nullable|string|max:255',
        ]);

        $validated['profile_id'] = $profile->id;

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('certifications', 'public');
            $validated['certificate_file'] = $path;
        }

        Certification::create($validated);

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification created successfully.');
    }

    public function edit(Certification $certification)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($certification);

        return view('admin.certifications.edit', compact('certification', 'profile'));
    }

    public function update(Request $request, Certification $certification)
    {
        $this->authorizeOwnership($certification);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'verification_url' => 'nullable|url|max:255',
            'credential_id' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('certificate_file')) {
            if ($certification->certificate_file) {
                Storage::disk('public')->delete($certification->certificate_file);
            }
            $path = $request->file('certificate_file')->store('certifications', 'public');
            $validated['certificate_file'] = $path;
        }

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification updated successfully.');
    }

    public function destroy(Certification $certification)
    {
        $this->authorizeOwnership($certification);
        if ($certification->certificate_file) {
            Storage::disk('public')->delete($certification->certificate_file);
        }

        $certification->delete();

        return redirect()->route('admin.certifications.index')
            ->with('success', 'Certification deleted successfully.');
    }
}
