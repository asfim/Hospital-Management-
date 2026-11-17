@extends('layouts.admin')

@section('title', 'Inpatient (IPD) Admissions')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-bed-pulse me-2"></i>Inpatient (IPD) Admissions</h4>
        <p class="mb-0 text-white-50">Manage Patient Hospitalization, Bed Assignments, Daily Care & Discharges</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('beds.matrix') }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-table-cells me-1"></i> Bed Matrix
        </a>
        <a href="{{ route('admissions.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> New Admission
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Search & Status Filters -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex gap-2">
            <a href="{{ route('admissions.index', ['status' => 'admitted']) }}" class="btn btn-sm {{ $status == 'admitted' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Currently Admitted
            </a>
            <a href="{{ route('admissions.index', ['status' => 'discharged']) }}" class="btn btn-sm {{ $status == 'discharged' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Discharged
            </a>
            <a href="{{ route('admissions.index', ['status' => 'all']) }}" class="btn btn-sm {{ $status == 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                All Records
            </a>
        </div>
        <form method="GET" action="{{ route('admissions.index') }}" class="d-flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, ID or admission #" value="{{ $search }}" style="min-width: 250px;">
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Admission #</th>
                    <th>Patient Details</th>
                    <th>Ward / Bed</th>
                    <th>Admitting Consultant</th>
                    <th>Admission Date</th>
                    <th>Deposit</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $adm)
                    <tr>
                        <td><span class="id-badge">{{ $adm->admission_no }}</span></td>
                        <td>
                            <strong>{{ $adm->patient->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">
                                {{ $adm->patient->patient_id ?? '' }} | 
                                {{ $adm->patient->age ? $adm->patient->age . ' Y,' : '' }} 
                                {{ ucfirst($adm->patient->gender ?? '') }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $adm->ward->name ?? 'Ward' }}</span>
                            <div class="fw-bold text-primary" style="font-size: 0.82rem;">
                                {{ $adm->bed->bed_number ?? 'Bed N/A' }}
                            </div>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $adm->doctor->name ?? 'Unassigned' }}</small><br>
                            <small class="text-muted">{{ $adm->doctor->specialization ?? '' }}</small>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $adm->admission_date ? $adm->admission_date->format('M d, Y') : '' }}</small><br>
                            <small class="text-muted">{{ $adm->admission_date ? $adm->admission_date->format('h:i A') : '' }}</small>
                        </td>
                        <td class="text-success fw-bold">৳ {{ number_format($adm->total_deposit, 2) }}</td>
                        <td>
                            <span class="badge {{ $adm->status == 'admitted' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($adm->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admissions.show', $adm->id) }}" class="action-btn action-btn-view" title="Open Inpatient Chart">
                                    <i class="fa-solid fa-file-waveform"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fa-solid fa-bed-pulse fs-1 mb-2 text-primary opacity-50"></i>
                            <p class="mb-0">No inpatient admissions found matching criteria.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admissions->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $admissions->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
