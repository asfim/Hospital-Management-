@extends('layouts.admin')

@section('title', 'Nursing Station & Inpatient Care')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-user-nurse me-2"></i>Nursing Station & Inpatient Care</h4>
        <p class="mb-0 text-white-50">Patient Vitals Monitoring, Shift Notes, Handovers & Medication Records</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('nursing.mar') }}" class="btn btn-warning text-dark fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-pills me-1"></i> Medication Chart (MAR)
        </a>
        <a href="{{ route('nursing.roster') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-calendar-days me-1"></i> Duty Rosters
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Inpatient Ward Bed Monitoring Table -->
<div class="card card-premium shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-bed-pulse text-primary me-2"></i>Active Inpatients Under Care</h6>
        <span class="badge bg-primary">{{ $admissions->count() }} Inpatients</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Bed / Ward</th>
                    <th>Patient</th>
                    <th>Admitted</th>
                    <th>Latest Vitals (BP, HR, SpO2)</th>
                    <th>Consultant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $adm)
                    @php $latestVital = $adm->vitals->first(); @endphp
                    <tr>
                        <td>
                            <strong class="fs-6 text-primary">{{ $adm->bed->bed_number ?? 'Bed' }}</strong><br>
                            <small class="badge bg-light text-dark border">{{ $adm->ward->name ?? 'Ward' }}</small>
                        </td>
                        <td>
                            <strong>{{ $adm->patient->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">
                                {{ $adm->patient->patient_id }} | 
                                {{ $adm->patient->age }} Y, {{ ucfirst($adm->patient->gender) }}
                            </small>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $adm->admission_date ? $adm->admission_date->format('M d, Y') : '' }}</small><br>
                            <small class="text-muted">{{ $adm->admission_no }}</small>
                        </td>
                        <td>
                            @if($latestVital)
                                <div style="font-size: 0.82rem;">
                                    <span class="badge bg-light text-dark border me-1">BP: {{ $latestVital->systolic_bp }}/{{ $latestVital->diastolic_bp }}</span>
                                    <span class="badge bg-light text-dark border me-1">HR: {{ $latestVital->pulse_rate }}</span>
                                    <span class="badge {{ $latestVital->spo2 < 95 ? 'bg-danger' : 'bg-success' }}">SpO2: {{ $latestVital->spo2 }}%</span>
                                </div>
                                <small class="text-muted" style="font-size: 0.72rem;">{{ $latestVital->recorded_at ? $latestVital->recorded_at->diffForHumans() : '' }}</small>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-dark">No vitals charted yet</span>
                            @endif
                        </td>
                        <td><small>{{ $adm->doctor->name ?? 'Unassigned' }}</small></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admissions.show', $adm->id) }}" class="btn btn-sm btn-outline-primary" title="Inpatient File">
                                    <i class="fa-solid fa-file-waveform me-1"></i> Chart
                                </a>
                                <a href="{{ route('nursing.mar', ['admission_id' => $adm->id]) }}" class="btn btn-sm btn-outline-warning text-dark" title="MAR Medications">
                                    <i class="fa-solid fa-pills me-1"></i> MAR
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No patients currently admitted in wards.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Shift Handover Notes -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-notes-medical text-info me-2"></i>Recent Nursing Shift Notes & Handovers</h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            @forelse($recentNotes as $note)
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-info text-white me-1">{{ $note->shift }} Shift</span>
                                <span class="badge bg-light text-dark border">{{ $note->note_type }}</span>
                                <strong class="ms-1">{{ $note->admission->patient->name ?? 'Patient' }}</strong>
                            </div>
                            <small class="text-muted">{{ $note->recorded_at ? $note->recorded_at->format('M d, h:i A') : '' }}</small>
                        </div>
                        <p class="mb-1 text-dark" style="font-size: 0.88rem;">{{ $note->content }}</p>
                        <small class="text-secondary"><i class="fa-solid fa-user-nurse me-1"></i>Logged by: {{ $note->nurse->name ?? 'Duty Nurse' }}</small>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">No recent shift notes logged.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
