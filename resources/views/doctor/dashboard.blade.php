@extends('layouts.admin')

@section('title', 'Doctor Clinical Workspace')

@section('content')
<!-- Doctor Clinical Welcome Header -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(13, 148, 136, 0.25); border: 1px solid rgba(45, 212, 191, 0.35);">
            <span style="width: 8px; height: 8px; background: #2dd4bf; border-radius: 50%; display: inline-block;"></span>
            <span style="font-size: 0.74rem; font-weight: 700; color: #2dd4bf; text-transform: uppercase; letter-spacing: 0.5px;">Clinical Chamber Active</span>
        </div>
        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-stethoscope me-2" style="color: #2dd4bf;"></i>Welcome, Dr. {{ auth()->user()->name }}</h4>
        <p class="mb-0 text-white-50">Manage patient token calling, consultations, electronic prescriptions, and diagnostic test referrals</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('appointments.queue') }}" class="btn btn-erp-teal shadow-sm">
            <i class="fa-solid fa-tv me-1"></i> OPD Calling Screen
        </a>
    </div>
</div>

<!-- Doctor Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Today's Appointments -->
    <div class="col-md-4">
        <div class="erp-kpi-card kpi-teal">
            <div>
                <div class="kpi-label">Today's Appointments</div>
                <div class="kpi-value" style="color: var(--erp-secondary) !important;">{{ $today_appointments_count }}</div>
                <div class="kpi-sub text-muted">Scheduled for your chamber today</div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Consultations / Appointments -->
    <div class="col-md-4">
        <div class="erp-kpi-card kpi-primary">
            <div>
                <div class="kpi-label">Total Consultations</div>
                <div class="kpi-value text-primary" style="color: var(--erp-primary) !important;">{{ $total_appointments }}</div>
                <div class="kpi-sub text-muted">All-time patient consultations</div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
        </div>
    </div>

    <!-- Quick Clinical Action -->
    <div class="col-md-4">
        <div class="erp-kpi-card kpi-info">
            <div>
                <div class="kpi-label">Chamber Room</div>
                <div class="kpi-value text-info">OPD-01</div>
                <div class="kpi-sub text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i>Ready for consultations</div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-door-open"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Today's Schedule Table -->
    <div class="col-lg-8">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-calendar-check text-teal me-2" style="color: var(--erp-secondary);"></i>Today's Appointment Schedule</h6>
                <a href="{{ route('appointments.index') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="erp-table align-middle">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient Name</th>
                            <th>Token</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($today_appointments as $appointment)
                            <tr>
                                <td><span class="erp-badge erp-badge-teal fw-bold">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span></td>
                                <td>
                                    <strong>{{ $appointment->patient->name ?? 'Unknown' }}</strong><br>
                                    <small class="text-muted">{{ $appointment->patient->phone ?? '' }}</small>
                                </td>
                                <td><span class="erp-badge-id">#{{ $appointment->token }}</span></td>
                                <td>
                                    <select class="form-select form-select-sm status-dropdown shadow-sm {{ $appointment->status == 'Pending' ? 'bg-warning text-dark' : ($appointment->status == 'Confirmed' ? 'bg-success text-white' : 'bg-secondary text-white') }}" data-id="{{ $appointment->id }}" style="width: 110px; font-weight: 500; cursor: pointer; border-radius: 20px;">
                                        <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Confirmed" {{ $appointment->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1.5">
                                        <a href="{{ route('appointments.show', $appointment->id) }}" class="erp-action-btn" title="View Details">
                                            <i class="fa-solid fa-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('consultations.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-erp-teal btn-sm py-1 px-2.5 rounded-3 d-inline-flex align-items-center gap-1 shadow-sm" title="Start Consultation">
                                            <i class="fa-solid fa-stethoscope"></i> Consult
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No appointments scheduled for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Appointments Card -->
    <div class="col-lg-4">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-clock-rotate-left text-primary me-2" style="color: var(--erp-primary);"></i>Upcoming Appointments</h6>
            </div>
            <div class="erp-card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($upcoming_appointments as $appointment)
                        <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="text-dark">{{ $appointment->patient->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</small>
                            </div>
                            <span class="erp-badge {{ $appointment->status == 'Scheduled' ? 'erp-badge-warning' : 'erp-badge-teal' }}">
                                {{ $appointment->status }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item px-3 py-4 text-center text-muted">No upcoming appointments recorded.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.status-dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const appointmentId = this.dataset.id;
            const newStatus = this.value;
            const selectElement = this;

            fetch(`/appointments/${appointmentId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selectElement.className = 'form-select form-select-sm status-dropdown shadow-sm';
                    if (newStatus === 'Pending') selectElement.classList.add('bg-warning', 'text-dark');
                    else if (newStatus === 'Confirmed') selectElement.classList.add('bg-success', 'text-white');
                    else selectElement.classList.add('bg-secondary', 'text-white');
                } else {
                    alert('Failed to update status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating status.');
            });
        });
    });
});
</script>
@endpush
