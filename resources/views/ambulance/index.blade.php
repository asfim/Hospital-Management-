@extends('layouts.admin')

@section('title', 'Ambulance Emergency Dispatch')

@push('styles')
<style>
/* ====================================================================
   AMBULANCE FLEET & DISPATCH LUXURY DESIGN SYSTEM
   ==================================================================== */
.ambulance-page-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2), 0 4px 10px -2px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}

.ambulance-page-header::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -40px;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, rgba(14, 165, 233, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.ambulance-page-header::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: 20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(225, 29, 72, 0.18) 0%, rgba(225, 29, 72, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.ambulance-header-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: rgba(14, 165, 233, 0.2);
    border: 1px solid rgba(14, 165, 233, 0.4);
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #7dd3fc;
    margin-bottom: 0.5rem;
}

.ambulance-page-header h3 {
    color: #ffffff !important;
    font-weight: 800;
    font-size: 1.6rem;
    letter-spacing: -0.5px;
    margin-bottom: 0.25rem;
}

.ambulance-page-header p {
    color: #cbd5e1 !important;
    font-size: 0.88rem;
    margin-bottom: 0;
}

/* KPI Fleet Metric Cards */
.ambulance-kpi-card {
    position: relative;
    border-radius: 16px;
    padding: 1.25rem 1.4rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.ambulance-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.ambulance-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.08), 0 4px 8px -2px rgba(0, 0, 0, 0.03);
}

