@extends('layouts.admin')

@section('title', 'Radiology & Medical Imaging')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-x-ray me-2"></i>Radiology & Medical Imaging</h4>
        <p class="mb-0 text-white-50">X-Ray, Ultrasound, CT Scan, 3T MRI, ECG, Echo & Digital PACS Reports</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('radiology.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> New Radiology Order
        </a>
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
        <h6 class="mb-0 fw-bold text-dark">Radiology Investigations</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('radiology.index') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('radiology.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $status == 'pending' ? 'btn-warning text-dark' : 'btn-outline-secondary' }}">Pending Report</a>
            <a href="{{ route('radiology.index', ['status' => 'reported']) }}" class="btn btn-sm {{ $status == 'reported' ? 'btn-success' : 'btn-outline-secondary' }}">Reported</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Patient</th>
                    <th>Investigation</th>
                    <th>Modality</th>
                    <th>Doctor</th>
                    <th>Cost (৳)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $ord)
                    <tr>
                        <td><span class="id-badge">{{ $ord->order_no }}</span></td>
                        <td>
                            <strong>{{ $ord->patient->name ?? 'Patient' }}</strong><br>
                            <small class="text-muted">{{ $ord->patient->patient_id }}</small>
                        </td>
                        <td><strong>{{ $ord->test_name }}</strong></td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold">{{ $ord->modality }}</span></td>
                        <td><small>{{ $ord->doctor->name ?? 'Self / OPD' }}</small></td>
                        <td class="fw-bold text-dark">৳ {{ number_format($ord->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $ord->status == 'reported' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($ord->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('radiology.report', $ord->id) }}" class="btn btn-sm btn-outline-primary" title="Enter / Edit Report">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Report
                                </a>
                                @if($ord->status === 'reported')
                                    <a href="{{ route('radiology.print', $ord->id) }}" class="action-btn action-btn-view" title="Print Digital Report">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fa-solid fa-x-ray fs-1 mb-2 text-primary opacity-50"></i>
                            <p class="mb-0">No radiology orders recorded.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
