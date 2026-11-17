@extends('layouts.admin')

@section('title', 'Edit Ward - ' . $ward->name)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('wards.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Edit Ward: {{ $ward->name }}</h4>
                <p class="mb-0 text-white-50">Ward Code: {{ $ward->code }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('wards.update', $ward->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ward Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ $ward->name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ward Category / Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            @foreach(['General', 'Male', 'Female', 'ICU', 'CCU', 'NICU', 'PICU', 'Cabin', 'VIP'] as $t)
                                <option value="{{ $t }}" {{ $ward->type == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Floor / Building Location</label>
                        <input type="text" name="floor" class="form-control" value="{{ $ward->floor }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender Allocation <span class="text-danger">*</span></label>
                        <select name="gender_type" class="form-select" required>
                            @foreach(['Mixed', 'Male', 'Female', 'Pediatric'] as $gt)
                                <option value="{{ $gt }}" {{ $ward->gender_type == $gt ? 'selected' : '' }}>{{ $gt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Capacity (Bed Count) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" class="form-control" required value="{{ $ward->capacity }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Daily Bed Rate (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="daily_charge" class="form-control" required value="{{ $ward->daily_charge }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ward Operational Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" {{ $ward->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $ward->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Maintenance" {{ $ward->status == 'Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description / Facilities</label>
                        <textarea name="description" class="form-control" rows="3">{{ $ward->description }}</textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('wards.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Update Ward</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
