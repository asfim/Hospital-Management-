@extends('layouts.admin')

@section('title', 'Hospital Executive Dashboard')

@section('content')
<!-- Page Header with Hospital Quick Actions -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-hospital-user me-2"></i>Hospital Management System</h4>
        <p class="mb-0 text-white-50">Real-time Clinical, Inpatient, Outpatient, Emergency & Financial Operations</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('patients.create') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-user-plus me-1"></i> New Patient
        </a>
        <a href="{{ route('appointments.create') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-calendar-plus me-1"></i> Book OPD
        </a>
        <a href="{{ route('emergency.create') }}" class="btn btn-danger btn-sm shadow-sm">
            <i class="fa-solid fa-truck-medical me-1"></i> Emergency Intake
        </a>
        <a href="{{ route('admissions.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-bed-pulse me-1"></i> IPD Admission
        </a>
    </div>
</div>

<!-- Primary Hospital KPI Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Active IPD Admissions -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-premium h-100 border-start border-primary border-4 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem;">Active IPD Inpatients</span>
                        <h3 class="fw-bold mb-0 text-primary mt-1">{{ $active_admissions }}</h3>
                        <small class="text-success"><i class="fa-solid fa-arrow-up"></i> {{ $today_admissions }} today / {{ $today_discharges }} discharges</small>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-primary">
                        <i class="fa-solid fa-bed-pulse fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bed Occupancy -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-premium h-100 border-start border-info border-4 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem;">Bed Occupancy</span>
                        <h3 class="fw-bold mb-0 text-info mt-1">{{ $occupied_beds }} / {{ $total_beds }}</h3>
                        <small class="text-muted"><span class="fw-bold text-dark">{{ $available_beds }}</span> beds available ({{ $bed_occupancy_rate }}%)</small>
                    </div>
                    <div class="p-3 bg-info bg-opacity-10 rounded-4 text-info">
                        <i class="fa-solid fa-procedures fs-3"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $bed_occupancy_rate }}%" aria-valuenow="{{ $bed_occupancy_rate }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Patients -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-premium h-100 border-start border-danger border-4 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem;">Emergency (ER) Cases</span>
                        <h3 class="fw-bold mb-0 text-danger mt-1">{{ $today_emergency }}</h3>
                        <small class="text-danger fw-semibold"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $active_emergency }} active in ER</small>
                    </div>
                    <div class="p-3 bg-danger bg-opacity-10 rounded-4 text-danger">
                        <i class="fa-solid fa-truck-medical fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Hospital Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-premium h-100 border-start border-success border-4 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem;">Today's Gross Collection</span>
                        <h3 class="fw-bold mb-0 text-success mt-1">৳ {{ number_format($today_revenue, 2) }}</h3>
                        <small class="text-muted">Expenses: ৳ {{ number_format($today_expenses, 2) }}</small>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 rounded-4 text-success">
                        <i class="fa-solid fa-wallet fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Metrics -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-secondary mb-1"><i class="fa-solid fa-users fs-4"></i></div>
            <h5 class="fw-bold mb-0">{{ $total_patients }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Total Patients</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-primary mb-1"><i class="fa-solid fa-user-doctor fs-4"></i></div>
            <h5 class="fw-bold mb-0">{{ $total_doctors }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Doctors on Duty</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-warning mb-1"><i class="fa-solid fa-calendar-check fs-4"></i></div>
            <h5 class="fw-bold mb-0">{{ $today_appointments }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Today's OPD</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-info mb-1"><i class="fa-solid fa-pills fs-4"></i></div>
            <h5 class="fw-bold mb-0">৳ {{ number_format($today_pharmacy_sales, 0) }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Pharmacy Sales</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-dark mb-1"><i class="fa-solid fa-microscope fs-4"></i></div>
            <h5 class="fw-bold mb-0">{{ $total_lab_orders }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Diagnostic Orders</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="card card-premium p-3 text-center border-0 shadow-sm">
            <div class="text-danger mb-1"><i class="fa-solid fa-hospital-user fs-4"></i></div>
            <h5 class="fw-bold mb-0">{{ $total_staff }}</h5>
            <small class="text-muted" style="font-size: 0.75rem;">Hospital Staff</small>
        </div>
    </div>
</div>

<!-- Bed Occupancy Matrix & Financial Chart -->
<div class="row g-4 mb-4">
    <!-- Wards Status Visualizer -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-hospital text-primary me-2"></i>Ward & Bed Occupancy</h6>
                <a href="{{ route('beds.matrix') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                    Full Bed Matrix <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-3">
                @forelse($wards as $w)
                    @php
                        $rate = $w->total_beds_count > 0 ? round(($w->occupied_beds_count / $w->total_beds_count) * 100) : 0;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark" style="font-size: 0.88rem;">{{ $w->name }}</span>
                            <span class="badge {{ $rate >= 80 ? 'bg-danger' : ($rate >= 50 ? 'bg-warning text-dark' : 'bg-success') }}">
                                {{ $w->occupied_beds_count }} / {{ $w->total_beds_count }} Beds ({{ $rate }}%)
                            </span>
                        </div>
                        <div class="progress" style="height: 7px; border-radius: 4px;">
                            <div class="progress-bar {{ $rate >= 80 ? 'bg-danger' : ($rate >= 50 ? 'bg-warning' : 'bg-success') }}" 
                                 role="progressbar" style="width: {{ $rate }}%" aria-valuenow="{{ $rate }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">No wards configured.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 7-Day Revenue Trend Chart -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-chart-line text-success me-2"></i>7-Day Hospital Revenue Trend</h6>
                <span class="badge bg-light text-secondary">Last 7 Days</span>
            </div>
            <div class="card-body p-3">
                <canvas id="revenueTrendChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Active Admissions & Emergency Queue -->
<div class="row g-4 mb-4">
    <!-- Active IPD Admissions Table -->
    <div class="col-lg-7">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-bed-pulse text-primary me-2"></i>Current Inpatient Admissions</h6>
                <a href="{{ route('admissions.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Admission #</th>
                            <th>Patient</th>
                            <th>Ward / Bed</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_admissions as $adm)
                            <tr>
                                <td><span class="id-badge">{{ $adm->admission_no }}</span></td>
                                <td>
                                    <strong>{{ $adm->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $adm->patient->patient_id ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $adm->ward->name ?? 'Ward' }}
                                    </span>
                                    <div class="fw-bold text-primary" style="font-size: 0.8rem;">
                                        {{ $adm->bed->bed_number ?? 'Bed N/A' }}
                                    </div>
                                </td>
                                <td><small class="text-secondary">{{ $adm->doctor->name ?? 'Unassigned' }}</small></td>
                                <td><small>{{ $adm->admission_date ? $adm->admission_date->format('M d, Y') : '' }}</small></td>
                                <td>
                                    <a href="{{ route('admissions.show', $adm->id) }}" class="action-btn action-btn-view" title="View Admission Profile">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No active admissions recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Emergency Queue -->
    <div class="col-lg-5">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-truck-medical text-danger me-2"></i>Emergency Triage Queue</h6>
                <a href="{{ route('emergency.index') }}" class="btn btn-sm btn-outline-danger rounded-pill">ER Board</a>
            </div>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Triage</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_emergency as $emg)
                            @php
                                $badgeClass = match($emg->triage_priority) {
                                    'red' => 'bg-danger text-white',
                                    'orange' => 'bg-warning text-dark',
                                    'yellow' => 'bg-info text-dark',
                                    'green' => 'bg-success text-white',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span class="badge {{ $badgeClass }} text-uppercase">
                                        {{ $emg->triage_priority }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $emg->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $emg->case_no }}</small>
                                </td>
                                <td><small>{{ $emg->doctor->name ?? 'On Call' }}</small></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ str_replace('_', ' ', $emg->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No active emergency cases.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent OPD Appointments & Recent Patients -->
<div class="row g-4 mb-4">
    <!-- Today's Appointments -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-calendar-check text-primary me-2"></i>OPD Appointments</h6>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Manage</a>
            </div>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_appointments as $apt)
                            <tr>
                                <td>
                                    <strong>{{ $apt->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $apt->appointment_id }}</small>
                                </td>
                                <td>{{ $apt->doctor->name ?? 'N/A' }}</td>
                                <td><small class="badge bg-light text-dark">{{ $apt->time ?? 'Queue' }}</small></td>
                                <td>
                                    <span class="badge {{ $apt->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $apt->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No appointments today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recently Registered Patients -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-users text-info me-2"></i>Recently Registered Patients</h6>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Blood Group</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_patients as $p)
                            <tr>
                                <td><span class="id-badge">{{ $p->patient_id }}</span></td>
                                <td><strong>{{ $p->name }}</strong></td>
                                <td><small>{{ $p->mobile }}</small></td>
                                <td><span class="badge bg-danger bg-opacity-10 text-danger fw-bold">{{ $p->blood_group ?? 'N/A' }}</span></td>
                                <td>
                                    <a href="{{ route('patients.show', $p->id) }}" class="action-btn action-btn-view" title="Patient Profile">
                                        <i class="fa-solid fa-id-card"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No patients registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueTrendChart');
        if (ctx) {
            const labels = {!! $chart_dates !!};
            const data = {!! $chart_revenue !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Hospital Revenue (৳)',
                        data: data,
                        borderColor: '#0d9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#0d9488',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return '৳ ' + value.toLocaleString(); }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
