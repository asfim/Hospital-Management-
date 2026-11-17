@extends('layouts.admin')

@section('title', 'Laboratory Sample Collection & Tracking')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-vial-circle-check me-2"></i>Laboratory Specimen Tracking</h4>
        <p class="mb-0 text-white-50">Phlebotomy Sample Collection, Barcode Tracking & Central Lab Receipt</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Counters -->
<div class="row g-3 mb-4">
    <div class="col-md">
        <a href="{{ route('samples.index', ['status' => 'Pending']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-warning border-4 shadow-sm {{ $status == 'Pending' ? 'bg-warning bg-opacity-10' : '' }}">
                <span class="text-warning fw-bold small text-uppercase">Pending Collection</span>
                <h3 class="fw-bold mb-0 text-dark mt-1">{{ $counts['pending'] }}</h3>
            </div>
        </a>
    </div>
    <div class="col-md">
        <a href="{{ route('samples.index', ['status' => 'Collected']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-primary border-4 shadow-sm {{ $status == 'Collected' ? 'bg-primary bg-opacity-10' : '' }}">
                <span class="text-primary fw-bold small text-uppercase">Collected (In Transit)</span>
                <h3 class="fw-bold mb-0 text-primary mt-1">{{ $counts['collected'] }}</h3>
            </div>
        </a>
    </div>
    <div class="col-md">
        <a href="{{ route('samples.index', ['status' => 'Received']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-info border-4 shadow-sm {{ $status == 'Received' ? 'bg-info bg-opacity-10' : '' }}">
                <span class="text-info fw-bold small text-uppercase">Received in Lab</span>
                <h3 class="fw-bold mb-0 text-info mt-1">{{ $counts['received'] }}</h3>
            </div>
        </a>
    </div>
    <div class="col-md">
        <a href="{{ route('samples.index', ['status' => 'Completed']) }}" class="text-decoration-none">
            <div class="card card-premium p-3 border-start border-success border-4 shadow-sm {{ $status == 'Completed' ? 'bg-success bg-opacity-10' : '' }}">
                <span class="text-success fw-bold small text-uppercase">Processed / Done</span>
                <h3 class="fw-bold mb-0 text-success mt-1">{{ $counts['completed'] }}</h3>
            </div>
        </a>
    </div>
</div>

<!-- Samples Register -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold text-dark">Specimen Collection Log</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('samples.index') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('samples.index', ['status' => 'Pending']) }}" class="btn btn-sm {{ $status == 'Pending' ? 'btn-primary' : 'btn-outline-secondary' }}">Pending</a>
            <a href="{{ route('samples.index', ['status' => 'Collected']) }}" class="btn btn-sm {{ $status == 'Collected' ? 'btn-primary' : 'btn-outline-secondary' }}">Collected</a>
            <a href="{{ route('samples.index', ['status' => 'Received']) }}" class="btn btn-sm {{ $status == 'Received' ? 'btn-primary' : 'btn-outline-secondary' }}">Received</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Sample Code / Barcode</th>
                    <th>Patient</th>
                    <th>Test Name</th>
                    <th>Specimen</th>
                    <th>Collected At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($samples as $sample)
                    @php
                        $badge = match($sample->status) {
                            'Pending' => 'bg-warning text-dark',
                            'Collected' => 'bg-primary text-white',
                            'Received' => 'bg-info text-dark',
                            'Processing' => 'bg-secondary text-white',
                            'Completed' => 'bg-success text-white',
                            'Rejected' => 'bg-danger text-white',
                            default => 'bg-light text-dark'
                        };
                    @endphp
                    <tr>
                        <td>
                            <span class="id-badge">{{ $sample->sample_code ?? 'SMP-PENDING' }}</span><br>
                            @if($sample->barcode)
                                <small class="text-muted"><i class="fa-solid fa-barcode me-1"></i>{{ $sample->barcode }}</small>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $sample->patient->name ?? 'Patient' }}</strong><br>
                            <small class="text-muted">{{ $sample->patient->patient_id ?? '' }}</small>
                        </td>
                        <td><strong>{{ $sample->test->name ?? 'Diagnostic Test' }}</strong></td>
                        <td><span class="badge bg-light text-dark border">{{ $sample->specimen_type }}</span></td>
                        <td>
                            @if($sample->collected_at)
                                <small class="fw-bold">{{ $sample->collected_at->format('M d, h:i A') }}</small><br>
                                <small class="text-muted">{{ $sample->collector->name ?? 'Collector' }}</small>
                            @else
                                <span class="text-muted small">Not collected yet</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $badge }} text-uppercase">
                                {{ $sample->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($sample->status === 'Pending')
                                    <form action="{{ route('samples.collect', $sample->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa-solid fa-hand-holding-droplet me-1"></i> Collect
                                        </button>
                                    </form>
                                @elseif($sample->status === 'Collected')
                                    <form action="{{ route('samples.receive', $sample->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info text-white">
                                            <i class="fa-solid fa-inbox me-1"></i> Receive in Lab
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fa-solid fa-vial fs-1 mb-2 text-primary opacity-50"></i>
                            <p class="mb-0">No specimen samples logged.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($samples->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $samples->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
