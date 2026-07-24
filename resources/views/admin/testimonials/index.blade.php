@extends('layouts.admin')

@section('page_title', 'Testimonials')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Testimonials</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Testimonials</h4>
        <p class="text-muted mb-0">Manage client testimonials and reviews.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
        <i class="bi bi-plus-lg"></i> Add Testimonial
    </a>
</div>

<div class="row g-4">
    @forelse($testimonials as $testimonial)
        <div class="col-lg-4 col-md-6">
            <div class="glass-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle me-3 overflow-hidden" style="width:56px;height:56px;flex-shrink:0;">
                            @if($testimonial->profile_image)
                                <img src="{{ asset('storage/' . $testimonial->profile_image) }}" alt="{{ $testimonial->client_name }}" class="w-100 h-100" style="object-fit:cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold" style="background:var(--accent);font-size:1.2rem;">
                                    {{ strtoupper(substr($testimonial->client_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ $testimonial->client_name }}</h6>
                            @if($testimonial->position || $testimonial->company)
                                <small class="text-muted">{{ $testimonial->position }}{{ $testimonial->company ? ' at ' . $testimonial->company : '' }}</small>
                            @endif
                        </div>
                        @if(!$testimonial->is_active)
                            <span class="badge bg-secondary rounded-pill ms-auto">Inactive</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $testimonial->rating ? 'bi-star-fill' : 'bi-star' }}" style="color:#f59e0b;"></i>
                        @endfor
                    </div>
                    <p class="text-muted small mb-3" style="line-height:1.6;">
                        "{{ Str::limit($testimonial->review, 150) }}"
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete this testimonial?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="glass-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-chat-quote display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No testimonials yet</h5>
                    <p class="text-muted mb-3">Add your first client testimonial to build social proof.</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
                        <i class="bi bi-plus-lg"></i> Add Testimonial
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if(method_exists($testimonials, 'links'))
    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
@endif
@endsection
