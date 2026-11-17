@extends('layouts.admin')

@section('title', 'Medicine Formulary Catalog')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Pharmacy Medicines Formulary</h4>
                <p class="mb-0 text-white-50">Hospital Drug Formulary, Generic Names, Pricing & Reorder Limits</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-light text-primary fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
            <i class="fa-solid fa-plus-circle me-1"></i> Add Medicine
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold text-dark">Medicines List</h6>
        <form method="GET" action="{{ route('pharmacy.medicines') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search brand, generic or manufacturer..." value="{{ $search }}" style="min-width: 250px;">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Medicine Brand</th>
                    <th>Generic Name</th>
                    <th>Form & Strength</th>
                    <th>Manufacturer</th>
                    <th>Unit Price</th>
                    <th>Current Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $med)
                    @php $stock = $med->totalStock(); @endphp
                    <tr>
                        <td><strong class="text-dark fs-6">{{ $med->name }}</strong></td>
                        <td><span class="text-primary">{{ $med->generic_name ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $med->dosage_form }}</span>
                            <small class="text-muted ms-1">{{ $med->strength }}</small>
                        </td>
                        <td><small>{{ $med->manufacturer ?? '-' }}</small></td>
                        <td class="fw-bold text-success">৳ {{ number_format($med->unit_price, 2) }}</td>
                        <td>
                            <span class="badge {{ $stock <= $med->reorder_level ? 'bg-danger' : 'bg-success' }} fs-6 px-2 py-1">
                                {{ $stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $med->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($med->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">No medicines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($medicines->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $medicines->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Modal: Add Medicine -->
<div class="modal fade" id="addMedicineModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('pharmacy.storeMedicine') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-pills me-2"></i>Add Medicine to Hospital Formulary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Napa Extra">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Generic Name</label>
                            <input type="text" name="generic_name" class="form-control" placeholder="e.g. Paracetamol + Caffeine">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="Antibiotics">Antibiotics</option>
                                <option value="Analgesics">Analgesics & Antipyretics</option>
                                <option value="Gastrointestinal">Gastrointestinal</option>
                                <option value="Cardiovascular">Cardiovascular</option>
                                <option value="Respiratory">Respiratory</option>
                                <option value="IV Fluid">IV Fluid / Infusion</option>
                                <option value="General" selected>General</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dosage Form <span class="text-danger">*</span></label>
                            <select name="dosage_form" class="form-select" required>
                                <option value="Tablet" selected>Tablet</option>
                                <option value="Capsule">Capsule</option>
                                <option value="Syrup">Syrup</option>
                                <option value="Injection">Injection</option>
                                <option value="IV Fluid">IV Fluid</option>
                                <option value="Ointment">Ointment / Cream</option>
                                <option value="Drop">Eye / Ear Drop</option>
                                <option value="Inhaler">Inhaler</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Strength</label>
                            <input type="text" name="strength" class="form-control" placeholder="e.g. 500mg, 10mg/5ml">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Manufacturer / Pharma</label>
                            <input type="text" name="manufacturer" class="form-control" placeholder="Square, Beximco, Incepta...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sale Unit Price (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="unit_price" class="form-control" required placeholder="3.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Purchase Unit Price (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" required placeholder="2.20">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level Alert <span class="text-danger">*</span></label>
                            <input type="number" name="reorder_level" class="form-control" value="20" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Save Medicine</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
