@extends('layouts.admin')

@section('title', 'Hospital Wards & Units')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-hospital text-white me-2"></i>Wards & Inpatient Units</h4>
        <p class="mb-0 text-white-50">Manage General Wards, Male/Female Blocks, ICU, CCU, NICU & VIP Cabins</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('beds.matrix') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-table-cells me-1"></i> Bed Occupancy Matrix
        </a>
        <a href="{{ route('wards.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Add New Ward
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

<div class="row g-4 mb-4">
    @foreach($wards as $w)
        @php
            $rate = $w->total_beds_count > 0 ? round(($w->occupied_beds_count / $w->total_beds_count) * 100) : 0;
        @endphp
        <div class="col-md-6 col-xl-4">
            <div class="card card-premium shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold mb-1">{{ $w->code }}</span>
                            <h5 class="fw-bold mb-0 text-dark">{{ $w->name }}</h5>
                            <small class="text-muted"><i class="fa-solid fa-building me-1"></i>{{ $w->floor ?? 'Main Building' }} | {{ $w->type }}</small>
                        </div>
                        <span class="badge {{ $w->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $w->status }}
                        </span>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Bed Occupancy</span>
                            <span class="fw-bold {{ $rate >= 80 ? 'text-danger' : 'text-primary' }}">{{ $w->occupied_beds_count }} / {{ $w->total_beds_count }} Beds ({{ $rate }}%)</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar {{ $rate >= 80 ? 'bg-danger' : ($rate >= 50 ? 'bg-warning' : 'bg-success') }}" 
                                 role="progressbar" style="width: {{ $rate }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top text-muted" style="font-size: 0.8rem;">
                            <span>Available: <strong class="text-success">{{ $w->available_beds_count }}</strong></span>
                            <span>Daily Charge: <strong class="text-dark">৳ {{ number_format($w->daily_charge, 2) }}</strong></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('beds.index', ['ward_id' => $w->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fa-solid fa-bed me-1"></i> View Beds
                        </a>
                        <div class="d-flex gap-1">
                            <a href="{{ route('wards.edit', $w->id) }}" class="action-btn action-btn-edit" title="Edit Ward">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('wards.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Delete this ward?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-btn-del" title="Delete Ward">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
