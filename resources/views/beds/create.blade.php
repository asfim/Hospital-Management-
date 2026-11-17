@extends('layouts.admin')

@section('title', 'Add New Hospital Bed')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('beds.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Add Bed to Ward</h4>
                <p class="mb-0 text-white-50">Create New Patient Bed and Set Daily Rate</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('beds.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Ward / Unit <span class="text-danger">*</span></label>
                        <select name="ward_id" class="form-select" required>
                            <option value="">-- Choose Ward --</option>
                            @foreach($wards as $w)
                                <option value="{{ $w->id }}">{{ $w->name }} ({{ $w->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bed Number / Label <span class="text-danger">*</span></label>
                        <input type="text" name="bed_number" class="form-control" required placeholder="e.g. ICU-B01 or Cabin-402">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bed Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="Standard Hospital Bed">Standard Hospital Bed</option>
                            <option value="Semi-Fowler Bed">Semi-Fowler Bed</option>
                            <option value="Fowler Bed">Full Fowler Bed</option>
                            <option value="Electric ICU Bed">Electric ICU Bed</option>
                            <option value="VIP Cabin Bed">VIP Cabin Bed</option>
                            <option value="Pediatric Crib">Pediatric Crib</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Daily Charge (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="daily_charge" class="form-control" required placeholder="800.00">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes / Medical Gas Outlets</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Central oxygen port, cardiac monitor attached..."></textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('beds.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Add Bed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
