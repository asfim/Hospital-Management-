@extends('layouts.admin')

@section('title', 'Doctor Profile - ' . $doctor->name)

@section('content')
<!-- Page Header -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">{{ $doctor->name }}</h4>
                <p class="mb-0 text-white-50">{{ $doctor->specialization }} | Doctor ID: <strong class="text-white">{{ $doctor->doctor_id }}</strong></p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-user-pen me-1"></i> Edit Doctor
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Doctor Card -->
    <div class="col-lg-4">
        <div class="card card-premium shadow-sm text-center p-4 h-100">
            <div class="mb-3">
                @if($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #e0e7ff;">
                @else
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: 700;">
                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h5 class="fw-bold mb-1">{{ $doctor->name }}</h5>
            <span class="badge bg-primary bg-opacity-10 text-primary mb-3">{{ $doctor->specialization }}</span>

            <div class="text-start border-top pt-3 mt-2" style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i>Qualification:</span>
                    <span class="fw-semibold">{{ $doctor->qualification ?? 'MBBS' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-id-badge me-2 text-primary"></i>BMDC Reg:</span>
                    <span class="fw-semibold">{{ $doctor->bmdc_reg ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room No:</span>
                    <span class="fw-bold text-dark">{{ $doctor->room_no ?? 'OPD Room' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-phone me-2 text-primary"></i>Mobile:</span>
                    <span>{{ $doctor->mobile ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-envelope me-2 text-primary"></i>Email:</span>
                    <span>{{ $doctor->email ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-money-bill-wave me-2 text-success"></i>OPD Fee:</span>
                    <span class="fw-bold text-success">৳ {{ number_format($doctor->consultation_fee, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-bed-pulse me-2 text-info"></i>IPD Round Fee:</span>
                    <span class="fw-bold text-info">৳ {{ number_format($doctor->ipd_round_charge ?? 500, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Schedules & Operations -->
    <div class="col-lg-8">
        <!-- Schedule Card -->
        <div class="card card-premium shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-clock text-primary me-2"></i>Weekly Consultation Schedule</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Day</th>
                            <th>Time Window</th>
                            <th>Room</th>
                            <th>Patient Limit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctor->schedules as $sch)
                            <tr>
                                <td><strong>{{ $sch->day }}</strong></td>
                                <td><span class="badge bg-light text-dark border">{{ $sch->start_time }} - {{ $sch->end_time }}</span></td>
                                <td>{{ $sch->room ?? ($doctor->room_no ?? 'OPD') }}</td>
                                <td>{{ $sch->patient_limit ?? 30 }} Patients</td>
                                <td>
                                    <span class="badge {{ $sch->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $sch->is_active ? 'Active' : 'Off' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No specific schedule added yet. Default consultation available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Consultations -->
        <div class="card card-premium shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-stethoscope text-primary me-2"></i>Recent Patient Consultations</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Appointment #</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctor->appointments->take(6) as $apt)
                            <tr>
                                <td><span class="id-badge">{{ $apt->appointment_id }}</span></td>
                                <td><strong>{{ $apt->patient->name ?? 'N/A' }}</strong></td>
                                <td>{{ $apt->date }} {{ $apt->time }}</td>
                                <td>
                                    <span class="badge {{ $apt->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $apt->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No consultations recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
