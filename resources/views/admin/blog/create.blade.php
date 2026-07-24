@extends('layouts.admin')

@section('page_title', 'Create Blog Post')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.blog-posts.index') }}" class="text-decoration-none">Blog</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Create Blog Post</h4>
        <p class="text-muted mb-0">Write and publish a new blog article.</p>
    </div>
    <a href="{{ route('admin.blog-posts.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back
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

<form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2" style="color:#6366f1;"></i>Post Content</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title') }}" required
                                   x-data x-init="$watch('$el.value', val => {
                                       const slugEl = document.getElementById('slug');
                                       if (!slugEl.dataset.manual) slugEl.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                                   })">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="slug" class="form-label fw-semibold">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug"
                                   value="{{ old('slug') }}"
                                   x-data="{ manual: false }" @input="manual = true">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="excerpt" class="form-label fw-semibold">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt" name="excerpt" rows="3"
                                      placeholder="A short summary of the post...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="content" class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="16" required
                                      placeholder="Write your blog post content here...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-tags me-2" style="color:#10b981;"></i>Tags</h6>
                    <div class="row g-2">
                        @foreach($allTags ?? [] as $tag)
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="tags[]" value="{{ $tag->id }}"
                                           id="tag_{{ $tag->id }}"
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(empty($allTags))
                        <p class="text-muted small mb-0">No tags available. Create tags first.</p>
                    @endif
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-search me-2" style="color:#f59e0b;"></i>SEO Settings</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title') }}" maxlength="60">
                            <div class="form-text">Recommended: 50-60 characters.</div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      maxlength="160">{{ old('meta_description') }}</textarea>
                            <div class="form-text">Recommended: 150-160 characters.</div>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="og_image" class="form-label fw-semibold">Open Graph Image</label>
                            <input type="file" class="form-control @error('og_image') is-invalid @enderror"
                                   id="og_image" name="og_image" accept="image/*">
                            <div class="form-text">Recommended: 1200x630px for social media sharing.</div>
                            @error('og_image')
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
                    <h6 class="fw-bold mb-4"><i class="bi bi-gear me-2" style="color:#6366f1;"></i>Publish Settings</h6>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-semibold">Publish Date</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at') }}">
                        <div class="form-text">Leave empty to publish immediately.</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_featured">Featured Post</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-image me-2" style="color:#10b981;"></i>Featured Image</h6>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                           id="featured_image" name="featured_image" accept="image/*">
                    <div class="form-text">JPEG, PNG, or WebP. Max 2MB.</div>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                <i class="bi bi-check-lg me-1"></i> Save Post
            </button>
        </div>
    </div>
</form>
@endsection
