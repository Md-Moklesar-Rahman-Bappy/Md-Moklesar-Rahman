@extends('layouts.admin')

@section('page_title', 'Messages')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Messages</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Messages</h4>
        <p class="text-muted mb-0">Manage contact form submissions.</p>
    </div>
</div>

<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ !request('filter') || request('filter') === 'all' ? 'active' : '' }}"
           style="{{ !request('filter') || request('filter') === 'all' ? 'background:#6366f1;' : '' }}"
           href="{{ route('admin.messages.index', ['filter' => 'all']) }}">
            <i class="bi bi-inbox me-1"></i> All
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') === 'unread' ? 'active' : '' }}"
           style="{{ request('filter') === 'unread' ? 'background:#6366f1;' : '' }}"
           href="{{ route('admin.messages.index', ['filter' => 'unread']) }}">
            <i class="bi bi-envelope me-1"></i> Unread
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="badge bg-danger rounded-pill ms-1">{{ $unreadCount }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') === 'read' ? 'active' : '' }}"
           style="{{ request('filter') === 'read' ? 'background:#6366f1;' : '' }}"
           href="{{ route('admin.messages.index', ['filter' => 'read']) }}">
            <i class="bi bi-envelope-open me-1"></i> Read
        </a>
    </li>
</ul>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ !$message->is_read ? 'table-light' : '' }}">
                            <td>
                                @if(!$message->is_read)
                                    <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:#6366f1;"></span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $message->name }}</div>
                                <small class="text-muted">{{ $message->email }}</small>
                            </td>
                            <td>{{ Str::limit($message->subject, 50) }}</td>
                            <td>{{ $message->created_at->diffForHumans() }}</td>
                            <td>
                                @if($message->is_read)
                                    <span class="badge bg-secondary rounded-pill">Read</span>
                                @else
                                    <span class="badge rounded-pill" style="background:#6366f1;">Unread</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                       class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete"
                                                onclick="return confirm('Delete this message?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-envelope display-4 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No messages</h5>
                                <p class="text-muted mb-0">You're all caught up!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($messages, 'links'))
    <div class="mt-4">
        {{ $messages->links() }}
    </div>
@endif
@endsection
