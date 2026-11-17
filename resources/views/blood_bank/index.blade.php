@extends('layouts.admin')

@section('title', 'Blood Bank & Transfusion Service')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-droplet me-2 text-danger"></i>Hospital Blood Bank</h4>
        <p class="text-muted mb-0">Blood unit inventory, voluntary donors, screening and transfusion management</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#newDonorModal">
            <i class="fa-solid fa-user-plus me-1"></i> Register Donor
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addBagModal">
            <i class="fa-solid fa-plus-circle me-1"></i> Add Blood Unit
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Blood Inventory Counters -->
<div class="row g-3 mb-4">
    @foreach($groupCounts as $grp => $cnt)
        <div class="col-6 col-md-3 col-xl-custom" style="flex: 1 0 12%;">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3 h-100 {{ $cnt > 0 ? 'bg-danger text-white' : 'bg-light text-muted border' }}">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-4 fw-bolder">{{ $grp }}</span>
                    <i class="fa-solid fa-droplet {{ $cnt > 0 ? 'opacity-75' : 'text-secondary opacity-50' }}"></i>
                </div>
                <div class="display-6 fw-bold">{{ $cnt }}</div>
                <div class="small {{ $cnt > 0 ? 'opacity-75' : 'text-muted' }}">Bags Available</div>
            </div>
        </div>
    @endforeach
</div>

<ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-3 shadow-sm border" id="bloodBankTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active px-4 py-2" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab">
            <i class="fa-solid fa-boxes-stacked me-1"></i> Blood Unit Inventory
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-2" id="donors-tab" data-bs-toggle="tab" data-bs-target="#donors" type="button" role="tab">
            <i class="fa-solid fa-users me-1"></i> Registered Donors
        </button>
    </li>
</ul>

