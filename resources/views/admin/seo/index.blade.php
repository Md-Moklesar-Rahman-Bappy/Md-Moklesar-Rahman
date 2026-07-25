@extends('layouts.admin')

@section('page_title', 'SEO Manager')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">SEO Manager</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">SEO Manager</h4>
        <p class="text-muted mb-0">Optimize your site for search engines and social media.</p>
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

<form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-search me-2" style="color:#6366f1;"></i>General SEO</h6>
                    <div class="row g-3">
                        <div class="col-12" x-data="{ count: {{ strlen(old('meta_title', $seo['meta_title'] ?? '')) }} }">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title', $seo['meta_title'] ?? '') }}"
                                   maxlength="70"
                                   @input="count = $event.target.value.length">
                            <div class="d-flex justify-content-between">
                                <div class="form-text">Appears in search engine results.</div>
                                <small :class="count > 60 ? 'text-danger' : 'text-muted'">
                                    <span x-text="count"></span>/60 characters
                                </small>
                            </div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12" x-data="{ count: {{ strlen(old('meta_description', $seo['meta_description'] ?? '')) }} }">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3" maxlength="170"
                                      @input="count = $event.target.value.length">{{ old('meta_description', $seo['meta_description'] ?? '') }}</textarea>
                            <div class="d-flex justify-content-between">
                                <div class="form-text">Brief description shown below the title in search results.</div>
                                <small :class="count > 160 ? 'text-danger' : 'text-muted'">
                                    <span x-text="count"></span>/160 characters
                                </small>
                            </div>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords', $seo['meta_keywords'] ?? '') }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            <div class="form-text">Comma-separated keywords relevant to your site.</div>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-facebook me-2" style="color:#1877f2;"></i>Open Graph (Facebook, LinkedIn)</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="og_title" class="form-label fw-semibold">OG Title</label>
                            <input type="text" class="form-control @error('og_title') is-invalid @enderror"
                                   id="og_title" name="og_title"
                                   value="{{ old('og_title', $seo['og_title'] ?? '') }}"
                                   placeholder="Title for social media sharing">
                            @error('og_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="og_description" class="form-label fw-semibold">OG Description</label>
                            <textarea class="form-control @error('og_description') is-invalid @enderror"
                                      id="og_description" name="og_description" rows="3">{{ old('og_description', $seo['og_description'] ?? '') }}</textarea>
                            @error('og_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="og_image" class="form-label fw-semibold">OG Image</label>
                            @if(!empty($seo['og_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $seo['og_image']) }}" alt="OG Image"
                                         class="rounded" width="300" height="158" style="object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('og_image') is-invalid @enderror"
                                   id="og_image" name="og_image" accept="image/*">
                            <div class="form-text">Recommended: 1200x630px.</div>
                            @error('og_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-twitter-x me-2" style="color:#000;"></i>Twitter Card</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="twitter_card_type" class="form-label fw-semibold">Card Type</label>
                            <select class="form-select @error('twitter_card_type') is-invalid @enderror"
                                    id="twitter_card_type" name="twitter_card_type">
                                <option value="summary" {{ old('twitter_card_type', $seo['twitter_card_type'] ?? 'summary_large_image') === 'summary' ? 'selected' : '' }}>Summary</option>
                                <option value="summary_large_image" {{ old('twitter_card_type', $seo['twitter_card_type'] ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                            </select>
                            @error('twitter_card_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="twitter_title" class="form-label fw-semibold">Twitter Title</label>
                            <input type="text" class="form-control @error('twitter_title') is-invalid @enderror"
                                   id="twitter_title" name="twitter_title"
                                   value="{{ old('twitter_title', $seo['twitter_title'] ?? '') }}">
                            @error('twitter_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="twitter_description" class="form-label fw-semibold">Twitter Description</label>
                            <textarea class="form-control @error('twitter_description') is-invalid @enderror"
                                      id="twitter_description" name="twitter_description" rows="3">{{ old('twitter_description', $seo['twitter_description'] ?? '') }}</textarea>
                            @error('twitter_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="twitter_image" class="form-label fw-semibold">Twitter Image</label>
                            @if(!empty($seo['twitter_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $seo['twitter_image']) }}" alt="Twitter Image"
                                         class="rounded" width="300" height="158" style="object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('twitter_image') is-invalid @enderror"
                                   id="twitter_image" name="twitter_image" accept="image/*">
                            @error('twitter_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card mb-4 sticky-top" style="top:80px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-eye me-2" style="color:#6366f1;"></i>Preview</h6>

                    <div class="mb-4">
                        <small class="text-muted fw-semibold d-block mb-2">Google Search</small>
                        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                            <div class="text-truncate fw-semibold" style="color:#1a0dab;font-size:1.05rem;line-height:1.3;"
                                 x-text="document.getElementById('meta_title')?.value || 'Your Site Title'"></div>
                            <div class="text-truncate small" style="color:#006621;"
                                 x-text="'yourwebsite.com'"></div>
                            <div class="small" style="color:#545454;line-height:1.4;"
                                 x-text="document.getElementById('meta_description')?.value?.substring(0, 160) || 'Your meta description will appear here...'"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted fw-semibold d-block mb-2">Twitter Card</small>
                        <div class="rounded-3 overflow-hidden" style="border:1px solid #e2e8f0;">
                            <div class="p-3" style="background:#f0f0f0;height:140px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image text-muted display-6"></i>
                            </div>
                            <div class="p-2" style="background:#fff;">
                                <div class="fw-semibold small text-truncate"
                                     x-text="document.getElementById('twitter_title')?.value || 'Twitter Title'"></div>
                                <div class="text-muted small text-truncate"
                                     x-text="document.getElementById('twitter_description')?.value?.substring(0, 80) || 'Twitter description...'"></div>
                                <div class="text-muted small" style="font-size:0.75rem;"
                                     x-text="'yourwebsite.com'"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted fw-semibold d-block mb-2">Facebook / LinkedIn</small>
                        <div class="rounded-3 overflow-hidden" style="border:1px solid #e2e8f0;">
                            <div class="p-3" style="background:#f0f0f0;height:140px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image text-muted display-6"></i>
                            </div>
                            <div class="p-2" style="background:#fff;border-top:1px solid #e2e8f0;">
                                <div class="text-muted small" style="font-size:0.75rem;text-transform:uppercase;"
                                     x-text="'yourwebsite.com'"></div>
                                <div class="fw-semibold small text-truncate"
                                     x-text="document.getElementById('og_title')?.value || document.getElementById('meta_title')?.value || 'OG Title'"></div>
                                <div class="text-muted small text-truncate"
                                     x-text="document.getElementById('og_description')?.value?.substring(0, 80) || 'OG description...'"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                        <i class="bi bi-check-lg me-1"></i> Save SEO Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
