@extends('layouts.admin')

@section('page_title', 'Media Library')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Media Library</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Media Library</h4>
        <p class="text-muted mb-0">Upload and manage your media files.</p>
    </div>
</div>

<div class="glass-card mb-4"
     x-data="mediaUploader()" x-on:dragover.prevent="dragging = true" x-on:dragleave="dragging = false"
     x-on:drop.prevent="handleDrop($event); dragging = false;">
    <div class="card-body">
        <div class="border border-2 border-dashed rounded-3 p-5 text-center"
             :class="dragging ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary'"
             style="transition: all 0.2s ease; cursor: pointer;"
             @click="$refs.fileInput.click()">
            <i class="bi bi-cloud-arrow-up display-4 text-muted mb-2"></i>
            <h5 class="text-muted mb-1">Drag & drop files here</h5>
            <p class="text-muted small mb-3">or click to browse. Accepts images, PDFs, and documents.</p>
            <button type="button" class="btn btn-sm text-white" style="background:#6366f1;" @click.stop="$refs.fileInput.click()">
                <i class="bi bi-plus-lg me-1"></i> Choose Files
            </button>
            <input type="file" class="d-none" x-ref="fileInput" multiple accept="image/*,.pdf,.doc,.docx"
                   @change="uploadFiles($event.target.files)">
        </div>
        <div x-show="uploading" x-cloak class="mt-3">
            <div class="progress" style="height:6px;">
                <div class="progress-bar" role="progressbar" style="background:#6366f1;transition:width 0.3s;"
                     :style="{ width: progress + '%' }"></div>
            </div>
            <small class="text-muted mt-1 d-block" x-text="'Uploading... ' + progress + '%'"></small>
        </div>
    </div>
</div>

<div class="glass-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search media..."
                           x-model="searchQuery" @input.debounce.300ms="filterMedia()">
                </div>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted small" x-text="filteredMedia.length + ' items'"></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3" x-data="mediaBrowser()">
    <template x-for="item in filteredMedia" :key="item.id">
        <div class="col-lg-3 col-md-4 col-6">
            <div class="glass-card h-100" style="transition:all 0.2s;">
                <div class="position-relative" style="aspect-ratio:1;overflow:hidden;">
                    <template x-if="item.is_image">
                        <img :src="item.url" :alt="item.name" class="w-100 h-100" style="object-fit:cover;">
                    </template>
                    <template x-if="!item.is_image">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#f1f5f9;">
                            <i class="bi bi-file-earmark display-4 text-muted"></i>
                        </div>
                    </template>
                    <div class="position-absolute top-0 end-0 p-2 d-flex gap-1">
                        <button class="btn btn-sm btn-danger rounded-circle" style="width:28px;height:28px;"
                                @click="deleteMedia(item.id)" title="Delete">
                            <i class="bi bi-trash small"></i>
                        </button>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 p-2"
                         style="background:linear-gradient(transparent, rgba(0,0,0,0.7));">
                        <small class="text-white text-truncate d-block" x-text="item.name"></small>
                        <small class="text-white-50" x-text="item.size"></small>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="col-12 text-center py-5" x-show="filteredMedia.length === 0" x-cloak>
        <i class="bi bi-folder2-open display-4 text-muted mb-2 d-block"></i>
        <h5 class="text-muted">No media files found</h5>
        <p class="text-muted small">Upload files using the drop zone above.</p>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
function mediaUploader() {
    return {
        dragging: false,
        uploading: false,
        progress: 0,
        async uploadFiles(files) {
            if (!files.length) return;
            this.uploading = true;
            this.progress = 0;
            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }
            try {
                const xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        this.progress = Math.round((e.loaded / e.total) * 100);
                    }
                });
                xhr.addEventListener('load', () => {
                    this.uploading = false;
                    if (xhr.status === 200) {
                        window.location.reload();
                    }
                });
                xhr.open('POST', '{{ route("admin.media.upload") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.send(formData);
            } catch (e) {
                this.uploading = false;
                alert('Upload failed. Please try again.');
            }
        },
        handleDrop(e) {
            this.uploadFiles(e.dataTransfer.files);
        }
    };
}

function mediaBrowser() {
    return {
        searchQuery: '',
        filteredMedia: @json($media ?? []),
        filterMedia() {
            const query = this.searchQuery.toLowerCase();
            const allMedia = @json($media ?? []);
            this.filteredMedia = query
                ? allMedia.filter(m => m.name.toLowerCase().includes(query))
                : allMedia;
        },
        async deleteMedia(id) {
            if (!confirm('Delete this media file?')) return;
            try {
                const response = await fetch(`/admin/media/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                if (response.ok) {
                    this.filteredMedia = this.filteredMedia.filter(m => m.id !== id);
                }
            } catch (e) {
                alert('Failed to delete file.');
            }
        }
    };
}
</script>
@endpush
@endsection
