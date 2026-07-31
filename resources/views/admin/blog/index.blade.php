@extends('layouts.admin')

@section('page_title', 'Blog Posts')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Blog Posts</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Blog Posts</h4>
        <p class="text-muted mb-0">Manage your blog articles and publications.</p>
    </div>
    <a href="{{ route('admin.blog-posts.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
        <i class="bi bi-plus-lg"></i> Add Post
    </a>
</div>

<div class="glass-card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.blog-posts.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="status" class="form-label fw-semibold small">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label fw-semibold small">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label fw-semibold small">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Search posts...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn text-white w-100" style="background:#6366f1;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Views</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="fw-semibold">
                                {{ Str::limit($post->title, 40) }}
                            </td>
                            <td>
                                @if($post->category)
                                    <span class="badge bg-light text-dark rounded-pill">{{ $post->category->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @switch($post->status)
                                    @case('published')
                                        <span class="badge bg-success rounded-pill">Published</span>
                                        @break
                                    @case('draft')
                                        <span class="badge bg-warning text-dark rounded-pill">Draft</span>
                                        @break
                                    @case('archived')
                                        <span class="badge bg-secondary rounded-pill">Archived</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary rounded-pill">{{ ucfirst($post->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($post->is_featured)
                                    <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                                        <i class="bi bi-star-fill me-1"></i>Featured
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $post->profile->full_name ?? 'Admin' }}</td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td>{{ number_format($post->views_count ?? 0) }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    @if($post->status === 'published')
                                        <a href="{{ route('home.blog.show', $post->slug ?? $post) }}" target="_blank" rel="noopener noreferrer"
                                           class="btn btn-sm btn-outline-info rounded-pill" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete" onclick="return confirm('Delete this post?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-journal-text display-4 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No blog posts yet</h5>
                                <p class="text-muted mb-3">Write your first blog post to share your expertise.</p>
                                <a href="{{ route('admin.blog-posts.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
                                    <i class="bi bi-plus-lg"></i> Write Post
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($posts, 'links'))
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endif
@endsection
