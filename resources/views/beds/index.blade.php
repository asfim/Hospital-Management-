@extends('layouts.admin')

@section('title', 'Manage Hospital Beds')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-procedures me-2"></i>Hospital Beds Inventory</h4>
        <p class="mb-0 text-white-50">Master Bed Inventory, Status Adjustments & Daily Charge Rates</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('beds.matrix') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-table-cells me-1"></i> Visual Matrix
        </a>
        <a href="{{ route('beds.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Add New Bed
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters & Table -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold text-dark">All Hospital Beds</h6>
        <form method="GET" action="{{ route('beds.index') }}" class="d-flex gap-2">
            <select name="ward_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- All Wards --</option>
                @foreach($wards as $w)
                    <option value="{{ $w->id }}" {{ $wardId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- All Statuses --</option>
                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ $status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="cleaning" {{ $status == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Bed Number</th>
                    <th>Ward / Unit</th>
                    <th>Type</th>
                    <th>Daily Rate</th>
                    <th>Current Status</th>
                    <th>Occupied By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beds as $bed)
                    @php
                        $statusBadge = match($bed->status) {
                            'available' => 'bg-success',
                            'occupied' => 'bg-danger',
                            'cleaning' => 'bg-warning text-dark',
                            'maintenance' => 'bg-secondary',
                            default => 'bg-light text-dark'
                        };
                    @endphp
                    <tr>
                        <td><strong class="fs-6 text-dark">{{ $bed->bed_number }}</strong></td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $bed->ward->name ?? 'Ward' }}</span>
                        </td>
                        <td>{{ $bed->type }}</td>
                        <td class="fw-bold text-success">৳ {{ number_format($bed->daily_charge, 2) }}</td>
                        <td>
                            <span class="badge {{ $statusBadge }} text-uppercase">
                                {{ $bed->status }}
                            </span>
                        </td>
                        <td>
                            @if($bed->status === 'occupied' && $bed->currentAdmission)
                                <strong>{{ $bed->currentAdmission->patient->name ?? 'Patient' }}</strong><br>
                                <small class="text-muted">{{ $bed->currentAdmission->admission_no }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('beds.edit', $bed->id) }}" class="action-btn action-btn-edit" title="Edit Bed">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                @if($bed->status !== 'occupied')
                                    <form action="{{ route('beds.destroy', $bed->id) }}" method="POST" onsubmit="return confirm('Delete this bed?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-del" title="Delete Bed">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">No beds found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($beds->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $beds->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
