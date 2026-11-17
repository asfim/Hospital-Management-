@extends('layouts.admin')

@section('title', 'Ambulance Emergency Dispatch')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-truck-medical me-2 text-primary"></i>Hospital Ambulance Fleet & Dispatch</h4>
        <p class="text-muted mb-0">Emergency vehicle fleet management, GPS dispatch, driver roster and trip billing</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newVehicleModal">
            <i class="fa-solid fa-plus me-1"></i> Add Vehicle
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dispatchModal">
            <i class="fa-solid fa-bell me-1"></i> Dispatch Ambulance
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Fleet Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">TOTAL FLEET</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ $totalVehicles }}</div>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                    <i class="fa-solid fa-truck-medical fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">AVAILABLE ON STANDBY</div>
                    <div class="h3 fw-bold mb-0 text-success">{{ $availableVehicles }}</div>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                    <i class="fa-solid fa-circle-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">ON DUTY / DISPATCHED</div>
                    <div class="h3 fw-bold mb-0 text-warning">{{ $onDutyVehicles }}</div>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                    <i class="fa-solid fa-route fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">UNDER MAINTENANCE</div>
                    <div class="h3 fw-bold mb-0 text-secondary">{{ $totalVehicles - $availableVehicles - $onDutyVehicles }}</div>
                </div>
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-3">
                    <i class="fa-solid fa-wrench fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fleet Vehicle List -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="card-title mb-0 fw-bold text-dark">
            <i class="fa-solid fa-van-shuttle me-2 text-primary"></i>Active Hospital Fleet
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th>Vehicle No.</th>
                        <th>Model & Type</th>
                        <th>Assigned Driver</th>
                        <th>Standard / Km Rate</th>
                        <th>Current Status</th>
                        <th class="text-end">Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $veh)
                        <tr>
                            <td class="fw-bold text-primary">
                                <i class="fa-solid fa-truck-medical me-1"></i>{{ $veh->vehicle_number }}
                            </td>
                            <td>
                                <div class="fw-medium">{{ $veh->vehicle_model ?? 'Toyota Hiace' }}</div>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $veh->type }}</span>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $veh->driver_name }}</div>
                                <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $veh->driver_phone }}</div>
                            </td>
                            <td>
                                <div>Base: ৳{{ number_format($veh->standard_fare, 2) }}</div>
                                <div class="small text-muted">+৳{{ number_format($veh->per_km_rate, 2) }} / km</div>
                            </td>
                            <td>
                                @if($veh->status == 'available')
                                    <span class="badge bg-success"><i class="fa-solid fa-circle-dot me-1"></i>Available</span>
                                @elseif($veh->status == 'on_duty')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i>On Duty</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fa-solid fa-wrench me-1"></i>Maintenance</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('ambulance.update-vehicle-status', $veh->id) }}" method="POST" class="d-inline-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 140px;">
                                        <option value="available" {{ $veh->status == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="on_duty" {{ $veh->status == 'on_duty' ? 'selected' : '' }}>On Duty</option>
                                        <option value="maintenance" {{ $veh->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No ambulances registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Dispatch Trips Log -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0 fw-bold text-dark">
            <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Ambulance Trip & Dispatch Logs
        </h6>
        <form action="{{ route('ambulance.index') }}" method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="all">All Trips</option>
                <option value="dispatched" {{ $statusFilter == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $statusFilter == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th>Trip #</th>
                        <th>Patient / Caller</th>
                        <th>Route</th>
                        <th>Ambulance & Driver</th>
                        <th>Fare / Billing</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td class="fw-bold text-dark">{{ $req->request_no }}</td>
                            <td>
                                <div class="fw-medium">{{ $req->contact_name }}</div>
                                <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $req->contact_phone }}</div>
                                @if($req->patient)
                                    <span class="badge bg-light text-primary border">Patient: {{ $req->patient->name }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="small"><i class="fa-solid fa-location-dot text-success me-1"></i>From: {{ $req->pickup_location }}</div>
                                <div class="small"><i class="fa-solid fa-location-crosshairs text-danger me-1"></i>To: {{ $req->destination }}</div>
                                @if($req->distance_km)
                                    <div class="text-muted small mt-1">{{ $req->distance_km }} km approx.</div>
                                @endif
                            </td>
                            <td>
                                @if($req->vehicle)
                                    <div class="fw-medium">{{ $req->vehicle->vehicle_number }}</div>
                                    <div class="small text-muted">{{ $req->vehicle->driver_name }} ({{ $req->vehicle->driver_phone }})</div>
                                @else
                                    <span class="text-muted">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">৳{{ number_format($req->fare_amount, 2) }}</div>
                                <div class="small {{ $req->paid_amount >= $req->fare_amount ? 'text-success' : 'text-danger' }}">
                                    Paid: ৳{{ number_format($req->paid_amount, 2) }}
                                </div>
                            </td>
                            <td>
                                @if($req->status == 'dispatched')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-truck me-1"></i>Dispatched</span>
                                @elseif($req->status == 'completed')
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                                <div class="small text-muted mt-1">{{ \Carbon\Carbon::parse($req->requested_at)->format('d M, h:i A') }}</div>
                            </td>
                            <td class="text-end">
                                @if($req->status == 'dispatched')
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#completeTripModal{{ $req->id }}">
                                        <i class="fa-solid fa-check me-1"></i> Complete
                                    </button>

                                    <!-- Complete Modal -->
                                    <div class="modal fade" id="completeTripModal{{ $req->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('ambulance.update-request-status', $req->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Complete Trip #{{ $req->request_no }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Collected Fare (BDT ৳)</label>
                                                            <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ $req->fare_amount }}">
                                                        </div>
                                                        <p class="small text-muted mb-0">Completing this trip will release the ambulance back to the available standby fleet.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Complete Trip</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small">Done</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No ambulance dispatch logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($requests->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $requests->links() }}
        </div>
    @endif
</div>

<!-- Modal: New Vehicle -->
<div class="modal fade" id="newVehicleModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('ambulance.store-vehicle') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-truck-medical me-2 text-primary"></i>Register Ambulance Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vehicle Number <span class="text-danger">*</span></label>
                            <input type="text" name="vehicle_number" class="form-control" required placeholder="e.g. DHAKA-METRO-CHA-11-2034">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Model / Make</label>
                            <input type="text" name="vehicle_model" class="form-control" placeholder="e.g. Toyota Hiace Grand Cabin">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ambulance Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="Basic">Basic Life Support (AC)</option>
                                <option value="ICU / Cardiac Support">ICU / Cardiac Support (Ventilator & Monitor)</option>
                                <option value="Neonatal">NICU / Neonatal Transport</option>
                                <option value="Freezer">Freezer Ambulance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Assigned Driver Name <span class="text-danger">*</span></label>
                            <input type="text" name="driver_name" class="form-control" required placeholder="e.g. Md. Rafiqul Islam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Driver Mobile Phone <span class="text-danger">*</span></label>
                            <input type="text" name="driver_phone" class="form-control" required placeholder="017XXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Standard Base Fare (৳)</label>
                            <input type="number" step="0.01" name="standard_fare" class="form-control" value="2000.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Per KM Rate (৳)</label>
                            <input type="number" step="0.01" name="per_km_rate" class="form-control" value="50.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Vehicle</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Dispatch Ambulance -->
<div class="modal fade" id="dispatchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('ambulance.store-request') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-bell me-2 text-danger"></i>Dispatch Emergency Ambulance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Available Vehicle <span class="text-danger">*</span></label>
                            <select name="ambulance_vehicle_id" class="form-select" required>
                                <option value="">-- Choose Available Vehicle --</option>
                                @foreach($vehicles->where('status', 'available') as $av)
                                    <option value="{{ $av->id }}">{{ $av->vehicle_number }} ({{ $av->type }}) - Driver: {{ $av->driver_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Associated Patient (Optional)</label>
                            <select name="patient_id" class="form-select">
                                <option value="">-- Non-Registered / External Caller --</option>
                                @foreach($patients as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Caller / Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_name" class="form-control" required placeholder="e.g. Asif Mahmud">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contact Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control" required placeholder="01XXXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pickup Location <span class="text-danger">*</span></label>
                            <input type="text" name="pickup_location" class="form-control" required placeholder="e.g. Dhanmondi 27, Dhaka">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Destination / Drop Location <span class="text-danger">*</span></label>
                            <input type="text" name="destination" class="form-control" required placeholder="e.g. Main Hospital ER Gate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Est. Distance (km)</label>
                            <input type="number" step="0.1" name="distance_km" class="form-control" placeholder="e.g. 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Total Fare Amount (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="fare_amount" class="form-control" required value="2500.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Advance / Paid Amount (৳)</label>
                            <input type="number" step="0.01" name="paid_amount" class="form-control" value="0.00">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Trip / Medical Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Patient requires oxygen support, cardiac monitor standby"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Dispatch</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
