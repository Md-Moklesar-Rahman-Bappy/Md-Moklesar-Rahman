@extends('layouts.admin')

@section('page_title', 'Theme Customizer')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.appearance.index') }}" class="text-decoration-none">Themes</a></li>
        <li class="breadcrumb-item active">Customize</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Theme Customizer</h4>
        <p class="text-muted mb-0">Customize: {{ $theme->name }}</p>
    </div>
    <a href="{{ route('admin.appearance.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
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

<div x-data="themeCustomizer()" class="row g-0" style="min-height:calc(100vh - 200px);">
    <div class="col-lg-5" style="max-height:calc(100vh - 120px);overflow-y:auto;">
        <div class="p-3" style="border-right:1px solid #e2e8f0;">
            <form action="{{ route('admin.appearance.update', $theme) }}" method="POST" @submit.prevent="saveForm($el)">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-palette me-2" style="color:#6366f1;"></i>Colors</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Primary Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" name="primary_color"
                                       x-model="settings.primary_color" style="width:45px;">
                                <input type="text" class="form-control" :value="settings.primary_color"
                                       @input="settings.primary_color = $event.target.value" style="font-size:0.85rem;">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Secondary Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" name="secondary_color"
                                       x-model="settings.secondary_color" style="width:45px;">
                                <input type="text" class="form-control" :value="settings.secondary_color"
                                       @input="settings.secondary_color = $event.target.value" style="font-size:0.85rem;">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Accent Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" name="accent_color"
                                       x-model="settings.accent_color" style="width:45px;">
                                <input type="text" class="form-control" :value="settings.accent_color"
                                       @input="settings.accent_color = $event.target.value" style="font-size:0.85rem;">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Background Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" name="background_color"
                                       x-model="settings.background_color" style="width:45px;">
                                <input type="text" class="form-control" :value="settings.background_color"
                                       @input="settings.background_color = $event.target.value" style="font-size:0.85rem;">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Text Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" name="text_color"
                                       x-model="settings.text_color" style="width:45px;">
                                <input type="text" class="form-control" :value="settings.text_color"
                                       @input="settings.text_color = $event.target.value" style="font-size:0.85rem;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-fonts me-2" style="color:#10b981;"></i>Typography</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Font Family</label>
                            <select class="form-select" name="font_family" x-model="settings.font_family">
                                <option value="Inter">Inter</option>
                                <option value="Poppins">Poppins</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Open Sans">Open Sans</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Font Size: <span x-text="settings.font_size + 'px'"></span></label>
                            <input type="range" class="form-range" name="font_size"
                                   x-model="settings.font_size" min="12" max="24" step="1">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-layout-sidebar me-2" style="color:#f59e0b;"></i>Layout</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Border Radius: <span x-text="settings.border_radius + 'px'"></span></label>
                            <input type="range" class="form-range" name="border_radius"
                                   x-model="settings.border_radius" min="0" max="24" step="2">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Layout Width: <span x-text="settings.layout_width + 'px'"></span></label>
                            <input type="range" class="form-range" name="layout_width"
                                   x-model="settings.layout_width" min="960" max="1400" step="20">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-window me-2" style="color:#ec4899;"></i>Header Style</h6>
                    <div class="d-flex gap-3">
                        @foreach(['standard', 'centered', 'minimal'] as $style)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="header_style"
                                       id="header_{{ $style }}" value="{{ $style }}"
                                       x-model="settings.header_style">
                                <label class="form-check-label fw-semibold small text-capitalize" for="header_{{ $style }}">
                                    {{ $style }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-layout-footer me-2" style="color:#06b6d4;"></i>Footer Style</h6>
                    <div class="d-flex gap-3">
                        @foreach(['standard', 'centered', 'minimal'] as $style)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="footer_style"
                                       id="footer_{{ $style }}" value="{{ $style }}"
                                       x-model="settings.footer_style">
                                <label class="form-check-label fw-semibold small text-capitalize" for="footer_{{ $style }}">
                                    {{ $style }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-code-slash me-2" style="color:#6366f1;"></i>Custom Code</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Custom CSS</label>
                        <textarea class="form-control font-monospace" name="custom_css" rows="5"
                                  style="font-size:0.82rem;"
                                  placeholder="/* Add custom CSS here...">{{ old('custom_css', $settings['custom_css'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Custom JavaScript</label>
                        <textarea class="form-control font-monospace" name="custom_js" rows="5"
                                  style="font-size:0.82rem;"
                                  placeholder="// Add custom JavaScript here...">{{ old('custom_js', $settings['custom_js'] ?? '') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;"
                        :disabled="saving">
                    <span x-show="!saving"><i class="bi bi-check-lg me-1"></i> Save & Apply</span>
                    <span x-show="saving"><i class="bi bi-arrow-repeat spin me-1"></i> Saving...</span>
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="p-3" style="background:#f8fafc;min-height:100%;">
            <div class="bg-white rounded-3 shadow-sm overflow-hidden"
                 :style="{
                     'max-width': settings.layout_width + 'px',
                     'margin': '0 auto',
                     'font-family': settings.font_family,
                     'font-size': settings.font_size + 'px',
                     'color': settings.text_color,
                     'background-color': settings.background_color,
                     'border-radius': settings.border_radius + 'px'
                 }">
                <div class="p-4 text-center" :class="{
                    'text-center': settings.header_style === 'centered',
                    'py-2 px-4 d-flex justify-content-between align-items-center': settings.header_style === 'minimal'
                }" :style="{ 'background-color': settings.primary_color }">
                    <div :class="{ 'mx-auto': settings.header_style === 'centered' }">
                        <h4 class="text-white mb-0 fw-bold">Portfolio Name</h4>
                        @if(settings.header_style !== 'minimal')
                            <small class="text-white-50">Creative Developer & Designer</small>
                        @endif
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="fw-bold mb-3" :style="{ 'color': settings.primary_color }">About Me</h3>
                    <p :style="{ 'color': settings.text_color }">
                        I am a passionate developer creating amazing digital experiences.
                        This is a live preview of how your theme will look.
                    </p>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" :style="{ 'background-color': settings.accent_color + '15', 'border-radius': settings.border_radius + 'px' }">
                                <div class="fw-bold fs-4" :style="{ 'color': settings.accent_color }">50+</div>
                                <small class="text-muted">Projects</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" :style="{ 'background-color': settings.secondary_color + '15', 'border-radius': settings.border_radius + 'px' }">
                                <div class="fw-bold fs-4" :style="{ 'color': settings.secondary_color }">30+</div>
                                <small class="text-muted">Clients</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" :style="{ 'background-color': settings.primary_color + '15', 'border-radius': settings.border_radius + 'px' }">
                                <div class="fw-bold fs-4" :style="{ 'color': settings.primary_color }">5+</div>
                                <small class="text-muted">Years Exp</small>
                            </div>
                        </div>
                    </div>

                    <button class="btn text-white mt-3" :style="{ 'background-color': settings.primary_color }">
                        Get In Touch
                    </button>
                </div>

                <div class="p-3 text-center" :style="{ 'background-color': settings.primary_color, 'border-radius': '0 0 ' + settings.border_radius + 'px ' + settings.border_radius + 'px' }">
                    <small class="text-white-50">&copy; 2026 Portfolio. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .spin { animation: spin 1s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .form-range::-webkit-slider-thumb { background: #6366f1; }
    .form-range::-moz-range-thumb { background: #6366f1; }
</style>
@endpush

@push('scripts')
<script>
function themeCustomizer() {
    return {
        saving: false,
        settings: {
            primary_color: '{{ $settings["primary_color"] ?? "#6366f1" }}',
            secondary_color: '{{ $settings["secondary_color"] ?? "#8b5cf6" }}',
            accent_color: '{{ $settings["accent_color"] ?? "#f59e0b" }}',
            background_color: '{{ $settings["background_color"] ?? "#ffffff" }}',
            text_color: '{{ $settings["text_color"] ?? "#1e293b" }}',
            font_family: '{{ $settings["font_family"] ?? "Inter" }}',
            font_size: {{ $settings["font_size"] ?? 16 }},
            border_radius: {{ $settings["border_radius"] ?? 12 }},
            layout_width: {{ $settings["layout_width"] ?? 1200 }},
            header_style: '{{ $settings["header_style"] ?? "standard" }}',
            footer_style: '{{ $settings["footer_style"] ?? "standard" }}'
        },
        async saveForm(form) {
            this.saving = true;
            const formData = new FormData(form);
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                if (response.ok) {
                    alert('Theme settings saved successfully!');
                }
            } catch (e) {
                alert('Failed to save settings.');
            }
            this.saving = false;
        }
    };
}
</script>
@endpush
@endsection
