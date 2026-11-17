@extends('layouts.admin')

@section('title', 'Edit Bed - ' . $bed->bed_number)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('beds.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Edit Bed: {{ $bed->bed_number }}</h4>
                <p class="mb-0 text-white-50">Ward: {{ $bed->ward->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('beds.update', $bed->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Ward / Unit <span class="text-danger">*</span></label>
                        <select name="ward_id" class="form-select" required>
                            @foreach($wards as $w)
                                <option value="{{ $w->id }}" {{ $bed->ward_id == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bed Number / Label <span class="text-danger">*</span></label>
                        <input type="text" name="bed_number" class="form-control" required value="{{ $bed->bed_number }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bed Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            @foreach(['Standard Hospital Bed', 'Semi-Fowler Bed', 'Fowler Bed', 'Electric ICU Bed', 'VIP Cabin Bed', 'Pediatric Crib'] as $bt)
                                <option value="{{ $bt }}" {{ $bed->type == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Daily Charge (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="daily_charge" class="form-control" required value="{{ $bed->daily_charge }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Operational Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ $bed->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ $bed->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="cleaning" {{ $bed->status == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="maintenance" {{ $bed->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes / Medical Gas Outlets</label>
                        <textarea name="notes" class="form-control" rows="2">{{ $bed->notes }}</textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('beds.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Update Bed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
