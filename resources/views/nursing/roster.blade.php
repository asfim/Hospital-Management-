@extends('layouts.admin')

@section('title', 'Nursing Duty Roster')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('nursing.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-calendar-days me-2"></i>Nursing Shift Duty Roster</h4>
                <p class="mb-0 text-white-50">Assign Nurses to Inpatient Wards & Monitor Shift Coverage</p>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('nursing.roster') }}" class="d-flex align-items-center gap-2">
            <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}" onchange="this.form.submit()">
        </form>
        <button type="button" class="btn btn-premium-new btn-sm" data-bs-toggle="modal" data-bs-target="#assignRosterModal">
            <i class="fa-solid fa-plus me-1"></i> Assign Shift
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Shift Duty Table -->
    <div class="col-12">
        <div class="card card-premium shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-clock text-primary me-2"></i>Duty Roster for {{ date('l, F d, Y', strtotime($date)) }}
                </h6>
                <span class="badge bg-primary">{{ count($assignments) }} Shifts Scheduled</span>
            </div>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nurse Name</th>
                            <th>Shift</th>
                            <th>Assigned Inpatient</th>
                            <th>Ward & Bed</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assign)
                            <tr>
                                <td>
                                    <strong>{{ $assign->nurse->name ?? 'Duty Nurse' }}</strong><br>
                                    <small class="text-muted">{{ $assign->nurse->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $assign->shift == 'Night' ? 'bg-dark' : ($assign->shift == 'Evening' ? 'bg-warning text-dark' : 'bg-info text-white') }} px-3 py-1 fs-6">
                                        {{ $assign->shift }} Shift
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $assign->admission->patient->name ?? 'Patient' }}</strong><br>
                                    <small class="text-muted">{{ $assign->admission->admission_no }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $assign->admission->ward->name ?? 'Ward' }}</span>
                                    <strong class="text-primary ms-1">{{ $assign->admission->bed->bed_number ?? 'Bed' }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $assign->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    No nurse shift assignments scheduled for this date. Click "Assign Shift" to schedule.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign Shift -->
<div class="modal fade" id="assignRosterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('nursing.storeRoster') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-user-plus me-2"></i>Assign Nurse to Patient / Ward Shift</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Duty Nurse <span class="text-danger">*</span></label>
                        <select name="nurse_id" class="form-select" required>
                            <option value="">-- Choose Nurse --</option>
                            @foreach($nurses as $nurse)
                                <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Inpatient Patient / Bed <span class="text-danger">*</span></label>
                        <select name="admission_id" class="form-select" required>
                            <option value="">-- Choose Inpatient --</option>
                            @foreach($admissions as $adm)
                                <option value="{{ $adm->id }}">
                                    {{ $adm->bed->bed_number ?? 'Bed' }} - {{ $adm->patient->name ?? 'Patient' }} ({{ $adm->ward->name ?? 'Ward' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Roster Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                            <select name="shift" class="form-select" required>
                                <option value="Morning">Morning (08:00 AM - 02:00 PM)</option>
                                <option value="Evening">Evening (02:00 PM - 08:00 PM)</option>
                                <option value="Night">Night (08:00 PM - 08:00 AM)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Save Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