/* Specific Variant Styles */
.kpi-total-fleet {
    background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);
    border-color: #bae6fd;
}
.kpi-total-fleet::before {
    background: linear-gradient(90deg, #0284c7, #0369a1);
}
.kpi-total-fleet .kpi-icon-bubble {
    background: #e0f2fe;
    color: #0284c7;
}
.kpi-total-fleet .kpi-num {
    color: #0369a1;
}

.kpi-standby {
    background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    border-color: #bbf7d0;
}
.kpi-standby::before {
    background: linear-gradient(90deg, #10b981, #059669);
}
.kpi-standby .kpi-icon-bubble {
    background: #dcfce7;
    color: #059669;
}
.kpi-standby .kpi-num {
    color: #065f46;
}

.kpi-on-duty {
    background: linear-gradient(180deg, #ffffff 0%, #fffbeb 100%);
    border-color: #fde68a;
}
.kpi-on-duty::before {
    background: linear-gradient(90deg, #f59e0b, #d97706);
}
.kpi-on-duty .kpi-icon-bubble {
    background: #fef3c7;
    color: #d97706;
}
.kpi-on-duty .kpi-num {
    color: #854d0e;
}

.kpi-maintenance {
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    border-color: #cbd5e1;
}
.kpi-maintenance::before {
    background: linear-gradient(90deg, #64748b, #475569);
}
.kpi-maintenance .kpi-icon-bubble {
    background: #f1f5f9;
    color: #475569;
}
.kpi-maintenance .kpi-num {
    color: #334155;
}

.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.kpi-title {
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin: 0;
}

.kpi-icon-bubble {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: transform 0.25s ease;
}

.ambulance-kpi-card:hover .kpi-icon-bubble {
    transform: scale(1.1) rotate(4deg);
}

.kpi-num {
    font-size: 2.1rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.5px;
    margin-bottom: 6px;
}

.kpi-meta {
    font-size: 0.74rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}

.status-pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25);
    display: inline-block;
}

/* Modern Card Styling */
.ambulance-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    overflow: hidden;
    margin-bottom: 1.75rem;
}

.ambulance-card-header {
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
    padding: 1.1rem 1.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.ambulance-card-header .card-title {
    font-size: 0.98rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Modern Tables */
.table-ambulance th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-ambulance td {
    padding: 14px 16px;
    font-size: 0.88rem;
    border-bottom: 1px solid #f1f5f9;
}

.table-ambulance tbody tr:hover {
    background: #f8fafc;
}

/* Vehicle Type Badges */
.badge-type-icu {
    background: #ffe4e6;
    color: #be123c;
    border: 1px solid #fecdd3;
}
.badge-type-basic {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
}
.badge-type-neonatal {
    background: #fdf4ff;
    color: #a21caf;
    border: 1px solid #f5d0fe;
}
.badge-type-freezer {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
}
</style>
@endpush

@section('content')

<!-- ====================================================================
     PREMIUM HEADER & QUICK DISPATCH ACTION BAR
     ==================================================================== -->
<div class="ambulance-page-header">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="ambulance-header-badge">
                <i class="fa-solid fa-truck-medical"></i> 24/7 Rapid Emergency Response Fleet
            </div>
            <h3>Hospital Ambulance Fleet & Dispatch</h3>
            <p>Real-time emergency vehicle fleet monitoring, driver rosters, and rapid dispatch logistics</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="btn btn-outline-light px-3 py-2 fw-semibold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newVehicleModal">
                <i class="fa-solid fa-plus me-1 text-info"></i> Add Vehicle
            </button>
            <button type="button" class="btn btn-danger px-4 py-2 fw-bold rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#dispatchModal" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                <i class="fa-solid fa-bell me-1"></i> Dispatch Ambulance
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ====================================================================
     4 FLEET KPI STATUS METRIC CARDS
     ==================================================================== -->
<div class="row g-3 mb-4">
    <!-- 1. Total Fleet -->
    <div class="col-xl-3 col-sm-6">
        <div class="ambulance-kpi-card kpi-total-fleet">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Total Ambulance Fleet</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                </div>
                <div class="kpi-num">{{ $totalVehicles }}</div>
            </div>
            <div class="kpi-meta">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill">
                    <i class="fa-solid fa-van-shuttle me-1"></i>Registered Units
                </span>
            </div>
        </div>
    </div>

    <!-- 2. Available Standby -->
    <div class="col-xl-3 col-sm-6">
        <div class="ambulance-kpi-card kpi-standby">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Available on Standby</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="kpi-num">{{ $availableVehicles }}</div>
            </div>
            <div class="kpi-meta">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-semibold">
                    <span class="status-pulse-dot me-1"></span> Ready for Dispatch
                </span>
            </div>
        </div>
    </div>

    <!-- 3. On Duty / Dispatched -->
    <div class="col-xl-3 col-sm-6">
        <div class="ambulance-kpi-card kpi-on-duty">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">On Duty / Dispatched</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-route"></i>
                    </div>
                </div>
                <div class="kpi-num">{{ $onDutyVehicles }}</div>
            </div>
            <div class="kpi-meta">
                @if($onDutyVehicles > 0)
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill fw-semibold">
                        <i class="fa-solid fa-spinner fa-spin me-1"></i> In Transit
                    </span>
                @else
                    <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill">
                        0 Active In Transit
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Under Maintenance -->
    @php
        $maintenanceCount = $totalVehicles - $availableVehicles - $onDutyVehicles;
    @endphp
    <div class="col-xl-3 col-sm-6">
        <div class="ambulance-kpi-card kpi-maintenance">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Under Maintenance</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                </div>
                <div class="kpi-num">{{ $maintenanceCount }}</div>
            </div>
            <div class="kpi-meta">
                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill">
                    <i class="fa-solid fa-screwdriver-wrench me-1"></i> Garage / Service
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================
     ACTIVE FLEET VEHICLES DIRECTORY
     ==================================================================== -->
<div class="ambulance-card">
    <div class="ambulance-card-header">
        <div>
            <h6 class="card-title">
                <i class="fa-solid fa-van-shuttle text-primary"></i> Active Hospital Fleet Inventory
            </h6>
            <small class="text-muted">Registered hospital emergency vehicles, drivers, and readiness state</small>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary rounded-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#newVehicleModal">
            <i class="fa-solid fa-plus me-1"></i> Add Vehicle
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive m-0">
            <table class="table table-ambulance align-middle mb-0">
                <thead>
                    <tr>
                        <th>Vehicle #</th>
                        <th>Model & Classification</th>
                        <th>Assigned Driver</th>
                        <th>Fare Rates</th>
                        <th>Current Status</th>
                        <th class="text-end">Manage Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $veh)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-3 fw-bold">
                                        <i class="fa-solid fa-truck-medical me-1"></i>{{ $veh->vehicle_number }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $veh->vehicle_model ?? 'Toyota HiAce Ambulance' }}</div>
                                @php
                                    $typeBadgeClass = 'badge-type-basic';
                                    if(str_contains(strtolower($veh->type), 'icu') || str_contains(strtolower($veh->type), 'cardiac')) {
                                        $typeBadgeClass = 'badge-type-icu';
                                    } elseif(str_contains(strtolower($veh->type), 'neonatal')) {
                                        $typeBadgeClass = 'badge-type-neonatal';
                                    } elseif(str_contains(strtolower($veh->type), 'freezer')) {
                                        $typeBadgeClass = 'badge-type-freezer';
                                    }
                                @endphp
                                <span class="badge {{ $typeBadgeClass }} px-2 py-1 rounded-pill small mt-1">
                                    <i class="fa-solid fa-circle-info me-1"></i>{{ $veh->type }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $veh->driver_name }}</div>
                                <div class="small text-muted"><i class="fa-solid fa-phone me-1 text-success"></i>{{ $veh->driver_phone }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">Base: ৳{{ number_format($veh->standard_fare, 2) }}</div>
                                <div class="small text-muted">+৳{{ number_format($veh->per_km_rate ?? 0, 2) }} / km</div>
                            </td>
                            <td>
                                @if($veh->status == 'available')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                        <span class="status-pulse-dot me-1"></span>Available
                                    </span>
                                @elseif($veh->status == 'on_duty')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                                        <i class="fa-solid fa-spinner fa-spin me-1"></i>On Duty
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill">
                                        <i class="fa-solid fa-wrench me-1"></i>Maintenance
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('ambulance.update-vehicle-status', $veh->id) }}" method="POST" class="d-inline-flex gap-1 justify-content-end">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm rounded-3 shadow-none border-secondary-subtle" onchange="this.form.submit()" style="width: 145px;">
                                        <option value="available" {{ $veh->status == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="on_duty" {{ $veh->status == 'on_duty' ? 'selected' : '' }}>On Duty</option>
                                        <option value="maintenance" {{ $veh->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state text-center py-3">
                                    <i class="fa-solid fa-truck-medical text-primary opacity-25 display-4 mb-3 d-block"></i>
                                    <h6 class="fw-bold text-secondary mb-1">No Ambulances Registered</h6>
                                    <p class="text-muted small mb-3">Add hospital ambulance vehicles to start fleet dispatch.</p>
                                    <button type="button" class="btn btn-sm btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#newVehicleModal">
                                        <i class="fa-solid fa-plus me-1"></i> Register First Ambulance
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================
     AMBULANCE DISPATCH & TRIP LOGS
     ==================================================================== -->
<div class="ambulance-card">
    <div class="ambulance-card-header">
        <div>
            <h6 class="card-title">
                <i class="fa-solid fa-clock-rotate-left text-danger"></i> Ambulance Trip & Emergency Dispatch Logs
            </h6>
            <small class="text-muted">Emergency calls, transit tracking, patient destinations, and trip billing</small>
        </div>
        <form action="{{ route('ambulance.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <select name="status" class="form-select form-select-sm rounded-3 shadow-none border-secondary-subtle" onchange="this.form.submit()" style="min-width: 150px;">
                <option value="all">All Trips</option>
                <option value="dispatched" {{ $statusFilter == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $statusFilter == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @if($statusFilter && $statusFilter != 'all')
                <a href="{{ route('ambulance.index') }}" class="btn btn-sm btn-outline-secondary rounded-3" title="Clear Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive m-0">
            <table class="table table-ambulance align-middle mb-0">
                <thead>
                    <tr>
                        <th>Trip #</th>
                        <th>Caller / Patient</th>
                        <th>Route & Distance</th>
                        <th>Vehicle & Driver</th>
                        <th>Trip Fare & Payment</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-3 fw-bold">
                                    <i class="fa-solid fa-ticket me-1"></i>{{ $req->request_no }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $req->contact_name }}</div>
                                <div class="small text-muted"><i class="fa-solid fa-phone me-1 text-success"></i>{{ $req->contact_phone }}</div>
                                @if($req->patient)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill small mt-1">
                                        <i class="fa-solid fa-user me-1"></i>{{ $req->patient->name }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark mb-1">
                                    <i class="fa-solid fa-location-dot text-success me-1"></i>{{ $req->pickup_location }}
                                </div>
                                <div class="small text-muted">
                                    <i class="fa-solid fa-location-crosshairs text-danger me-1"></i>{{ $req->destination }}
                                </div>
                                @if($req->distance_km)
                                    <span class="badge bg-light text-secondary border px-2 py-0 mt-1 small" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-route me-1"></i>{{ $req->distance_km }} km approx.
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($req->vehicle)
                                    <div class="fw-semibold text-dark">{{ $req->vehicle->vehicle_number }}</div>
                                    <div class="small text-muted">{{ $req->vehicle->driver_name }} ({{ $req->vehicle->driver_phone }})</div>
                                @else
                                    <span class="badge bg-light text-muted border">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">৳{{ number_format($req->fare_amount, 2) }}</div>
                                @if($req->paid_amount >= $req->fare_amount)
                                    <span class="badge bg-success-subtle text-success px-2 py-0" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-circle-check me-1"></i>Paid: ৳{{ number_format($req->paid_amount, 2) }}
                                    </span>
                                @elseif($req->paid_amount > 0)
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-0" style="font-size: 0.72rem;">
                                        Partial: ৳{{ number_format($req->paid_amount, 2) }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-2 py-0" style="font-size: 0.72rem;">
                                        Unpaid Due
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($req->status == 'dispatched')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                                        <i class="fa-solid fa-truck-fast me-1"></i>Dispatched
                                    </span>
                                @elseif($req->status == 'completed')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                        <i class="fa-solid fa-check me-1"></i>Completed
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                                        <i class="fa-solid fa-xmark me-1"></i>Cancelled
                                    </span>
                                @endif
                                <div class="small text-muted mt-1">{{ \Carbon\Carbon::parse($req->requested_at)->format('d M, h:i A') }}</div>
                            </td>
                            <td class="text-end">
                                @if($req->status == 'dispatched')
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-3 px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#completeTripModal{{ $req->id }}">
                                        <i class="fa-solid fa-check me-1"></i> Complete
                                    </button>

                                    <!-- Complete Modal -->
                                    <div class="modal fade" id="completeTripModal{{ $req->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('ambulance.update-request-status', $req->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <div class="modal-content text-start border-0 shadow-lg rounded-4 overflow-hidden">
                                                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                                                        <h5 class="modal-title fs-6 fw-bold">
                                                            <i class="fa-solid fa-circle-check me-2"></i>Complete Ambulance Trip #{{ $req->request_no }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="p-3 rounded-3 mb-3" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="fw-bold text-success">Trip Fare</span>
                                                                <span class="fs-5 fw-bold text-dark">৳{{ number_format($req->fare_amount, 2) }}</span>
                                                            </div>
                                                            <div class="small text-muted mt-1">Route: {{ $req->pickup_location }} &rarr; {{ $req->destination }}</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold text-dark">Collected Fare Amount (BDT ৳) <span class="text-danger">*</span></label>
                                                            <input type="number" step="0.01" name="paid_amount" class="form-control rounded-3" value="{{ $req->fare_amount }}" required>
                                                        </div>
                                                        <div class="alert alert-info small mb-0 rounded-3 border-0" style="background: #f0f9ff; color: #0369a1;">
                                                            <i class="fa-solid fa-info-circle me-1"></i> Completing this trip will release the ambulance back to the available standby fleet.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light border-0 py-3">
                                                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                                                            <i class="fa-solid fa-check me-1"></i> Complete Trip
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted border">Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state text-center py-3">
                                    <i class="fa-solid fa-route text-muted opacity-25 display-4 mb-3 d-block"></i>
                                    <h6 class="fw-bold text-secondary mb-1">No Ambulance Trip Logs Found</h6>
                                    <p class="text-muted small mb-3">No trips have been dispatched under the selected filter.</p>
                                    <button type="button" class="btn btn-sm btn-danger rounded-3" data-bs-toggle="modal" data-bs-target="#dispatchModal" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                                        <i class="fa-solid fa-bell me-1"></i> Dispatch First Ambulance
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($requests->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $requests->links() }}
        </div>
    @endif
</div>

<!-- ====================================================================
     MODAL: REGISTER AMBULANCE VEHICLE
     ==================================================================== -->
<div class="modal fade" id="newVehicleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('ambulance.store-vehicle') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #0284c7, #0369a1);">
                    <h5 class="modal-title fs-6 fw-bold">
                        <i class="fa-solid fa-truck-medical me-2"></i>Register Ambulance Vehicle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vehicle Plate No. <span class="text-danger">*</span></label>
                            <input type="text" name="vehicle_number" class="form-control rounded-3" required placeholder="e.g. DHA-CHA-11-2034">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Model / Make</label>
                            <input type="text" name="vehicle_model" class="form-control rounded-3" placeholder="e.g. Toyota HiAce Grand Cabin">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ambulance Classification <span class="text-danger">*</span></label>
                            <select name="type" class="form-select rounded-3" required>
                                <option value="Basic">Basic Life Support (BLS with AC)</option>
                                <option value="ICU / Cardiac Support">Advanced Life Support (ICU / Ventilator & Monitor)</option>
                                <option value="Neonatal">NICU / Neonatal Transport Incubator</option>
                                <option value="Freezer">Mortuary / Freezer Ambulance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Assigned Driver Name <span class="text-danger">*</span></label>
                            <input type="text" name="driver_name" class="form-control rounded-3" required placeholder="e.g. Md. Rafiqul Islam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Driver Mobile No. <span class="text-danger">*</span></label>
                            <input type="text" name="driver_phone" class="form-control rounded-3" required placeholder="017XXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Standard Base Fare (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="standard_fare" class="form-control rounded-3" value="2000.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Per KM Rate (৳)</label>
                            <input type="number" step="0.01" name="per_km_rate" class="form-control rounded-3" value="50.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #0284c7, #0369a1); border: none;">
                        <i class="fa-solid fa-save me-1"></i> Save Vehicle
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ====================================================================
     MODAL: DISPATCH AMBULANCE
     ==================================================================== -->
<div class="modal fade" id="dispatchModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('ambulance.store-request') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #e11d48, #be123c);">
                    <h5 class="modal-title fs-6 fw-bold">
                        <i class="fa-solid fa-bell me-2"></i>Dispatch Emergency Ambulance
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Select Standby Ambulance <span class="text-danger">*</span></label>
                            <select name="ambulance_vehicle_id" class="form-select rounded-3" required>
                                <option value="">-- Choose Available Vehicle --</option>
                                @foreach($vehicles->where('status', 'available') as $av)
                                    <option value="{{ $av->id }}">{{ $av->vehicle_number }} ({{ $av->type }}) • Driver: {{ $av->driver_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Linked Patient (Optional)</label>
                            <select name="patient_id" class="form-select rounded-3">
                                <option value="">-- Non-Registered / External Emergency Caller --</option>
                                @foreach($patients as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->mobile ?? $pt->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Caller / Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_name" class="form-control rounded-3" required placeholder="e.g. Asif Mahmud">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Contact Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control rounded-3" required placeholder="01XXXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Pickup Location <span class="text-danger">*</span></label>
                            <input type="text" name="pickup_location" class="form-control rounded-3" required placeholder="e.g. House 12, Road 5, Dhanmondi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Destination Hospital / Gate <span class="text-danger">*</span></label>
                            <input type="text" name="destination" class="form-control rounded-3" required placeholder="e.g. Dhaka Central Hospital ER Gate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Est. Distance (km)</label>
                            <input type="number" step="0.1" name="distance_km" class="form-control rounded-3" placeholder="e.g. 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Total Trip Fare (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="fare_amount" class="form-control rounded-3" required value="2500.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Advance Payment Received (৳)</label>
                            <input type="number" step="0.01" name="paid_amount" class="form-control rounded-3" value="0.00">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Clinical & Trip Notes</label>
                            <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="e.g. Patient requires high-flow oxygen, cardiac monitor and suction standby"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Confirm Dispatch
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
