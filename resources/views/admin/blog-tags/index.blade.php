@extends('layouts.admin')

@section('page_title', 'Blog Tags')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}" class="text-decoration-none">Blog</a></li>
        <li class="breadcrumb-item active">Tags</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Blog Tags</h4>
        <p class="text-muted mb-0">Manage tags for organizing blog posts.</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Blog
    </a>
</div>

<div class="glass-card" x-data="tagManager()">
    <div class="card-body">
        <div class="mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2" style="color:#6366f1;"></i>Add New Tag</h6>
            <form @submit.prevent="addTag()" class="d-flex gap-2">
                <input type="text" class="form-control" placeholder="Enter tag name..."
                       x-model="newTag" :disabled="saving">
                <button type="submit" class="btn text-white fw-semibold px-4" style="background:#6366f1;"
                        :disabled="saving || !newTag.trim()">
                    <span x-show="!saving"><i class="bi bi-plus-lg me-1"></i> Add</span>
                    <span x-show="saving"><i class="bi bi-arrow-repeat spin me-1"></i> Adding...</span>
                </button>
            </form>
        </div>

        <h6 class="fw-bold mb-3">All Tags</h6>
        <div class="d-flex flex-wrap gap-2">
            @forelse($tags as $tag)
                <div class="d-inline-flex align-items-center gap-2 badge rounded-pill py-2 px-3"
                     style="background:rgba(99,102,241,0.1);color:#6366f1;font-size:0.9rem;font-weight:500;"
                     x-data="{ show: true }" x-show="show" x-transition>
                    <i class="bi bi-hash"></i>
                    <span>{{ $tag->name }}</span>
                    <span class="small opacity-75">({{ $tag->posts_count ?? $tag->posts()->count() ?? 0 }})</span>
                    <form action="{{ route('admin.blog-tags.destroy', $tag) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none"
                                style="font-size:1rem;line-height:1;"
                                onclick="return confirm('Delete tag {{ $tag->name }}?')"
                                title="Delete tag">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-muted mb-0" id="empty-state">No tags yet. Add your first tag above.</p>
            @endforelse
            <template x-for="tag in tags" :key="tag.id">
                <div class="d-inline-flex align-items-center gap-2 badge rounded-pill py-2 px-3"
                     style="background:rgba(99,102,241,0.1);color:#6366f1;font-size:0.9rem;font-weight:500;">
                    <i class="bi bi-hash"></i>
                    <span x-text="tag.name"></span>
                    <span class="small opacity-75">(0)</span>
                    <button @click="removeTag(tag.id)" class="btn btn-link p-0 text-danger text-decoration-none"
                            style="font-size:1rem;line-height:1;" title="Delete tag">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

@push('styles')
<style>
    .spin { animation: spin 1s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush

@push('scripts')
<script>
function tagManager() {
    return {
        newTag: '',
        tags: [],
        saving: false,
        async addTag() {
            if (!this.newTag.trim()) return;
            this.saving = true;
            try {
                const response = await fetch('{{ route("admin.blog-tags.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name: this.newTag.trim() })
                });
                const data = await response.json();
                if (data.success) {
                    this.tags.push(data.tag);
                    this.newTag = '';
                    const emptyState = document.getElementById('empty-state');
                    if (emptyState) emptyState.remove();
                }
            } catch (e) {
                alert('Failed to add tag. Please try again.');
            }
            this.saving = false;
        },
        async removeTag(id) {
            if (!confirm('Delete this tag?')) return;
            try {
                await fetch(`/admin/blog-tags/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                this.tags = this.tags.filter(t => t.id !== id);
            } catch (e) {
                alert('Failed to delete tag. Please try again.');
            }
        }
    };
}
</script>
@endpush
@endsection
