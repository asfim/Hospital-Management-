@extends('layouts.admin')

@section('title', 'Hospital Executive Dashboard')

@section('content')
<!-- Page Header with Hospital Operational Identity & Quick Actions -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(13, 148, 136, 0.25); border: 1px solid rgba(45, 212, 191, 0.35);">
            <span style="width: 8px; height: 8px; background: #2dd4bf; border-radius: 50%; display: inline-block;"></span>
            <span style="font-size: 0.74rem; font-weight: 700; color: #2dd4bf; text-transform: uppercase; letter-spacing: 0.5px;">Live Hospital Operations</span>
        </div>
        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-hospital-user me-2" style="color: #2dd4bf;"></i>Dhaka Central Hospital & ERP Center</h4>
        <p class="mb-0 text-white-50">Real-time Clinical Governance, Inpatient Beds, Emergency Triage & Financial Analytics</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('patients.create') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-user-plus me-1"></i> New Patient
        </a>
        <a href="{{ route('appointments.create') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-calendar-plus me-1"></i> Book OPD
        </a>
        <a href="{{ route('emergency.create') }}" class="btn btn-danger btn-sm shadow-sm fw-semibold">
            <i class="fa-solid fa-truck-medical me-1"></i> Emergency Intake
        </a>
        <a href="{{ route('admissions.create') }}" class="btn btn-erp-teal btn-sm shadow-sm fw-semibold">
            <i class="fa-solid fa-bed-pulse me-1"></i> IPD Admission
        </a>
    </div>
</div>

