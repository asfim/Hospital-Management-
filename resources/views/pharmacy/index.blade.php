@extends('layouts.admin')

@section('title', 'Hospital Pharmacy Management')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-pills me-2"></i>Hospital Pharmacy Department</h4>
        <p class="mb-0 text-white-50">Point-of-Sale (POS) Dispensing, Inventory Batches, Expiry & Low Stock Alerts</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pharmacy.medicines') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-list me-1"></i> Medicines Formulary
        </a>
        <a href="{{ route('pharmacy.batches') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-boxes-stacked me-1"></i> Batches & Stock
        </a>
        <a href="{{ route('pharmacy.pos') }}" class="btn btn-warning text-dark fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-cash-register me-1"></i> Open POS Counter
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Pharmacy KPI Counters -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-premium p-3 border-start border-success border-4 shadow-sm h-100">
            <span class="text-muted small text-uppercase fw-bold">Today's Pharmacy Sales</span>
            <h3 class="fw-bold text-success mt-1 mb-0">৳ {{ number_format($todaySales, 2) }}</h3>
            <small class="text-muted">{{ $todaySalesCount }} dispensing bills</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-premium p-3 border-start border-primary border-4 shadow-sm h-100">
            <span class="text-muted small text-uppercase fw-bold">Total Active Medicines</span>
            <h3 class="fw-bold text-primary mt-1 mb-0">{{ $totalMedicines }}</h3>
            <small class="text-muted">In hospital formulary</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-premium p-3 border-start border-danger border-4 shadow-sm h-100">
            <span class="text-danger small text-uppercase fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i>Low Stock Alert</span>
            <h3 class="fw-bold text-danger mt-1 mb-0">{{ $lowStockMedicines->count() }}</h3>
            <small class="text-danger">Need immediate reorder</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-premium p-3 border-start border-warning border-4 shadow-sm h-100">
            <span class="text-warning small text-uppercase fw-bold"><i class="fa-solid fa-calendar-xmark me-1"></i>Near Expiry Alert</span>
            <h3 class="fw-bold text-dark mt-1 mb-0">{{ $nearExpiryBatches->count() }}</h3>
            <small class="text-muted">Expiring in 90 days</small>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Low Stock Alert Table -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Critical Low Stock Medicines</h6>
                <a href="{{ route('pharmacy.medicines') }}" class="btn btn-sm btn-outline-danger rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Medicine</th>
                            <th>Form & Strength</th>
                            <th>Available</th>
                            <th>Reorder Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockMedicines->take(5) as $lMed)
                            <tr>
                                <td><strong>{{ $lMed->name }}</strong><br><small class="text-muted">{{ $lMed->generic_name }}</small></td>
                                <td>{{ $lMed->dosage_form }} ({{ $lMed->strength }})</td>
                                <td><span class="badge bg-danger fs-6">{{ $lMed->totalStock() }}</span></td>
                                <td>{{ $lMed->reorder_level }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-success py-4">
                                    <i class="fa-solid fa-circle-check me-1"></i> All stock levels are sufficient.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Near Expiry Batches -->
    <div class="col-lg-6">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-warning"><i class="fa-solid fa-clock text-warning me-2"></i>Batches Expiring Soon (90 Days)</h6>
                <a href="{{ route('pharmacy.batches') }}" class="btn btn-sm btn-outline-warning text-dark rounded-pill">All Batches</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Batch #</th>
                            <th>Medicine</th>
                            <th>Expiry Date</th>
                            <th>Remaining Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nearExpiryBatches as $nb)
                            <tr>
                                <td><span class="id-badge">{{ $nb->batch_no }}</span></td>
                                <td><strong>{{ $nb->medicine->name ?? 'Medicine' }}</strong></td>
                                <td><span class="text-danger fw-bold">{{ $nb->expiry_date ? $nb->expiry_date->format('M d, Y') : '' }}</span></td>
                                <td><span class="badge bg-light text-dark border">{{ $nb->quantity_available }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-success py-4">
                                    <i class="fa-solid fa-circle-check me-1"></i> No batches expiring within the next 90 days.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Dispensing Bills -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-receipt text-primary me-2"></i>Recent Pharmacy Dispensing Bills</h6>
        <a href="{{ route('pharmacy.pos') }}" class="btn btn-sm btn-primary rounded-pill">New Sale</a>
    </div>
    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Bill #</th>
                    <th>Customer / Patient</th>
                    <th>Date & Time</th>
                    <th>Payment Method</th>
                    <th>Total (৳)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                    <tr>
                        <td><span class="id-badge">{{ $sale->bill_no }}</span></td>
                        <td>
                            <strong>{{ $sale->customer_name ?? ($sale->patient->name ?? 'Walk-in') }}</strong><br>
                            <small class="text-muted">{{ $sale->customer_phone ?? ($sale->patient->mobile ?? '') }}</small>
                        </td>
                        <td>{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $sale->payment_method }}</span></td>
                        <td class="fw-bold text-success">৳ {{ number_format($sale->total, 2) }}</td>
                        <td>
                            <a href="{{ route('pharmacy.print', $sale->id) }}" class="action-btn action-btn-view" title="Print Receipt">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No pharmacy sales yet today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
