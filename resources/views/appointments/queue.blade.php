@extends('layouts.admin')

@section('title', 'OPD Live Queue Board')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-users-line me-2"></i>OPD Live Queue Screen</h4>
        <p class="mb-0 text-white-50">Real-time Token Calling, Waiting Line & OPD Consultation Status</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('appointments.queue') }}" class="d-flex align-items-center gap-2">
            <select name="doctor_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- All OPD Doctors --</option>
                @foreach($doctors as $doc)
                    <option value="{{ $doc->id }}" {{ $doctorId == $doc->id ? 'selected' : '' }}>
                        {{ $doc->name }} ({{ $doc->specialization }})
                    </option>
                @endforeach
            </select>
        </form>
        <button onclick="window.location.reload()" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-rotate me-1"></i> Refresh
        </button>
    </div>
</div>

<!-- Current Token in Consultation (Hero Calling Box) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-lg text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border-radius: 18px;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-7 border-end-md">
                        <span class="badge bg-danger text-uppercase px-3 py-2 fs-6 mb-3 animate-pulse">
                            <i class="fa-solid fa-volume-high me-1"></i> Now Calling / In Consultation
                        </span>
                        @if($inConsultation)
                            <div class="display-3 fw-bold text-warning mb-2">
                                Token #{{ $inConsultation->token ?? $inConsultation->id }}
                            </div>
                            <h3 class="fw-bold mb-1">{{ $inConsultation->patient->name ?? 'Patient' }}</h3>
                            <p class="text-white-50 fs-5 mb-0">ID: {{ $inConsultation->patient->patient_id ?? 'N/A' }} | Mobile: {{ $inConsultation->patient->mobile ?? 'N/A' }}</p>
                        @else
                            <div class="display-4 fw-bold text-white-50 mb-2">Ready</div>
                            <h4 class="text-white-50">No patient currently inside consultation room.</h4>
                        @endif
                    </div>
                    <div class="col-md-5 text-md-end mt-4 mt-md-0 ps-md-4">
                        @if($inConsultation)
                            <div class="p-3 bg-white bg-opacity-10 rounded-4 text-start d-inline-block w-100">
                                <small class="text-white-50 text-uppercase fw-bold">Consulting Doctor</small>
                                <h4 class="fw-bold text-white mb-0">{{ $inConsultation->doctor->name ?? 'Doctor' }}</h4>
                                <div class="text-info">{{ $inConsultation->doctor->specialization ?? 'Specialist' }}</div>
                                <div class="mt-2 text-warning fw-bold fs-5">
                                    <i class="fa-solid fa-door-open me-1"></i> Room: {{ $inConsultation->doctor->room_no ?? 'OPD Room 1' }}
                                </div>
                            </div>
                        @else
                            <div class="text-center text-white-50 py-3">
                                <i class="fa-solid fa-stethoscope fs-1 mb-2 opacity-50"></i>
                                <p class="mb-0">Select waiting patient to call next.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Waiting Queue -->
    <div class="col-lg-7">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-clock-rotate-left text-warning me-2"></i>Waiting Queue ({{ $waitingAppointments->count() }})
                </h6>
                <span class="badge bg-warning text-dark">{{ $waitingAppointments->count() }} In Queue</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Token</th>
                            <th>Patient Name</th>
                            <th>Doctor</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($waitingAppointments as $wa)
                            <tr>
                                <td>
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        #{{ $wa->token ?? $wa->id }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $wa->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $wa->patient->patient_id ?? '' }}</small>
                                </td>
                                <td>
                                    {{ $wa->doctor->name ?? 'N/A' }}<br>
                                    <small class="text-muted">{{ $wa->doctor->room_no ?? 'OPD' }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $wa->time }}</span></td>
                                <td>
                                    <form action="{{ route('appointments.updateStatus', $wa->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="In Consultation">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa-solid fa-bell me-1"></i> Call Token
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No patients waiting in queue today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Completed Consultations -->
    <div class="col-lg-5">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-circle-check text-success me-2"></i>Completed Consultations
                </h6>
                <span class="badge bg-success">{{ $completedAppointments->count() }} Finished</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Token</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completedAppointments as $ca)
                            <tr>
                                <td><span class="badge bg-secondary">#{{ $ca->token ?? $ca->id }}</span></td>
                                <td>
                                    <strong>{{ $ca->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $ca->patient->patient_id ?? '' }}</small>
                                </td>
                                <td>{{ $ca->doctor->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">No completed consultations yet today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
