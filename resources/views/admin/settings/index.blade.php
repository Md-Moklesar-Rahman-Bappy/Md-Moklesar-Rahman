@extends('layouts.admin')

@section('page_title', 'Site Settings')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Site Settings</h4>
        <p class="text-muted mb-0">Configure your portfolio website settings.</p>
    </div>
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

<div class="glass-card">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist" id="settingsTabs">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                    <i class="bi bi-gear me-1"></i> General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                    <i class="bi bi-share me-1"></i> Social
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                    <i class="bi bi-envelope me-1"></i> Contact
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#footer" type="button" role="tab">
                    <i class="bi bi-layout-footer me-1"></i> Footer
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4">
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="general">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="site_name" class="form-label fw-semibold">Site Name</label>
                            <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                   id="site_name" name="site_name"
                                   value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="site_tagline" class="form-label fw-semibold">Site Tagline</label>
                            <input type="text" class="form-control @error('site_tagline') is-invalid @enderror"
                                   id="site_tagline" name="site_tagline"
                                   value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
                            @error('site_tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label fw-semibold">Logo</label>
                            @if(!empty($settings['logo']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo"
                                         height="40" style="object-fit:contain;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="favicon" class="form-label fw-semibold">Favicon</label>
                            @if(!empty($settings['favicon']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon"
                                         width="32" height="32" style="object-fit:contain;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror"
                                   id="favicon" name="favicon" accept="image/*">
                            @error('favicon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="footer_text" class="form-label fw-semibold">Footer Text</label>
                            <textarea class="form-control @error('footer_text') is-invalid @enderror"
                                      id="footer_text" name="footer_text" rows="3">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                            @error('footer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white fw-semibold px-4" style="background:#6366f1;">
                            <i class="bi bi-check-lg me-1"></i> Save General Settings
                        </button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="social" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="social">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="facebook_url" class="form-label fw-semibold">
                                <i class="bi bi-facebook me-1"></i> Facebook URL
                            </label>
                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                                   id="facebook_url" name="facebook_url"
                                   value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                   placeholder="https://facebook.com/...">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="twitter_url" class="form-label fw-semibold">
                                <i class="bi bi-twitter-x me-1"></i> Twitter / X URL
                            </label>
                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                                   id="twitter_url" name="twitter_url"
                                   value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                                   placeholder="https://x.com/...">
                            @error('twitter_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="github_url" class="form-label fw-semibold">
                                <i class="bi bi-github me-1"></i> GitHub URL
                            </label>
                            <input type="url" class="form-control @error('github_url') is-invalid @enderror"
                                   id="github_url" name="github_url"
                                   value="{{ old('github_url', $settings['github_url'] ?? '') }}"
                                   placeholder="https://github.com/...">
                            @error('github_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin_url" class="form-label fw-semibold">
                                <i class="bi bi-linkedin me-1"></i> LinkedIn URL
                            </label>
                            <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                   id="linkedin_url" name="linkedin_url"
                                   value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                                   placeholder="https://linkedin.com/in/...">
                            @error('linkedin_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="instagram_url" class="form-label fw-semibold">
                                <i class="bi bi-instagram me-1"></i> Instagram URL
                            </label>
                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror"
                                   id="instagram_url" name="instagram_url"
                                   value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                   placeholder="https://instagram.com/...">
                            @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="youtube_url" class="form-label fw-semibold">
                                <i class="bi bi-youtube me-1"></i> YouTube URL
                            </label>
                            <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                                   id="youtube_url" name="youtube_url"
                                   value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                                   placeholder="https://youtube.com/...">
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white fw-semibold px-4" style="background:#6366f1;">
                            <i class="bi bi-check-lg me-1"></i> Save Social Settings
                        </button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="contact">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label fw-semibold">Contact Email</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                   id="contact_email" name="contact_email"
                                   value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label fw-semibold">Contact Phone</label>
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                   id="contact_phone" name="contact_phone"
                                   value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="contact_address" class="form-label fw-semibold">Contact Address</label>
                            <textarea class="form-control @error('contact_address') is-invalid @enderror"
                                      id="contact_address" name="contact_address" rows="3">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                            @error('contact_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="map_embed_code" class="form-label fw-semibold">Google Maps Embed Code</label>
                            <textarea class="form-control @error('map_embed_code') is-invalid @enderror"
                                      id="map_embed_code" name="map_embed_code" rows="4"
                                      placeholder="<iframe src='https://maps.google.com/...'></iframe>">{{ old('map_embed_code', $settings['map_embed_code'] ?? '') }}</textarea>
                            @error('map_embed_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white fw-semibold px-4" style="background:#6366f1;">
                            <i class="bi bi-check-lg me-1"></i> Save Contact Settings
                        </button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="footer" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tab" value="footer">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="copyright_text" class="form-label fw-semibold">Copyright Text</label>
                            <input type="text" class="form-control @error('copyright_text') is-invalid @enderror"
                                   id="copyright_text" name="copyright_text"
                                   value="{{ old('copyright_text', $settings['copyright_text'] ?? '') }}"
                                   placeholder="&copy; 2026 Your Name. All rights reserved.">
                            @error('copyright_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="footer_columns" class="form-label fw-semibold">Footer Columns</label>
                            <select class="form-select @error('footer_columns') is-invalid @enderror"
                                    id="footer_columns" name="footer_columns">
                                @for($i = 1; $i <= 4; $i++)
                                    <option value="{{ $i }}" {{ old('footer_columns', $settings['footer_columns'] ?? 3) == $i ? 'selected' : '' }}>
                                        {{ $i }} Column{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                            @error('footer_columns')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="custom_footer_html" class="form-label fw-semibold">Custom Footer HTML</label>
                            <textarea class="form-control @error('custom_footer_html') is-invalid @enderror"
                                      id="custom_footer_html" name="custom_footer_html" rows="6"
                                      placeholder="Custom HTML for the footer area...">{{ old('custom_footer_html', $settings['custom_footer_html'] ?? '') }}</textarea>
                            <div class="form-text">Use with caution. Raw HTML will be rendered as-is.</div>
                            @error('custom_footer_html')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn text-white fw-semibold px-4" style="background:#6366f1;">
                            <i class="bi bi-check-lg me-1"></i> Save Footer Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