<!-- Primary Hospital KPI Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Active IPD Admissions -->
    <div class="col-xl-3 col-md-6">
        <div class="erp-kpi-card kpi-primary">
            <div>
                <div class="kpi-label">Active IPD Inpatients</div>
                <div class="kpi-value text-primary" style="color: var(--erp-primary) !important;">{{ $active_admissions }}</div>
                <div class="kpi-sub text-success fw-semibold">
                    <i class="fa-solid fa-arrow-up"></i> {{ $today_admissions }} today &bull; {{ $today_discharges }} discharged
                </div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-bed-pulse"></i>
            </div>
        </div>
    </div>

    <!-- Bed Occupancy -->
    <div class="col-xl-3 col-md-6">
        <div class="erp-kpi-card kpi-teal">
            <div>
                <div class="kpi-label">Bed Occupancy Rate</div>
                <div class="kpi-value" style="color: var(--erp-secondary) !important;">{{ $bed_occupancy_rate }}%</div>
                <div class="kpi-sub">
                    <strong class="text-dark">{{ $occupied_beds }}</strong> / {{ $total_beds }} occupied ({{ $available_beds }} free)
                </div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-procedures"></i>
            </div>
        </div>
    </div>

    <!-- Emergency Cases -->
    <div class="col-xl-3 col-md-6">
        <div class="erp-kpi-card kpi-danger">
            <div>
                <div class="kpi-label">Emergency (ER) Cases</div>
                <div class="kpi-value text-danger">{{ $today_emergency }}</div>
                <div class="kpi-sub text-danger fw-semibold">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $active_emergency }} active in trauma unit
                </div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
        </div>
    </div>

    <!-- Today's Hospital Gross Collection -->
    <div class="col-xl-3 col-md-6">
        <div class="erp-kpi-card kpi-success">
            <div>
                <div class="kpi-label">Today's Revenue</div>
                <div class="kpi-value text-success">৳ {{ number_format($today_revenue, 0) }}</div>
                <div class="kpi-sub text-muted">
                    Expenses: ৳ {{ number_format($today_expenses, 0) }}
                </div>
            </div>
            <div class="kpi-icon-box">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Operational Metric Strip -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-users fs-5 text-primary" style="color: var(--erp-primary) !important;"></i></div>
            <h4 class="fw-bold mb-0 text-dark">{{ $total_patients }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Total Patients</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-user-doctor fs-5 text-teal" style="color: var(--erp-secondary) !important;"></i></div>
            <h4 class="fw-bold mb-0 text-dark">{{ $total_doctors }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Doctors on Duty</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-calendar-check fs-5 text-warning"></i></div>
            <h4 class="fw-bold mb-0 text-dark">{{ $today_appointments }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Today's OPD</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-pills fs-5" style="color: #0284c7;"></i></div>
            <h4 class="fw-bold mb-0 text-dark">৳ {{ number_format($today_pharmacy_sales, 0) }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Pharmacy Sales</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-microscope fs-5" style="color: var(--erp-primary) !important;"></i></div>
            <h4 class="fw-bold mb-0 text-dark">{{ $total_lab_orders }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Lab Orders</small>
        </div>
    </div>
    <div class="col-6 col-lg-2">
        <div class="erp-card p-3 text-center mb-0 h-100">
            <div class="text-muted mb-1"><i class="fa-solid fa-user-tie fs-5 text-secondary"></i></div>
            <h4 class="fw-bold mb-0 text-dark">{{ $total_staff }}</h4>
            <small class="text-muted" style="font-size: 0.74rem;">Hospital Staff</small>
        </div>
    </div>
</div>

<!-- Bed Occupancy Matrix & 7-Day Revenue Trend Chart -->
<div class="row g-4 mb-4">
    <!-- Wards Status Visualizer -->
    <div class="col-lg-6">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-hospital text-teal me-2" style="color: var(--erp-secondary);"></i>Ward & Cabin Occupancy</h6>
                <a href="{{ route('beds.matrix') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3">
                    Bed Matrix <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-card-body">
                @forelse($wards as $w)
                    @php
                        $rate = $w->total_beds_count > 0 ? round(($w->occupied_beds_count / $w->total_beds_count) * 100) : 0;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark" style="font-size: 0.88rem;">{{ $w->name }}</span>
                            <span class="erp-badge {{ $rate >= 80 ? 'erp-badge-danger' : ($rate >= 50 ? 'erp-badge-warning' : 'erp-badge-success') }}">
                                {{ $w->occupied_beds_count }} / {{ $w->total_beds_count }} Beds ({{ $rate }}%)
                            </span>
                        </div>
                        <div class="progress" style="height: 7px; border-radius: 4px; background-color: #E2E8F0;">
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
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-chart-line text-success me-2"></i>7-Day Hospital Revenue Trend</h6>
                <span class="erp-badge erp-badge-teal">Daily Financials</span>
            </div>
            <div class="erp-card-body">
                <div style="height: 220px; position: relative;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Active Admissions & Emergency Queue -->
<div class="row g-4 mb-4">
    <!-- Active IPD Admissions Table -->
    <div class="col-lg-7">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-bed-pulse text-primary me-2" style="color: var(--erp-primary);"></i>Current Inpatient Admissions</h6>
                <a href="{{ route('admissions.index') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="erp-table align-middle">
                    <thead>
                        <tr>
                            <th>Admission #</th>
                            <th>Patient</th>
                            <th>Ward / Bed</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_admissions as $adm)
                            <tr>
                                <td><span class="erp-badge-id">{{ $adm->admission_no }}</span></td>
                                <td>
                                    <strong>{{ $adm->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $adm->patient->patient_id ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="erp-badge erp-badge-teal">
                                        {{ $adm->ward->name ?? 'Ward' }}
                                    </span>
                                    <div class="fw-bold text-dark small mt-0.5">
                                        {{ $adm->bed->bed_number ?? 'Bed N/A' }}
                                    </div>
                                </td>
                                <td><small class="text-secondary">{{ $adm->doctor->name ?? 'Unassigned' }}</small></td>
                                <td><small class="text-muted">{{ $adm->admission_date ? $adm->admission_date->format('M d, Y') : '' }}</small></td>
                                <td class="text-center">
                                    <a href="{{ route('admissions.show', $adm->id) }}" class="erp-action-btn" title="View Inpatient Record">
                                        <i class="fa-solid fa-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No active inpatients in hospital at this time.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Emergency Queue -->
    <div class="col-lg-5">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-truck-medical text-danger me-2"></i>Emergency Triage Queue</h6>
                <a href="{{ route('emergency.index') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3 text-danger border-danger">ER Board</a>
            </div>
            <div class="table-responsive">
                <table class="erp-table align-middle">
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
                                    'red' => 'erp-badge-danger',
                                    'orange' => 'erp-badge-warning',
                                    'yellow' => 'erp-badge-info',
                                    'green' => 'erp-badge-success',
                                    default => 'erp-badge-teal'
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span class="erp-badge {{ $badgeClass }} text-uppercase">
                                        {{ $emg->triage_priority }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $emg->patient->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $emg->case_no }}</small>
                                </td>
                                <td><small>{{ $emg->doctor->name ?? 'On Call' }}</small></td>
                                <td>
                                    <span class="erp-badge erp-badge-teal">
                                        {{ str_replace('_', ' ', $emg->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No emergency cases in queue.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- OPD Appointments & Recently Registered Patients -->
<div class="row g-4 mb-4">
    <!-- Today's OPD Appointments -->
    <div class="col-lg-6">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-calendar-check text-warning me-2"></i>Today's OPD Appointments</h6>
                <a href="{{ route('appointments.index') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3">Manage</a>
            </div>
            <div class="table-responsive">
                <table class="erp-table align-middle">
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
                                <td><small class="erp-badge erp-badge-teal">{{ $apt->time ?? 'Queue' }}</small></td>
                                <td>
                                    <span class="erp-badge {{ $apt->status == 'Completed' ? 'erp-badge-success' : 'erp-badge-warning' }}">
                                        {{ $apt->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No appointments scheduled for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recently Registered Patients -->
    <div class="col-lg-6">
        <div class="erp-card h-100 mb-0">
            <div class="erp-card-header">
                <h6 class="card-title"><i class="fa-solid fa-users text-primary me-2" style="color: var(--erp-primary);"></i>Recently Registered Patients</h6>
                <a href="{{ route('patients.index') }}" class="btn btn-erp-outline btn-sm rounded-pill py-1 px-3">View Registry</a>
            </div>
            <div class="table-responsive">
                <table class="erp-table align-middle">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Blood Group</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_patients as $p)
                            <tr>
                                <td><span class="erp-badge-id">{{ $p->patient_id }}</span></td>
                                <td><strong>{{ $p->name }}</strong></td>
                                <td><small class="text-muted">{{ $p->mobile }}</small></td>
                                <td>
                                    <span class="erp-badge erp-badge-danger fw-bold">{{ $p->blood_group ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('patients.show', $p->id) }}" class="erp-action-btn" title="View Patient Profile">
                                        <i class="fa-solid fa-id-card text-teal" style="color: var(--erp-secondary);"></i>
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
                        borderColor: '#0D9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.12)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#142D4E',
                        pointBorderColor: '#0D9488',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#142D4E',
                            titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 13 },
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '৳ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#E2E8F0', borderDash: [4, 4] },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
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
