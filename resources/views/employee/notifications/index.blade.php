@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📢 Company Notifications</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4 text-end">
        <a href="{{ route('notifications.create') }}" class="btn btn-primary">+ New Notification</a>
    </div>

    @if ($notifications->count())
        <div class="list-group">
            @foreach ($notifications as $note)
                <div class="list-group-item mb-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">{{ $note->title }}</h5>
                        <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $note->message }}</p>
                    <small class="text-muted">
                        By: {{ $note->user->name }} |
                        Scope: <strong>{{ ucfirst($note->scope) }}</strong>
                    </small>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No notifications to show.</p>
    @endif
</div>
@endsection
