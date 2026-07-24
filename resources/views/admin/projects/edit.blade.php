@extends('layouts.admin')

@section('page_title', 'Edit Project')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-decoration-none">Projects</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Project</h4>
        <p class="text-muted mb-0">Update <strong>{{ $project->title }}</strong>.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Projects
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-folder me-2" style="color:#6366f1;"></i>Project Information</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', $project->title) }}" required
                                   oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug"
                                   value="{{ old('slug', $project->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-semibold">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', $project->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="short_description" class="form-label fw-semibold">Short Description</label>
                            <input type="text" class="form-control @error('short_description') is-invalid @enderror"
                                   id="short_description" name="short_description"
                                   value="{{ old('short_description', $project->short_description) }}">
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="technologies" class="form-label fw-semibold">Technologies</label>
                            <textarea class="form-control @error('technologies') is-invalid @enderror"
                                      id="technologies" name="technologies" rows="2">{{ old('technologies', $project->technologies) }}</textarea>
                            <div class="form-text">Comma-separated list.</div>
                            @error('technologies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="features" class="form-label fw-semibold">Features</label>
                            <textarea class="form-control @error('features') is-invalid @enderror"
                                      id="features" name="features" rows="4">{{ old('features', $project->features) }}</textarea>
                            <div class="form-text">One feature per line.</div>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-link-45deg me-2" style="color:#10b981;"></i>Links &amp; Client</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="github_url" class="form-label fw-semibold">GitHub URL</label>
                            <input type="url" class="form-control @error('github_url') is-invalid @enderror"
                                   id="github_url" name="github_url"
                                   value="{{ old('github_url', $project->github_url) }}">
                            @error('github_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="live_url" class="form-label fw-semibold">Live URL</label>
                            <input type="url" class="form-control @error('live_url') is-invalid @enderror"
                                   id="live_url" name="live_url"
                                   value="{{ old('live_url', $project->live_url) }}">
                            @error('live_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="client_name" class="form-label fw-semibold">Client Name</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                   id="client_name" name="client_name"
                                   value="{{ old('client_name', $project->client_name) }}">
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-search me-2" style="color:#f59e0b;"></i>SEO</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title', $project->meta_title) }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $project->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-image me-2" style="color:#6366f1;"></i>Thumbnail</h6>
                    @if($project->thumbnail)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail"
                                 class="img-fluid rounded" style="max-height:150px;width:100%;object-fit:cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                           id="thumbnail" name="thumbnail" accept="image/*">
                    <div class="form-text">Leave empty to keep current thumbnail.</div>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="thumbPreview" class="text-center rounded p-3 mt-2" style="background:#f1f5f9;display:none;">
                        <img id="thumbImg" src="" alt="Preview" class="img-fluid rounded" style="max-height:200px;">
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-toggle-on me-2" style="color:#10b981;"></i>Status</h6>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                               {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_featured">
                            <i class="bi bi-star-fill text-warning me-1"></i> Featured Project
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Info</h6>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar3 me-2"></i>Created: {{ $project->created_at->format('M d, Y') }}
                    </div>
                    <div class="small text-muted">
                        <i class="bi bi-clock-history me-2"></i>Updated: {{ $project->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card mb-4 mt-4">
        <div class="card-body">
            <h6 class="fw-bold mb-4"><i class="bi bi-images me-2" style="color:#6366f1;"></i>Gallery Images</h6>
            <div class="row g-3 mb-4">
                @forelse($project->galleryImages ?? [] as $image)
                    <div class="col-md-3 col-6" id="gallery-{{ $image->id }}">
                        <div class="position-relative rounded overflow-hidden" style="height:140px;background:#f1f5f9;">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Gallery"
                                 class="w-100 h-100" style="object-fit:cover;">
                            <div x-data="{ show: false }">
                                <button type="button" @click="show = true"
                                        class="btn btn-sm position-absolute top-0 end-0 m-1"
                                        style="background:rgba(220,53,69,0.85);color:#fff;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div x-show="show" class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5);">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h6 class="modal-title fw-bold">Delete Image?</h6>
                                                <button type="button" class="btn-close" @click="show = false"></button>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button @click="show = false" class="btn btn-sm btn-light">Cancel</button>
                                                <form action="{{ route('admin.project-gallery.destroy', $image) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-3">No gallery images yet.</div>
                @endforelse
            </div>

            <form action="{{ route('admin.project-gallery.store', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="gallery_images" class="form-label fw-semibold">Upload Images</label>
                        <input type="file" class="form-control @error('gallery_images') is-invalid @enderror"
                               id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                        <div class="form-text">Select one or more images. Hold Ctrl/Cmd for multiple.</div>
                        @error('gallery_images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn w-100 text-white" style="background:#6366f1;">
                            <i class="bi bi-upload me-1"></i> Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Update Project
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('thumbnail').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('thumbImg').src = ev.target.result;
            document.getElementById('thumbPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
