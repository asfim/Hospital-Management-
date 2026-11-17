@extends('layouts.admin')

@section('title', 'Operation Theatre (OT) Management')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-syringe me-2"></i>Operation Theatre (OT) Department</h4>
        <p class="mb-0 text-white-50">Surgical Schedules, OT Room Status, Anaesthesia & Operative Notes</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('ot.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Schedule Surgery
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- OT Rooms Live Status Cards -->
<div class="row g-3 mb-4">
    @foreach($rooms as $rm)
        @php
            $rmBadge = match($rm->status) {
                'available' => 'bg-success',
                'in_use' => 'bg-danger animate-pulse',
                'cleaning' => 'bg-warning text-dark',
                default => 'bg-secondary'
            };
        @endphp
        <div class="col-md-4">
            <div class="card card-premium p-3 border-start border-4 {{ $rm->status == 'in_use' ? 'border-danger' : 'border-primary' }} shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge {{ $rmBadge }} text-uppercase mb-1" style="font-size: 0.65rem;">{{ $rm->status }}</span>
                        <h5 class="fw-bold text-dark mb-0">{{ $rm->name }}</h5>
                        <small class="text-muted">{{ $rm->room_number }} | {{ $rm->type }}</small>
                    </div>
                    <div class="p-3 bg-light rounded-3 text-primary">
                        <i class="fa-solid fa-hospital-user fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Surgery Schedule Table -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold text-dark">Surgical Operations Roster</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('ot.index') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('ot.index', ['status' => 'scheduled']) }}" class="btn btn-sm {{ $status == 'scheduled' ? 'btn-primary' : 'btn-outline-secondary' }}">Scheduled</a>
            <a href="{{ route('ot.index', ['status' => 'in_progress']) }}" class="btn btn-sm {{ $status == 'in_progress' ? 'btn-danger' : 'btn-outline-secondary' }}">In Progress</a>
            <a href="{{ route('ot.index', ['status' => 'completed']) }}" class="btn btn-sm {{ $status == 'completed' ? 'btn-success' : 'btn-outline-secondary' }}">Completed</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Surgery #</th>
                    <th>Patient</th>
                    <th>Procedure</th>
                    <th>Lead Surgeon</th>
                    <th>OT Room</th>
                    <th>Schedule Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surgeries as $s)
                    @php
                        $sBadge = match($s->status) {
                            'scheduled' => 'bg-warning text-dark',
                            'in_progress' => 'bg-danger text-white',
                            'completed' => 'bg-success text-white',
                            default => 'bg-secondary'
                        };
                    @endphp
                    <tr>
                        <td><span class="id-badge">{{ $s->surgery_no }}</span></td>
                        <td>
                            <strong>{{ $s->patient->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $s->patient->patient_id }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">{{ $s->surgery_name }}</strong><br>
                            <span class="badge bg-light text-dark border">{{ $s->surgery_type }}</span>
                        </td>
                        <td>
                            <strong class="text-dark">Dr. {{ $s->leadSurgeon->name ?? 'Surgeon' }}</strong><br>
                            <small class="text-muted">Anes: Dr. {{ $s->anesthesiologist->name ?? 'N/A' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $s->room->name ?? 'OT Room' }}</span></td>
                        <td>
                            <small class="fw-bold">{{ $s->scheduled_start ? $s->scheduled_start->format('M d, Y') : '' }}</small><br>
                            <small class="text-muted">{{ $s->scheduled_start ? $s->scheduled_start->format('h:i A') : '' }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $sBadge }} text-uppercase">
                                {{ str_replace('_', ' ', $s->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('ot.show', $s->id) }}" class="action-btn action-btn-view" title="Open Surgical File">
                                <i class="fa-solid fa-file-medical"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fa-solid fa-syringe fs-1 mb-2 text-primary opacity-50"></i>
                            <p class="mb-0">No surgeries found in roster.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($surgeries->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $surgeries->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
