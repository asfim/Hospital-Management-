@extends('layouts.admin')

@section('title', 'Medicine Batches & Stock Management')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Medicine Batches & Expiry Tracking</h4>
                <p class="mb-0 text-white-50">Manage Stock Batches, Expiry Dates & Unit Purchase Rates</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-light text-primary fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#receiveBatchModal">
            <i class="fa-solid fa-boxes-packing me-1"></i> Receive Stock Batch
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
        <h6 class="mb-0 fw-bold text-dark">Batches Inventory</h6>
        <form method="GET" action="{{ route('pharmacy.batches') }}" class="d-flex gap-2">
            <select name="medicine_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 250px;">
                <option value="">-- All Medicines --</option>
                @foreach($medicines as $m)
                    <option value="{{ $m->id }}" {{ $medicineId == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Batch #</th>
                    <th>Medicine Brand</th>
                    <th>Expiry Date</th>
                    <th>Quantity In</th>
                    <th>Available Qty</th>
                    <th>Purchase Rate</th>
                    <th>Sale Rate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $b)
                    @php
                        $isExpired = $b->expiry_date && $b->expiry_date->isPast();
                        $nearExpiry = $b->expiry_date && !$isExpired && $b->expiry_date->diffInDays(now()) <= 90;
                    @endphp
                    <tr>
                        <td><span class="id-badge">{{ $b->batch_no }}</span></td>
                        <td><strong>{{ $b->medicine->name ?? 'Medicine' }}</strong></td>
                        <td>
                            @if($isExpired)
                                <span class="badge bg-danger">Expired ({{ $b->expiry_date->format('M d, Y') }})</span>
                            @elseif($nearExpiry)
                                <span class="badge bg-warning text-dark">Expires {{ $b->expiry_date->format('M d, Y') }}</span>
                            @else
                                <span class="text-dark">{{ $b->expiry_date ? $b->expiry_date->format('M d, Y') : '-' }}</span>
                            @endif
                        </td>
                        <td>{{ $b->quantity_in }}</td>
                        <td>
                            <strong class="{{ $b->quantity_available <= 10 ? 'text-danger' : 'text-success' }} fs-6">
                                {{ $b->quantity_available }}
                            </strong>
                        </td>
                        <td>৳ {{ number_format($b->purchase_rate, 2) }}</td>
                        <td class="fw-bold text-primary">৳ {{ number_format($b->sale_rate, 2) }}</td>
                        <td>
                            <span class="badge {{ $b->quantity_available > 0 ? 'bg-success' : 'bg-secondary' }}">
                                {{ $b->quantity_available > 0 ? 'In Stock' : 'Depleted' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">No batches found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($batches->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $batches->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Modal: Receive Stock Batch -->
<div class="modal fade" id="receiveBatchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('pharmacy.storeBatch') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-boxes-packing me-2"></i>Receive New Stock Batch</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Select Medicine <span class="text-danger">*</span></label>
                        <select name="medicine_id" class="form-select select2" required>
                            <option value="">-- Choose Medicine --</option>
                            @foreach($medicines as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->dosage_form }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Batch Number <span class="text-danger">*</span></label>
                            <input type="text" name="batch_no" class="form-control" required placeholder="e.g. BCH-2026-9921">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 year')) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Received Quantity (Units) <span class="text-danger">*</span></label>
                            <input type="number" name="quantity_in" class="form-control" required value="100" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Purchase Rate (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="purchase_rate" class="form-control" required placeholder="2.50">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Sale Rate (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="sale_rate" class="form-control" required placeholder="3.50">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Receive Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
