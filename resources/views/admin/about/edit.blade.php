@extends('layouts.admin')

@section('page_title', 'About Section')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">About Section</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">About Section</h4>
        <p class="text-muted mb-0">Manage your about section content and achievements.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
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

<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>About Content</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="heading" class="form-label fw-semibold">Heading</label>
                            <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                   id="heading" name="heading"
                                   value="{{ old('heading', $about->heading ?? '') }}"
                                   placeholder="e.g. About Me">
                            @error('heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="content" class="form-label fw-semibold">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="8"
                                      placeholder="Write about yourself...">{{ old('content', $about->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body" x-data="achievementsManager()">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-trophy me-2" style="color:#f59e0b;"></i>Achievements</h6>
                        <button type="button" class="btn btn-sm text-white" style="background:#6366f1;" @click="add()">
                            <i class="bi bi-plus-lg me-1"></i> Add
                        </button>
                    </div>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" class="form-control form-control-sm"
                                   :name="'achievements[]'" x-model="items[index]"
                                   placeholder="e.g. Won Best Developer Award 2025">
                            <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0" @click="remove(index)"
                                    title="Remove">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </template>
                    <div x-show="items.length === 0" class="text-muted small">
                        No achievements added yet. Click "Add" to include achievements.
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body" x-data="countersManager()">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-123 me-2" style="color:#10b981;"></i>Counter Stats</h6>
                        <button type="button" class="btn btn-sm text-white" style="background:#6366f1;" @click="add()">
                            <i class="bi bi-plus-lg me-1"></i> Add
                        </button>
                    </div>
                    <template x-for="(counter, index) in counters" :key="index">
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"
                                       :name="'counter_labels[]'" x-model="counter.label"
                                       placeholder="Label (e.g. Projects Done)">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control form-control-sm"
                                       :name="'counter_values[]'" x-model="counter.value"
                                       placeholder="Value (e.g. 150+)">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="remove(index)" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div x-show="counters.length === 0" class="text-muted small">
                        No counters added yet.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-image me-2" style="color:#10b981;"></i>About Image</h6>
                    @if(!empty($about->image))
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $about->image) }}" alt="About Image"
                                 class="rounded" width="100%" height="180" style="object-fit:cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*">
                    <div class="form-text">JPEG, PNG, or WebP. Max 2MB.</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                <i class="bi bi-check-lg me-1"></i> Save About Section
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
function achievementsManager() {
    return {
        items: @json(old('achievements', $about->achievements ?? [])),
        add() {
            this.items.push('');
        },
        remove(index) {
            this.items.splice(index, 1);
        }
    };
}

function countersManager() {
    return {
        counters: @json(collect(old('counter_labels'))->map(function($label, $i) {
            return ['label' => $label, 'value' => old('counter_values')[$i] ?? ''];
        })->values() ?? ($about->counters ?? [])),
        add() {
            this.counters.push({ label: '', value: '' });
        },
        remove(index) {
            this.counters.splice(index, 1);
        }
    };
}
</script>
@endpush
@endsection
