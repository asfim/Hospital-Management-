@extends('layouts.admin')

@section('title', 'Emergency & Triage Department')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-truck-medical me-2"></i>Emergency (ER) & Triage</h4>
        <p class="mb-0 text-white-50">Rapid Patient Triage, Emergency Treatments & Direct Ward Transfers</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('emergency.create') }}" class="btn btn-danger btn-sm shadow-sm fw-bold px-3">
            <i class="fa-solid fa-plus-circle me-1"></i> New Emergency Intake
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Triage Priority Counters -->
<div class="row g-3 mb-4">
    <!-- Red - Resuscitation -->
    <div class="col-6 col-md-3">
        <a href="{{ route('emergency.index', ['priority' => 'red']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-danger border-4 shadow-sm {{ $priority == 'red' ? 'bg-danger bg-opacity-10' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-danger fw-bold" style="font-size: 0.75rem;">🔴 RED (Immediate)</span>
                        <h2 class="fw-bold mb-0 text-danger mt-1">{{ $counts['red'] }}</h2>
                        <small class="text-muted">Resuscitation Needed</small>
                    </div>
                    <div class="p-2 bg-danger text-white rounded-3">
                        <i class="fa-solid fa-heart-crack fs-4"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Orange - Emergent -->
    <div class="col-6 col-md-3">
        <a href="{{ route('emergency.index', ['priority' => 'orange']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-warning border-4 shadow-sm {{ $priority == 'orange' ? 'bg-warning bg-opacity-10' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-warning fw-bold" style="font-size: 0.75rem;">🟠 ORANGE (Emergent)</span>
                        <h2 class="fw-bold mb-0 text-dark mt-1">{{ $counts['orange'] }}</h2>
                        <small class="text-muted">< 15 mins response</small>
                    </div>
                    <div class="p-2 bg-warning text-dark rounded-3">
                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Yellow - Urgent -->
    <div class="col-6 col-md-3">
        <a href="{{ route('emergency.index', ['priority' => 'yellow']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-info border-4 shadow-sm {{ $priority == 'yellow' ? 'bg-info bg-opacity-10' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-info fw-bold" style="font-size: 0.75rem;">🟡 YELLOW (Urgent)</span>
                        <h2 class="fw-bold mb-0 text-info mt-1">{{ $counts['yellow'] }}</h2>
                        <small class="text-muted">< 30 mins response</small>
                    </div>
                    <div class="p-2 bg-info text-white rounded-3">
                        <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Green - Non-Urgent -->
    <div class="col-6 col-md-3">
        <a href="{{ route('emergency.index', ['priority' => 'green']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-success border-4 shadow-sm {{ $priority == 'green' ? 'bg-success bg-opacity-10' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-success fw-bold" style="font-size: 0.75rem;">🟢 GREEN (Standard)</span>
                        <h2 class="fw-bold mb-0 text-success mt-1">{{ $counts['green'] }}</h2>
                        <small class="text-muted">Stable Condition</small>
                    </div>
                    <div class="p-2 bg-success text-white rounded-3">
                        <i class="fa-solid fa-shield-halved fs-4"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Emergency Cases Table -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark">Emergency Patient Register</h6>
            @if($priority)
                <span class="badge bg-secondary">Filtered: {{ strtoupper($priority) }}</span>
                <a href="{{ route('emergency.index') }}" class="text-danger small ms-1"><i class="fa-solid fa-xmark"></i> Clear</a>
            @endif
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('emergency.index', ['status' => 'active']) }}" class="btn btn-sm {{ $status == 'active' ? 'btn-primary' : 'btn-outline-secondary' }}">Active in ER</a>
            <a href="{{ route('emergency.index', ['status' => 'all']) }}" class="btn btn-sm {{ $status == 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">All History</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Triage Priority</th>
                    <th>Case #</th>
                    <th>Patient Details</th>
                    <th>Arrival Mode / Time</th>
                    <th>Complaints</th>
                    <th>Assigned Doctor / Nurse</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emergencyCases as $case)
                    @php
                        $badgeClass = match($case->triage_priority) {
                            'red' => 'bg-danger text-white',
                            'orange' => 'bg-warning text-dark',
                            'yellow' => 'bg-info text-dark',
                            'green' => 'bg-success text-white',
                            default => 'bg-secondary text-white'
                        };
                    @endphp
                    <tr>
                        <td>
                            <span class="badge {{ $badgeClass }} text-uppercase fw-bold px-2 py-1">
                                <i class="fa-solid fa-circle me-1" style="font-size: 0.6rem;"></i>{{ $case->triage_priority }}
                            </span>
                        </td>
                        <td><span class="id-badge">{{ $case->case_no }}</span></td>
                        <td>
                            <strong>{{ $case->patient->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">
                                {{ $case->patient->age ? $case->patient->age . ' Y,' : '' }} 
                                {{ ucfirst($case->patient->gender ?? '') }} | 
                                {{ $case->patient->mobile ?? 'No phone' }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $case->arrival_mode }}</span><br>
                            <small class="text-muted">{{ $case->arrival_time ? $case->arrival_time->format('h:i A (M d)') : '' }}</small>
                        </td>
                        <td>
                            <p class="mb-0 text-truncate" style="max-width: 220px;" title="{{ $case->presenting_complaints }}">
                                {{ $case->presenting_complaints }}
                            </p>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $case->doctor->name ?? 'Doctor: Unassigned' }}</small><br>
                            <small class="text-muted">{{ $case->nurse->name ?? 'Nurse: Unassigned' }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $case->status == 'triaged' ? 'bg-danger' : ($case->status == 'under_treatment' ? 'bg-warning text-dark' : 'bg-success') }}">
                                {{ str_replace('_', ' ', $case->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('emergency.show', $case->id) }}" class="action-btn action-btn-view" title="View Emergency Care">
                                    <i class="fa-solid fa-stethoscope"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fa-solid fa-check-double fs-1 mb-2 text-success opacity-50"></i>
                            <p class="mb-0">No emergency cases match this filter.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($emergencyCases->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $emergencyCases->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
