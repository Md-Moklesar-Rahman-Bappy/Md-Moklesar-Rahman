@extends('layouts.admin')

@section('page_title', 'View Message')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}" class="text-decoration-none">Messages</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($message->subject, 30) }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $message->subject }}</h4>
        <p class="text-muted mb-0">Message from {{ $message->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.messages.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="quick-action-btn" style="background:#fef2f2;color:#ef4444;"
                    onclick="return confirm('Delete this message permanently?')">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-4"><i class="bi bi-envelope-open me-2" style="color:#6366f1;"></i>Message Content</h6>
                <div class="p-3 rounded-3 mb-4" style="background:#f8fafc;min-height:150px;">
                    <p class="mb-0" style="line-height:1.8;white-space:pre-wrap;">{{ $message->message }}</p>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-body">
                <h6 class="fw-bold mb-4"><i class="bi bi-reply me-2" style="color:#10b981;"></i>Quick Reply</h6>
                <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control @error('reply_message') is-invalid @enderror"
                                  name="reply_message" rows="5"
                                  placeholder="Write your reply...">{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn text-white fw-semibold" style="background:#6366f1;">
                        <i class="bi bi-send me-1"></i> Send Reply
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="glass-card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-4"><i class="bi bi-person me-2" style="color:#6366f1;"></i>Sender Info</h6>
                <div class="mb-3">
                    <small class="text-muted d-block">Name</small>
                    <span class="fw-semibold">{{ $message->name }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <a href="mailto:{{ $message->email }}" class="text-decoration-none fw-semibold" style="color:#6366f1;">
                        {{ $message->email }}
                    </a>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Date</small>
                    <span>{{ $message->created_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block">Status</small>
                    @if($message->is_read)
                        <span class="badge bg-secondary rounded-pill">Read</span>
                    @else
                        <span class="badge rounded-pill" style="background:#6366f1;">Unread</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                       class="btn btn-outline-secondary btn-sm rounded-pill text-start">
                        <i class="bi bi-envelope me-2"></i> Open in Email Client
                    </a>
                    @if(!$message->is_read)
                        <form action="{{ route('admin.messages.mark-read', $message) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill w-100 text-start">
                                <i class="bi bi-check2-circle me-2"></i> Mark as Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
