@extends('layouts.admin')

@section('title', 'Add New Ward')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('wards.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Create Hospital Ward</h4>
                <p class="mb-0 text-white-50">Configure Inpatient Ward, Specialty Unit or Cabin Block</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('wards.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ward Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Intensive Care Unit (ICU)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ward Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required placeholder="e.g. ICU-01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ward Category / Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="General">General Ward</option>
                            <option value="Male">Male Ward</option>
                            <option value="Female">Female Ward</option>
                            <option value="ICU">ICU (Intensive Care)</option>
                            <option value="CCU">CCU (Coronary Care)</option>
                            <option value="NICU">NICU (Neonatal)</option>
                            <option value="PICU">PICU (Pediatric)</option>
                            <option value="Cabin">Private Cabin</option>
                            <option value="VIP">VIP Deluxe Cabin</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Floor / Building Location</label>
                        <input type="text" name="floor" class="form-control" placeholder="e.g. 3rd Floor, West Wing">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender Allocation <span class="text-danger">*</span></label>
                        <select name="gender_type" class="form-select" required>
                            <option value="Mixed">Mixed</option>
                            <option value="Male">Male Only</option>
                            <option value="Female">Female Only</option>
                            <option value="Pediatric">Pediatric</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Capacity (Bed Count) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" class="form-control" required value="10" min="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Daily Bed Rate (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="daily_charge" class="form-control" required placeholder="800.00">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description / Facilities</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Facilities, medical gas pipelines, nurse calling system..."></textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('wards.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Save Ward</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
