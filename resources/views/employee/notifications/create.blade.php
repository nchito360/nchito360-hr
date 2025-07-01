@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📝 Post a New Notification</h3>

    <form action="{{ route('notifications.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="scope" class="form-label">Visibility Scope</label>
            <select name="scope" class="form-select" required>
                <option value="">-- Select Scope --</option>
                <option value="company" {{ old('scope') == 'company' ? 'selected' : '' }}>Entire Company</option>
                <option value="department" {{ old('scope') == 'department' ? 'selected' : '' }}>Your Department</option>
                <option value="team" {{ old('scope') == 'team' ? 'selected' : '' }}>Your Team</option>
            </select>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Post Notification</button>
            <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
