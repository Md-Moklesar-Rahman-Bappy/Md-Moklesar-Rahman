<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $disk = Storage::disk('public');
        $directory = 'media';
        $allFiles = $disk->files($directory);

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allFiles = array_filter($allFiles, function ($file) use ($search) {
                return str_contains(strtolower(basename($file)), $search);
            });
        }

        $perPage = 24;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $sliced = array_slice($allFiles, $offset, $perPage);
        $total = count($allFiles);
        $lastPage = max(1, ceil($total / $perPage));

        $files = collect($sliced)->map(function ($path) use ($disk) {
            return [
                'name'         => basename($path),
                'path'         => $path,
                'url'          => $disk->url($path),
                'size'         => $disk->size($path),
                'lastModified' => $disk->lastModified($path),
                'mimeType'     => $disk->mimeType($path),
            ];
        });

        return view('admin.media.index', compact('files', 'profile', 'total', 'lastPage', 'page'));
    }

    public function upload(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'file'   => 'required|file|max:10240',
            'folder' => 'nullable|string|max:255',
        ]);

        $folder = $validated['folder'] ?? 'media';
        $file = $request->file('file');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'file'    => [
                    'name' => $filename,
                    'path' => $path,
                    'url'  => Storage::disk('public')->url($path),
                    'size' => Storage::disk('public')->size($path),
                ],
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'File uploaded successfully.');
    }

    public function destroy(Request $request)
    {
        $path = $request->input('path');

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'File deleted successfully.');
    }

    public function getMedia(Request $request)
    {
        $disk = Storage::disk('public');
        $directory = $request->get('folder', 'media');
        $allFiles = $disk->files($directory);

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allFiles = array_filter($allFiles, function ($file) use ($search) {
                return str_contains(strtolower(basename($file)), $search);
            });
        }

        $files = collect(array_values($allFiles))->map(function ($path) use ($disk) {
            return [
                'name'     => basename($path),
                'path'     => $path,
                'url'      => $disk->url($path),
                'size'     => $disk->size($path),
                'mimeType' => $disk->mimeType($path),
            ];
        })->values();

        return response()->json($files);
    }
}
