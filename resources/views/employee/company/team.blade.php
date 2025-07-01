@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-2">👥 My Team</h4>
    <p class="mb-4 text-muted">Meet your colleagues and explore your team's structure by department.</p>

    @if($teamMembers->isEmpty())
        {{-- Empty State --}}
        <div class="text-center my-5">
            <img src="{{ asset('hr-app/assets/img/illustrations/404.png') }}" alt="No Team" style="max-width: 300px;" class="mb-4">
            <h5 class="fw-semibold text-muted">No team members added yet</h5>
            <p class="text-muted">Once your company admin adds employees, they will appear here.</p>
        </div>
    @else
        {{-- Group by department --}}
        @php
            $grouped = $teamMembers->groupBy('department');
        @endphp

        @foreach($grouped as $department => $members)
        <div class="mb-5">
            <h5 class="text-primary border-bottom pb-2 mb-4">
                <i class="bx bx-building-house me-1"></i>
                {{ $department ?? 'Unassigned Department' }}
            </h5>

            <div class="row g-4">
                @foreach($members as $member)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $member->first_name }} {{ $member->last_name }}</h6>
                                    <small class="text-muted">{{ $member->position ?? 'Position N/A' }}</small>
                                </div>
                            </div>

                            <ul class="list-unstyled small text-muted">
                                <li><i class="bx bx-building me-1"></i> <strong>Department:</strong> {{ $member->department ?? 'N/A' }}</li>
                                <li><i class="bx bx-map-pin me-1"></i> <strong>Branch:</strong> {{ $member->branch ?? 'N/A' }}</li>
                                <li><i class="bx bx-envelope me-1"></i> <strong>Email:</strong> <a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
