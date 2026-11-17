@extends('layouts.admin')

@section('title', 'Real-time Bed Occupancy Matrix')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-table-cells me-2"></i>Bed Occupancy Matrix</h4>
        <p class="mb-0 text-white-50">Real-time Visual Hospital Bed Allocation, Housekeeping & Cleaning Status</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('beds.create') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Bed
        </a>
        <a href="{{ route('admissions.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-bed-pulse me-1"></i> New Admission
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

<!-- Bed Status Legend & Global Counters -->
<div class="card card-premium shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row g-3 text-center align-items-center">
            <div class="col-6 col-md">
                <span class="text-muted small text-uppercase fw-bold">Total Hospital Beds</span>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h3>
            </div>
            <div class="col-6 col-md">
                <span class="text-success small text-uppercase fw-bold"><i class="fa-solid fa-circle me-1"></i>Available</span>
                <h3 class="fw-bold mb-0 text-success">{{ $stats['available'] }}</h3>
            </div>
            <div class="col-6 col-md">
                <span class="text-danger small text-uppercase fw-bold"><i class="fa-solid fa-circle me-1"></i>Occupied</span>
                <h3 class="fw-bold mb-0 text-danger">{{ $stats['occupied'] }}</h3>
            </div>
            <div class="col-6 col-md">
                <span class="text-warning small text-uppercase fw-bold"><i class="fa-solid fa-circle me-1"></i>Cleaning</span>
                <h3 class="fw-bold mb-0 text-warning">{{ $stats['cleaning'] }}</h3>
            </div>
            <div class="col-6 col-md">
                <span class="text-secondary small text-uppercase fw-bold"><i class="fa-solid fa-circle me-1"></i>Maintenance</span>
                <h3 class="fw-bold mb-0 text-secondary">{{ $stats['maintenance'] }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Ward-by-Ward Visual Grid -->
@foreach($wards as $ward)
    <div class="card card-premium shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold me-2">{{ $ward->code }}</span>
                <strong class="fs-6 text-dark">{{ $ward->name }}</strong>
                <span class="text-muted small ms-2">({{ $ward->floor ?? 'Main Block' }} | ৳ {{ number_format($ward->daily_charge, 2) }}/day)</span>
            </div>
            <div>
                <span class="badge bg-success bg-opacity-10 text-success me-1">
                    {{ $ward->beds->where('status', 'available')->count() }} Free
                </span>
                <span class="badge bg-danger bg-opacity-10 text-danger">
                    {{ $ward->beds->where('status', 'occupied')->count() }} Occupied
                </span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @forelse($ward->beds as $bed)
                    @php
                        $bedBg = match($bed->status) {
                            'available' => 'border-success bg-success bg-opacity-10',
                            'occupied' => 'border-danger bg-danger bg-opacity-10',
                            'cleaning' => 'border-warning bg-warning bg-opacity-10',
                            'maintenance' => 'border-secondary bg-secondary bg-opacity-10',
                            default => 'border-light bg-light'
                        };
                        $statusBadge = match($bed->status) {
                            'available' => 'bg-success',
                            'occupied' => 'bg-danger',
                            'cleaning' => 'bg-warning text-dark',
                            'maintenance' => 'bg-secondary',
                            default => 'bg-light text-dark'
                        };
                    @endphp
                    <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                        <div class="card h-100 border-2 {{ $bedBg }} shadow-sm text-center p-3 position-relative" style="border-radius: 12px; transition: transform 0.2s;">
                            <!-- Bed Number -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold fs-6 text-dark">{{ $bed->bed_number }}</span>
                                <span class="badge {{ $statusBadge }} text-uppercase" style="font-size: 0.65rem;">
                                    {{ $bed->status }}
                                </span>
                            </div>

                            <div class="my-2">
                                @if($bed->status === 'occupied' && $bed->currentAdmission)
                                    <div class="text-start p-2 bg-white rounded-2 shadow-xs" style="font-size: 0.78rem;">
                                        <div class="fw-bold text-truncate" title="{{ $bed->currentAdmission->patient->name ?? '' }}">
                                            <i class="fa-solid fa-user me-1 text-danger"></i>{{ $bed->currentAdmission->patient->name ?? 'Patient' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.72rem;">{{ $bed->currentAdmission->admission_no }}</div>
                                        <div class="text-primary mt-1" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-user-doctor me-1"></i>{{ $bed->currentAdmission->doctor->name ?? 'Doctor' }}
                                        </div>
                                    </div>
                                    <a href="{{ route('admissions.show', $bed->currentAdmission->id) }}" class="btn btn-sm btn-outline-danger w-100 mt-2 py-1" style="font-size: 0.75rem;">
                                        View Chart
                                    </a>
                                @elseif($bed->status === 'available')
                                    <div class="py-2 text-success">
                                        <i class="fa-solid fa-bed fs-2 mb-1 opacity-75"></i>
                                        <div class="small fw-bold">Available</div>
                                    </div>
                                    <a href="{{ route('admissions.create', ['ward_id' => $ward->id, 'bed_id' => $bed->id]) }}" class="btn btn-sm btn-success w-100 mt-1 py-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-plus me-1"></i> Admit
                                    </a>
                                @elseif($bed->status === 'cleaning')
                                    <div class="py-2 text-warning">
                                        <i class="fa-solid fa-broom fs-2 mb-1 opacity-75"></i>
                                        <div class="small fw-bold text-dark">Sanitizing</div>
                                    </div>
                                    <form action="{{ route('beds.updateStatus', $bed->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="available">
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100 mt-1 py-1" style="font-size: 0.72rem;">
                                            Mark Clean
                                        </button>
                                    </form>
                                @else
                                    <div class="py-2 text-secondary">
                                        <i class="fa-solid fa-screwdriver-wrench fs-2 mb-1 opacity-75"></i>
                                        <div class="small fw-bold">Maintenance</div>
                                    </div>
                                    <form action="{{ route('beds.updateStatus', $bed->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="available">
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 mt-1 py-1" style="font-size: 0.72rem;">
                                            Put in Service
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-3">
                        No beds added to this ward yet. <a href="{{ route('beds.create') }}">Add Beds</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endforeach
@endsection
