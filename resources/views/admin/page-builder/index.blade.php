@extends('layouts.admin')

@section('page_title', 'Page Builder')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Page Builder</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Page Builder</h4>
        <p class="text-muted mb-0">Arrange and manage your portfolio sections.</p>
    </div>
    <button class="quick-action-btn text-white" style="background:#6366f1;" data-bs-toggle="modal" data-bs-target="#addSectionModal">
        <i class="bi bi-plus-lg"></i> Add Section
    </button>
</div>

<div class="glass-card">
    <div class="card-body">
        <div x-data="pageBuilder()">
            <template x-for="(section, index) in sections" :key="section.id">
                <div class="d-flex align-items-center gap-3 p-3 mb-2 rounded-3"
                     style="background:#f8fafc;border:1px solid #e2e8f0;transition:all 0.2s;"
                     :class="{ 'opacity-50': !section.is_active }">
                    <div class="d-flex flex-column gap-1">
                        <button @click="moveUp(index)" class="btn btn-sm btn-link p-0 text-muted"
                                :disabled="index === 0" title="Move Up">
                            <i class="bi bi-chevron-up"></i>
                        </button>
                        <button @click="moveDown(index)" class="btn btn-sm btn-link p-0 text-muted"
                                :disabled="index === sections.length - 1" title="Move Down">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:rgba(99,102,241,0.1);">
                        <i class="bi" :class="getSectionIcon(section.section_type)" style="color:#6366f1;font-size:1.2rem;"></i>
                    </div>

                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-0" x-text="section.name"></h6>
                        <small class="text-muted" x-text="section.section_type.charAt(0).toUpperCase() + section.section_type.slice(1) + ' Section'"></small>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               :checked="section.is_active" @change="toggleActive(index)">
                    </div>

                    <div class="d-flex gap-1">
                        <a :href="getEditUrl(section.id)" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button @click="deleteSection(section.id, index)" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </template>

            <div x-show="sections.length === 0" class="text-center py-5">
                <i class="bi bi-layout-wtf display-4 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No sections yet</h5>
                <p class="text-muted mb-3">Add your first section to start building your page.</p>
                <button class="quick-action-btn text-white" style="background:#6366f1;" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                    <i class="bi bi-plus-lg"></i> Add Section
                </button>
            </div>

            <div class="d-flex justify-content-end mt-3" x-show="sections.length > 0">
                <button @click="saveOrder()" class="btn text-white fw-semibold px-4" style="background:#6366f1;"
                        :disabled="saving">
                    <span x-show="!saving"><i class="bi bi-check-lg me-1"></i> Save Order</span>
                    <span x-show="saving"><i class="bi bi-arrow-repeat spin me-1"></i> Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" x-data="addSectionForm()">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Add New Section</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form @submit.prevent="submitForm()">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="section_type" class="form-label fw-semibold">Section Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="section_type" name="section_type" x-model="form.section_type" required>
                            <option value="">Select Type</option>
                            <option value="hero">Hero</option>
                            <option value="about">About</option>
                            <option value="skills">Skills</option>
                            <option value="projects">Projects</option>
                            <option value="resume">Resume</option>
                            <option value="testimonials">Testimonials</option>
                            <option value="blogs">Blogs</option>
                            <option value="contact">Contact</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section_name" class="form-label fw-semibold">Section Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="section_name" name="name"
                               x-model="form.name" required placeholder="e.g. Hero Section">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white fw-semibold" style="background:#6366f1;" :disabled="submitting">
                        <span x-show="!submitting"><i class="bi bi-plus-lg me-1"></i> Add Section</span>
                        <span x-show="submitting">Adding...</span>
                    </button>
                </div>
            </form>
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
function pageBuilder() {
    return {
        sections: @json($sections ?? []),
        saving: false,
        getSectionIcon(type) {
            const icons = {
                hero: 'bi-stars',
                about: 'bi-person',
                skills: 'bi-lightning',
                projects: 'bi-folder',
                resume: 'bi-file-earmark-text',
                testimonials: 'bi-chat-quote',
                blogs: 'bi-journal-text',
                contact: 'bi-envelope'
            };
            return icons[type] || 'bi-square';
        },
        getEditUrl(id) {
            return `/admin/page-builder/${id}/edit`;
        },
        moveUp(index) {
            if (index === 0) return;
            const temp = this.sections[index];
            this.sections[index] = this.sections[index - 1];
            this.sections[index - 1] = temp;
            this.sections = [...this.sections];
        },
        moveDown(index) {
            if (index === this.sections.length - 1) return;
            const temp = this.sections[index];
            this.sections[index] = this.sections[index + 1];
            this.sections[index + 1] = temp;
            this.sections = [...this.sections];
        },
        toggleActive(index) {
            this.sections[index].is_active = !this.sections[index].is_active;
        },
        async saveOrder() {
            this.saving = true;
            try {
                const response = await fetch('{{ route("admin.page-builder.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order: this.sections.map((s, i) => ({ id: s.id, sort_order: i, is_active: s.is_active }))
                    })
                });
                if (response.ok) alert('Order saved successfully!');
            } catch (e) {
                alert('Failed to save order.');
            }
            this.saving = false;
        },
        async deleteSection(id, index) {
            if (!confirm('Delete this section?')) return;
            try {
                const response = await fetch(`/admin/page-builder/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                if (response.ok) {
                    this.sections.splice(index, 1);
                }
            } catch (e) {
                alert('Failed to delete section.');
            }
        }
    };
}

function addSectionForm() {
    return {
        form: { section_type: '', name: '' },
        submitting: false,
        async submitForm() {
            if (!this.form.section_type || !this.form.name) return;
            this.submitting = true;
            try {
                const response = await fetch('{{ route("admin.page-builder.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });
                if (response.ok) {
                    window.location.reload();
                }
            } catch (e) {
                alert('Failed to add section.');
            }
            this.submitting = false;
        }
    };
}
</script>
@endpush
@endsection