<div class="tab-content" id="bloodBankTabsContent">
    <!-- Tab 1: Blood Unit Inventory -->
    <div class="tab-pane fade show active" id="inventory" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-box-archive me-2 text-danger"></i>Inventory Stock Units
                </h6>
                <form action="{{ route('blood-bank.index') }}" method="GET" class="d-flex gap-2">
                    <select name="blood_group" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Blood Groups</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                            <option value="{{ $bg }}" {{ $bloodGroupFilter == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="available" {{ $statusFilter == 'available' ? 'selected' : '' }}>Available Units</option>
                        <option value="issued" {{ $statusFilter == 'issued' ? 'selected' : '' }}>Issued Units</option>
                        <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Records</option>
                    </select>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Bag / Unit #</th>
                                <th>Blood Group</th>
                                <th>Component</th>
                                <th>Donor Source</th>
                                <th>Collection Date</th>
                                <th>Expiry Date</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bags as $bag)
                                <tr>
                                    <td class="fw-bold text-danger">
                                        <i class="fa-solid fa-barcode me-1"></i>{{ $bag->bag_number }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger fs-6 px-2 py-1">{{ $bag->blood_group }}</span>
                                    </td>
                                    <td>{{ $bag->component_type }}</td>
                                    <td>
                                        @if($bag->donor)
                                            <div class="fw-medium">{{ $bag->donor->name }}</div>
                                            <div class="small text-muted">{{ $bag->donor->donor_code }}</div>
                                        @else
                                            <span class="text-muted fst-italic">External Bank</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($bag->collected_at)->format('d M, Y') }}</td>
                                    <td>
                                        <span class="{{ \Carbon\Carbon::parse($bag->expiry_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($bag->expiry_date)->format('d M, Y') }}
                                        </span>
                                    </td>
                                    <td>{{ $bag->storage_location ?? 'Blood Refrigerator 1' }}</td>
                                    <td>
                                        @if($bag->status == 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($bag->status == 'issued')
                                            <span class="badge bg-secondary">Issued</span>
                                            @if($bag->patient)
                                                <div class="small text-muted">to {{ $bag->patient->name }}</div>
                                            @endif
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($bag->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($bag->status == 'available')
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#issueBagModal{{ $bag->id }}">
                                                <i class="fa-solid fa-hand-holding-heart me-1"></i> Issue
                                            </button>

                                            <!-- Issue Bag Modal -->
                                            <div class="modal fade" id="issueBagModal{{ $bag->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('blood-bank.issue-bag', $bag->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-content text-start">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Issue Blood Unit #{{ $bag->bag_number }} ({{ $bag->blood_group }})</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Recipient Patient <span class="text-danger">*</span></label>
                                                                    <select name="issued_to_patient_id" class="form-select" required>
                                                                        <option value="">-- Select Patient --</option>
                                                                        @foreach($patients as $patient)
                                                                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->phone }}) - {{ $patient->blood_group ?? 'Unknown BG' }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="alert alert-warning small mb-0">
                                                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Ensure pre-transfusion cross-matching is verified before administering.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Confirm Issue</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No blood units match the selected filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($bags->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $bags->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Registered Donors -->
    <div class="tab-pane fade" id="donors" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-users me-2 text-primary"></i>Blood Donors Directory
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Donor Code</th>
                                <th>Name & Contact</th>
                                <th>Blood Group</th>
                                <th>Age / Gender</th>
                                <th>Last Donated</th>
                                <th>Status</th>
                                <th>City / Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donors as $donor)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $donor->donor_code }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $donor->name }}</div>
                                        <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $donor->mobile }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger fs-6 px-2 py-1">{{ $donor->blood_group }}</span>
                                    </td>
                                    <td>{{ $donor->age ?? 'N/A' }} yrs / {{ $donor->gender }}</td>
                                    <td>
                                        {{ $donor->last_donated_at ? \Carbon\Carbon::parse($donor->last_donated_at)->format('d M, Y') : 'Never / First Time' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $donor->status }}</span>
                                    </td>
                                    <td class="small text-muted">{{ $donor->address ?? 'Dhaka' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No donors registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($donors->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $donors->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Register Donor -->
<div class="modal fade" id="newDonorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('blood-bank.store-donor') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-user-plus me-2 text-danger"></i>Register Voluntary Blood Donor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Donor Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g., Tanvir Hasan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Blood Group <span class="text-danger">*</span></label>
                            <select name="blood_group" class="form-select" required>
                                <option value="">Select</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Age (18-65)</label>
                            <input type="number" name="age" class="form-control" min="18" max="65" placeholder="e.g., 28">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mobile Phone <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control" required placeholder="017XXXXXXXX">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="donor@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Donation Date</label>
                            <input type="date" name="last_donated_at" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Residential Address</label>
                            <input type="text" name="address" class="form-control" placeholder="House, Road, Area, Dhaka">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Medical / Screening Notes</label>
                            <textarea name="medical_notes" class="form-control" rows="2" placeholder="Hemoglobin level, blood pressure, hepatitis/HIV screen results..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Register Donor</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Blood Unit -->
<div class="modal fade" id="addBagModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('blood-bank.store-bag') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-plus-circle me-2 text-danger"></i>Add Blood Unit to Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Blood Group <span class="text-danger">*</span></label>
                            <select name="blood_group" class="form-select" required>
                                <option value="">Select</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Component Type <span class="text-danger">*</span></label>
                            <select name="component_type" class="form-select" required>
                                <option value="Whole Blood">Whole Blood (450ml)</option>
                                <option value="Packed Red Cells (PRBC)">Packed Red Cells (PRBC)</option>
                                <option value="Fresh Frozen Plasma (FFP)">Fresh Frozen Plasma (FFP)</option>
                                <option value="Platelet Concentrate">Platelet Concentrate (PC)</option>
                                <option value="Cryoprecipitate">Cryoprecipitate</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Source Donor (Optional)</label>
                            <select name="donor_id" class="form-select">
                                <option value="">-- Voluntary / External Bank / Walk-in --</option>
                                @foreach($donors as $dn)
                                    <option value="{{ $dn->id }}">{{ $dn->name }} ({{ $dn->donor_code }}) - {{ $dn->blood_group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Collection Date <span class="text-danger">*</span></label>
                            <input type="date" name="collected_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ date('Y-m-d', strtotime('+35 days')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Storage Location</label>
                            <input type="text" name="storage_location" class="form-control" placeholder="e.g., Blood Refrigerator 1, Shelf B">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Blood Unit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
