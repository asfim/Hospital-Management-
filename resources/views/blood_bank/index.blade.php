@extends('layouts.admin')

@section('title', 'Blood Bank & Transfusion Service')

@push('styles')
<style>
/* ====================================================================
   BLOOD BANK LUXURY MEDICAL DESIGN SYSTEM
   ==================================================================== */
.blood-page-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.18), 0 4px 10px -2px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}

.blood-page-header::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -30px;
    width: 240px;
    height: 240px;
    background: radial-gradient(circle, rgba(225, 29, 72, 0.3) 0%, rgba(225, 29, 72, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.blood-page-header .header-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: rgba(225, 29, 72, 0.2);
    border: 1px solid rgba(225, 29, 72, 0.4);
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #fecdd3;
    margin-bottom: 0.5rem;
}

.blood-page-header h3 {
    color: #ffffff !important;
    font-weight: 800;
    font-size: 1.6rem;
    letter-spacing: -0.5px;
    margin-bottom: 0.25rem;
}

.blood-page-header p {
    color: #cbd5e1 !important;
    font-size: 0.88rem;
    margin-bottom: 0;
}

/* Quick KPI Badges in Header */
.header-kpi-pill {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.header-kpi-pill .kpi-num {
    font-size: 1.35rem;
    font-weight: 800;
    line-height: 1;
    color: #ffffff !important;
}
.header-kpi-pill .kpi-title {
    font-size: 0.72rem;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: #cbd5e1 !important;
}

/* 8-Column Blood Group Grid */
.blood-inventory-grid {
    display: grid;
    grid-template-columns: repeat(8, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 1.5rem;
}

@media (max-width: 991px) {
    .blood-inventory-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
}
@media (max-width: 576px) {
    .blood-inventory-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
}

/* Individual Blood Card */
.blood-card {
    position: relative;
    border-radius: 14px;
    padding: 12px 10px 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 128px;
    text-decoration: none;
    color: inherit;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
}

.blood-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3.5px;
    background: #e2e8f0;
    transition: background 0.25s;
}

/* Stock Available Styling */
.blood-card.has-stock {
    background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
    border-color: #fecdd3;
    box-shadow: 0 4px 14px -2px rgba(225, 29, 72, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
}

.blood-card.has-stock::before {
    background: linear-gradient(90deg, #e11d48, #be123c);
}

.blood-card.has-stock:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -4px rgba(225, 29, 72, 0.2), 0 4px 8px -2px rgba(0, 0, 0, 0.04);
    border-color: #fda4af;
}

/* Depleted Stock Styling */
.blood-card.empty-stock {
    background: #ffffff;
    border: 1px dashed #cbd5e1;
    opacity: 0.9;
}

.blood-card.empty-stock:hover {
    transform: translateY(-3px);
    opacity: 1;
    border-color: #94a3b8;
    box-shadow: 0 8px 18px -4px rgba(0, 0, 0, 0.08);
}

/* Active Selected Filter State */
.blood-card.active-filter {
    outline: 2.5px solid #e11d48;
    outline-offset: 2px;
    border-color: #e11d48 !important;
}

/* Card Top Elements */
.blood-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
}

.blood-group-badge {
    font-size: 1.05rem;
    font-weight: 800;
    letter-spacing: -0.3px;
    padding: 2px 8px;
    border-radius: 6px;
    line-height: 1.1;
    display: inline-flex;
    align-items: center;
}

.blood-card.has-stock .blood-group-badge {
    background: linear-gradient(135deg, #e11d48, #be123c);
    color: #ffffff;
    box-shadow: 0 2px 5px rgba(225, 29, 72, 0.3);
}

.blood-card.empty-stock .blood-group-badge {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.blood-drop-icon {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    transition: transform 0.25s ease;
}

.blood-card.has-stock .blood-drop-icon {
    background: #ffe4e6;
    color: #e11d48;
}

.blood-card.empty-stock .blood-drop-icon {
    background: #f8fafc;
    color: #94a3b8;
}

.blood-card:hover .blood-drop-icon {
    transform: scale(1.15) rotate(6deg);
}

/* Card Numbers */
.blood-card-body {
    text-align: center;
    padding: 2px 0 4px;
}

.blood-qty {
    font-size: 1.85rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.5px;
    margin-bottom: 2px;
}

.blood-card.has-stock .blood-qty {
    color: #9f1239;
}

.blood-card.empty-stock .blood-qty {
    color: #94a3b8;
}

.blood-sublabel {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #64748b;
}

/* Stock Footer Pills */
.blood-card-footer {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 4px;
}

.stock-tag {
    font-size: 0.64rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    line-height: 1;
}

.stock-tag.tag-in-stock {
    background: #dcfce7;
    color: #15803d;
}

.stock-tag.tag-in-stock .tag-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25);
    display: inline-block;
}

.stock-tag.tag-depleted {
    background: #f1f5f9;
    color: #64748b;
}

/* Active Pin */
.filter-active-pin {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #e11d48;
    color: #ffffff;
    font-size: 0.62rem;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(225, 29, 72, 0.4);
}

/* Modern Tab Pill Styling */
.blood-nav-pills {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 6px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    margin-bottom: 1.5rem;
}

.blood-nav-pills .nav-link {
    border-radius: 8px;
    font-weight: 600;
    color: #475569;
    padding: 9px 20px;
    font-size: 0.92rem;
    transition: all 0.2s ease;
}

.blood-nav-pills .nav-link.active {
    background: linear-gradient(135deg, #e11d48, #be123c);
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(225, 29, 72, 0.25);
}

/* Premium Filter Bar */
.filter-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

/* Table Enhancements */
.table-blood th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-blood td {
    padding: 14px 16px;
    font-size: 0.88rem;
    border-bottom: 1px solid #f1f5f9;
}

.table-blood tbody tr:hover {
    background: #f8fafc;
}
</style>
@endpush

@section('content')

<!-- ====================================================================
     PREMIUM HEADER & QUICK KPI STATS
     ==================================================================== -->
<div class="blood-page-header">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="header-badge">
                <i class="fa-solid fa-heart-pulse"></i> Blood Bank & Transfusion Center
            </div>
            <h3>Hospital Blood Bank Service</h3>
            <p>Real-time ABO/Rh inventory tracking, voluntary donor screening, and patient cross-matching</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="header-kpi-pill">
                <i class="fa-solid fa-boxes-stacked fs-4 text-danger"></i>
                <div>
                    <div class="kpi-num">{{ array_sum($groupCounts) }}</div>
                    <div class="kpi-title">Units Available</div>
                </div>
            </div>
            <div class="header-kpi-pill">
                <i class="fa-solid fa-users fs-4 text-info"></i>
                <div>
                    <div class="kpi-num">{{ $donors->total() }}</div>
                    <div class="kpi-title">Voluntary Donors</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-light px-3 py-2 fw-semibold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newDonorModal">
                    <i class="fa-solid fa-user-plus me-1 text-danger"></i> Register Donor
                </button>
                <button type="button" class="btn btn-danger px-3 py-2 fw-bold rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#addBagModal" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                    <i class="fa-solid fa-plus-circle me-1"></i> Add Blood Unit
                </button>
            </div>
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
     8-CARD INTERACTIVE BLOOD GROUP INVENTORY
     ==================================================================== -->
<div class="d-flex justify-content-between align-items-center mb-2 px-1">
    <div class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.6px;">
        <i class="fa-solid fa-chart-pie me-1 text-danger"></i> ABO & Rh Blood Group Stock
    </div>
    @if($bloodGroupFilter)
        <a href="{{ route('blood-bank.index', ['status' => $statusFilter]) }}" class="badge bg-danger-subtle text-danger text-decoration-none px-2 py-1 rounded-pill">
            <i class="fa-solid fa-xmark me-1"></i> Filter: {{ $bloodGroupFilter }} (Reset)
        </a>
    @else
        <span class="small text-muted"><i class="fa-solid fa-hand-pointer me-1"></i>Click card to filter inventory</span>
    @endif
</div>

<div class="blood-inventory-grid">
    @foreach($groupCounts as $grp => $cnt)
        @php
            $isActive = ($bloodGroupFilter === $grp);
            $hasStock = ($cnt > 0);
        @endphp
        <a href="{{ route('blood-bank.index', ['blood_group' => ($isActive ? '' : $grp), 'status' => $statusFilter]) }}" 
           class="blood-card {{ $hasStock ? 'has-stock' : 'empty-stock' }} {{ $isActive ? 'active-filter' : '' }}"
           title="{{ $hasStock ? $cnt . ' bags in stock. Click to filter' : 'Depleted. Click to filter' }}">
            
            <!-- Top Tag & Icon -->
            <div class="blood-card-top">
                <span class="blood-group-badge">{{ $grp }}</span>
                <div class="blood-drop-icon">
                    <i class="fa-solid fa-droplet"></i>
                </div>
            </div>

            <!-- Main Counter -->
            <div class="blood-card-body">
                <div class="blood-qty">{{ $cnt }}</div>
                <div class="blood-sublabel">Bags Available</div>
            </div>

            <!-- Footer Status Pill -->
            <div class="blood-card-footer">
                @if($hasStock)
                    <span class="stock-tag tag-in-stock">
                        <span class="tag-dot"></span> In Stock
                    </span>
                @else
                    <span class="stock-tag tag-depleted">
                        <i class="fa-solid fa-circle-xmark text-muted"></i> Depleted
                    </span>
                @endif
            </div>

            @if($isActive)
                <div class="filter-active-pin" title="Active Filter">
                    <i class="fa-solid fa-check"></i>
                </div>
            @endif
        </a>
    @endforeach
</div>

<!-- ====================================================================
     NAV PILLS TABS: INVENTORY vs DONORS
     ==================================================================== -->
<ul class="nav nav-pills blood-nav-pills gap-2" id="bloodBankTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab">
            <i class="fa-solid fa-boxes-stacked me-1"></i> Blood Unit Inventory 
            <span class="badge bg-light text-dark ms-1 rounded-pill">{{ $bags->total() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="donors-tab" data-bs-toggle="tab" data-bs-target="#donors" type="button" role="tab">
            <i class="fa-solid fa-users me-1"></i> Registered Donors
            <span class="badge bg-light text-dark ms-1 rounded-pill">{{ $donors->total() }}</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="bloodBankTabsContent">
    <!-- ================================================================
         TAB 1: BLOOD UNIT INVENTORY
         ================================================================ -->
    <div class="tab-pane fade show active" id="inventory" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="fa-solid fa-box-archive text-danger"></i> Inventory Stock Units
                    </h6>
                    <small class="text-muted">Showing {{ $bags->count() }} of {{ $bags->total() }} recorded units</small>
                </div>
                <form action="{{ route('blood-bank.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <select name="blood_group" class="form-select form-select-sm rounded-3 shadow-none border-secondary-subtle" onchange="this.form.submit()">
                        <option value="">All Blood Groups</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                            <option value="{{ $bg }}" {{ $bloodGroupFilter == $bg ? 'selected' : '' }}>{{ $bg }} Group</option>
                        @endforeach
                    </select>
                    <select name="status" class="form-select form-select-sm rounded-3 shadow-none border-secondary-subtle" onchange="this.form.submit()">
                        <option value="available" {{ $statusFilter == 'available' ? 'selected' : '' }}>Available Units</option>
                        <option value="issued" {{ $statusFilter == 'issued' ? 'selected' : '' }}>Issued Units</option>
                        <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Records</option>
                    </select>
                    @if($bloodGroupFilter || ($statusFilter && $statusFilter != 'available'))
                        <a href="{{ route('blood-bank.index') }}" class="btn btn-sm btn-outline-secondary rounded-3" title="Clear Filters">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-blood align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Bag / Unit #</th>
                                <th>Blood Group</th>
                                <th>Component</th>
                                <th>Donor Source</th>
                                <th>Collection Date</th>
                                <th>Expiry Date</th>
                                <th>Storage Location</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bags as $bag)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-3">
                                                <i class="fa-solid fa-barcode me-1"></i>{{ $bag->bag_number }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge text-white px-2 py-1 rounded-3 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c);">
                                            {{ $bag->blood_group }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $bag->component_type }}</span>
                                    </td>
                                    <td>
                                        @if($bag->donor)
                                            <div class="fw-semibold text-dark">{{ $bag->donor->name }}</div>
                                            <div class="small text-muted">{{ $bag->donor->donor_code }}</div>
                                        @else
                                            <span class="badge bg-light text-secondary border">External Bank</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($bag->collected_at)->format('d M, Y') }}</td>
                                    <td>
                                        @php
                                            $isExpired = \Carbon\Carbon::parse($bag->expiry_date)->isPast();
                                            $isSoon = \Carbon\Carbon::parse($bag->expiry_date)->diffInDays(now()) <= 7 && !$isExpired;
                                        @endphp
                                        @if($isExpired)
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i>Expired ({{ \Carbon\Carbon::parse($bag->expiry_date)->format('d M, Y') }})
                                            </span>
                                        @elseif($isSoon)
                                            <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1">
                                                <i class="fa-solid fa-clock me-1"></i>Exp. Soon ({{ \Carbon\Carbon::parse($bag->expiry_date)->format('d M, Y') }})
                                            </span>
                                        @else
                                            <span class="text-secondary fw-medium">
                                                {{ \Carbon\Carbon::parse($bag->expiry_date)->format('d M, Y') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-muted"><i class="fa-solid fa-temperature-arrow-down me-1 text-info"></i>{{ $bag->storage_location ?? 'Blood Refrigerator 1' }}</span>
                                    </td>
                                    <td>
                                        @if($bag->status == 'available')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                                <i class="fa-solid fa-circle-check me-1"></i>Available
                                            </span>
                                        @elseif($bag->status == 'issued')
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill">
                                                <i class="fa-solid fa-circle-minus me-1"></i>Issued
                                            </span>
                                            @if($bag->patient)
                                                <div class="small text-muted mt-1"><i class="fa-solid fa-user me-1"></i>{{ $bag->patient->name }}</div>
                                            @endif
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill">{{ ucfirst($bag->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($bag->status == 'available')
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#issueBagModal{{ $bag->id }}">
                                                <i class="fa-solid fa-hand-holding-heart me-1"></i> Issue
                                            </button>

                                            <!-- Issue Bag Modal -->
                                            <div class="modal fade" id="issueBagModal{{ $bag->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <form action="{{ route('blood-bank.issue-bag', $bag->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-content text-start border-0 shadow-lg rounded-4 overflow-hidden">
                                                            <div class="modal-header text-white" style="background: linear-gradient(135deg, #e11d48, #be123c);">
                                                                <h5 class="modal-title fs-6 fw-bold">
                                                                    <i class="fa-solid fa-hand-holding-heart me-2"></i>Issue Blood Unit #{{ $bag->bag_number }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <div class="p-3 rounded-3 mb-3" style="background: #fff1f2; border: 1px solid #fecdd3;">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-bold text-danger fs-5">{{ $bag->blood_group }} Group</span>
                                                                        <span class="badge bg-white text-danger border border-danger-subtle px-2 py-1">{{ $bag->component_type }}</span>
                                                                    </div>
                                                                    <div class="small text-muted mt-1">Expiry Date: {{ \Carbon\Carbon::parse($bag->expiry_date)->format('d M, Y') }}</div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-dark">Recipient Patient <span class="text-danger">*</span></label>
                                                                    <select name="issued_to_patient_id" class="form-select rounded-3" required>
                                                                        <option value="">-- Select Recipient Patient --</option>
                                                                        @foreach($patients as $patient)
                                                                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->mobile ?? $patient->phone }}) - {{ $patient->blood_group ?? 'Unknown BG' }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="alert alert-warning small mb-0 rounded-3 border-0" style="background: #fefce8; color: #854d0e;">
                                                                    <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> 
                                                                    <strong>Mandatory Check:</strong> Ensure pre-transfusion cross-matching & patient compatibility are strictly verified before administering.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light border-0 py-3">
                                                                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                                                                    <i class="fa-solid fa-check me-1"></i> Confirm Issue
                                                                </button>
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
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state text-center py-4">
                                            <i class="fa-solid fa-droplet text-danger opacity-25 display-4 mb-3 d-block"></i>
                                            <h6 class="fw-bold text-secondary mb-1">No Blood Units Found</h6>
                                            <p class="text-muted small mb-3">No blood bags match the selected criteria or filters.</p>
                                            <button type="button" class="btn btn-sm btn-danger rounded-3" data-bs-toggle="modal" data-bs-target="#addBagModal">
                                                <i class="fa-solid fa-plus-circle me-1"></i> Add First Blood Unit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($bags->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4">
                    {{ $bags->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ================================================================
         TAB 2: REGISTERED DONORS DIRECTORY
         ================================================================ -->
    <div class="tab-pane fade" id="donors" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="fa-solid fa-users text-primary"></i> Voluntary Blood Donors Directory
                    </h6>
                    <small class="text-muted">Registered eligible blood donors available for contact</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#newDonorModal">
                    <i class="fa-solid fa-user-plus me-1"></i> Register New Donor
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-blood align-middle mb-0">
                        <thead>
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
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-3 fw-bold">
                                            {{ $donor->donor_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $donor->name }}</div>
                                        <div class="small text-muted"><i class="fa-solid fa-phone me-1 text-success"></i>{{ $donor->mobile }}</div>
                                    </td>
                                    <td>
                                        <span class="badge text-white px-2 py-1 rounded-3 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c);">
                                            {{ $donor->blood_group }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary">{{ $donor->age ?? 'N/A' }} yrs / {{ $donor->gender }}</span>
                                    </td>
                                    <td>
                                        @if($donor->last_donated_at)
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($donor->last_donated_at)->format('d M, Y') }}</span>
                                            <div class="small text-muted">{{ \Carbon\Carbon::parse($donor->last_donated_at)->diffForHumans() }}</div>
                                        @else
                                            <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill">Never / First Time</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                            <i class="fa-solid fa-circle-check me-1"></i>{{ $donor->status }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">{{ $donor->address ?? 'Dhaka, Bangladesh' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state text-center py-4">
                                            <i class="fa-solid fa-users text-primary opacity-25 display-4 mb-3 d-block"></i>
                                            <h6 class="fw-bold text-secondary mb-1">No Donors Registered Yet</h6>
                                            <p class="text-muted small mb-3">Add voluntary blood donors to maintain emergency contact rosters.</p>
                                            <button type="button" class="btn btn-sm btn-danger rounded-3" data-bs-toggle="modal" data-bs-target="#newDonorModal">
                                                <i class="fa-solid fa-user-plus me-1"></i> Register First Donor
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($donors->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4">
                    {{ $donors->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ====================================================================
     MODAL: REGISTER DONOR
     ==================================================================== -->
<div class="modal fade" id="newDonorModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('blood-bank.store-donor') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <h5 class="modal-title fs-6 fw-bold">
                        <i class="fa-solid fa-user-plus me-2 text-danger"></i>Register Voluntary Blood Donor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Donor Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g., Tanvir Hasan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Blood Group <span class="text-danger">*</span></label>
                            <select name="blood_group" class="form-select rounded-3" required>
                                <option value="">Select Group</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select rounded-3" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Age (18-65)</label>
                            <input type="number" name="age" class="form-control rounded-3" min="18" max="65" placeholder="e.g., 28">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mobile Phone <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control rounded-3" required placeholder="017XXXXXXXX">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="donor@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Donation Date</label>
                            <input type="date" name="last_donated_at" class="form-control rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Residential Address</label>
                            <input type="text" name="address" class="form-control rounded-3" placeholder="House, Road, Area, City">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Medical / Screening Notes</label>
                            <textarea name="medical_notes" class="form-control rounded-3" rows="2" placeholder="Hemoglobin level, blood pressure, viral screening results..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                        <i class="fa-solid fa-save me-1"></i> Register Donor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ====================================================================
     MODAL: ADD BLOOD UNIT
     ==================================================================== -->
<div class="modal fade" id="addBagModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('blood-bank.store-bag') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #e11d48, #be123c);">
                    <h5 class="modal-title fs-6 fw-bold">
                        <i class="fa-solid fa-plus-circle me-2"></i>Add Blood Unit to Bank
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Blood Group <span class="text-danger">*</span></label>
                            <select name="blood_group" class="form-select rounded-3" required>
                                <option value="">Select Group</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Component Type <span class="text-danger">*</span></label>
                            <select name="component_type" class="form-select rounded-3" required>
                                <option value="Whole Blood">Whole Blood (450ml)</option>
                                <option value="Packed Red Cells (PRBC)">Packed Red Cells (PRBC)</option>
                                <option value="Fresh Frozen Plasma (FFP)">Fresh Frozen Plasma (FFP)</option>
                                <option value="Platelet Concentrate">Platelet Concentrate (PC)</option>
                                <option value="Cryoprecipitate">Cryoprecipitate</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Source Donor (Optional)</label>
                            <select name="donor_id" class="form-select rounded-3">
                                <option value="">-- Voluntary / External Bank / Walk-in --</option>
                                @foreach($donors as $dn)
                                    <option value="{{ $dn->id }}">{{ $dn->name }} ({{ $dn->donor_code }}) - {{ $dn->blood_group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Collection Date <span class="text-danger">*</span></label>
                            <input type="date" name="collected_at" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control rounded-3" value="{{ date('Y-m-d', strtotime('+35 days')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Storage Location</label>
                            <input type="text" name="storage_location" class="form-control rounded-3" placeholder="e.g., Blood Refrigerator 1, Shelf B">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                        <i class="fa-solid fa-save me-1"></i> Save Blood Unit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
