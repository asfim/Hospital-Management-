@extends('layouts.admin')

@section('title', 'Patient Registry & Records')

@section('content')

{{-- Standardized Hospital Page Header --}}
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-pill mb-2" style="background: rgba(13, 148, 136, 0.25); border: 1px solid rgba(45, 212, 191, 0.35);">
            <span style="width: 8px; height: 8px; background: #2dd4bf; border-radius: 50%; display: inline-block;"></span>
            <span style="font-size: 0.74rem; font-weight: 700; color: #2dd4bf; text-transform: uppercase; letter-spacing: 0.5px;">Master Patient Index</span>
        </div>
        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-users me-2" style="color: #2dd4bf;"></i>Hospital Patient Registry</h4>
        <p class="mb-0 text-white-50">Manage electronic medical records, emergency contacts, vital profiles & clinical histories</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('patients.create') }}" class="btn btn-erp-teal shadow-sm">
            <i class="fa-solid fa-user-plus me-1.5"></i> Register New Patient
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert" style="background-color: var(--erp-success-bg); color: var(--erp-success);">
        <i class="fa-solid fa-circle-check fs-5 me-2"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Search & Filter Card -->
<div class="erp-card mb-4">
    <div class="p-3">
        <form action="{{ route('patients.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="position-relative">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="erp-form-control ps-5" placeholder="Search by name, patient ID, or mobile number...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="gender" class="erp-form-select" onchange="this.form.submit()">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-erp-primary w-100">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
            </div>
            @if(request('search') || request('gender'))
                <div class="col-md-2">
                    <a href="{{ route('patients.index') }}" class="btn btn-erp-outline w-100">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Patients Data Table Card -->
<div class="erp-card">
    <div class="erp-card-header">
        <h6 class="card-title">
            <i class="fa-solid fa-address-book text-teal me-2" style="color: var(--erp-secondary);"></i>
            Registered Patients <span class="badge bg-light text-secondary border ms-2">{{ $patients->total() }}</span>
        </h6>
    </div>

    <div class="table-responsive">
        <table class="erp-table align-middle">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Info</th>
                    <th>Contact</th>
                    <th>Age / Gender</th>
                    <th>Blood Group</th>
                    <th>Registered</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>
                        <span class="erp-badge-id">{{ $patient->patient_id }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2.5">
                            @if(!empty($patient->photo))
                                <img src="{{ asset('storage/' . $patient->photo) }}" alt="{{ $patient->name }}" class="rounded-circle object-fit-cover shadow-sm border border-2 border-teal" style="width: 38px; height: 38px; border-color: var(--erp-secondary) !important;">
                            @else
                                <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, var(--erp-primary), #2563eb); font-size: 0.85rem;">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('patients.show', $patient->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                    {{ $patient->name }}
                                </a>
                                @if(!empty($patient->emergency_contact))
                                    <div class="text-muted small" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-phone-volume text-danger me-1"></i>{{ $patient->emergency_contact }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-medium text-dark">{{ $patient->mobile ?? $patient->phone ?? 'N/A' }}</span>
                        @if($patient->email)
                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $patient->email }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $patient->age ? $patient->age . ' yrs' : 'N/A' }}</span>
                        <div>
                            @if(strtolower($patient->gender) == 'male')
                                <span class="erp-badge erp-badge-teal"><i class="fa-solid fa-mars"></i> Male</span>
                            @elseif(strtolower($patient->gender) == 'female')
                                <span class="erp-badge" style="background: #fce7f3; color: #db2777; border: 1px solid rgba(219, 39, 119, 0.25);"><i class="fa-solid fa-venus"></i> Female</span>
                            @else
                                <span class="erp-badge erp-badge-teal">{{ ucfirst($patient->gender ?? 'Other') }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($patient->blood_group)
                            <span class="erp-badge erp-badge-danger fw-bold">{{ $patient->blood_group }}</span>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">{{ $patient->created_at ? $patient->created_at->format('M d, Y') : '-' }}</small>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center gap-1.5">
                            <a href="{{ route('patients.show', $patient->id) }}" class="erp-action-btn" title="View Patient Profile & Clinical Chart">
                                <i class="fa-solid fa-id-card text-teal" style="color: var(--erp-secondary);"></i>
                            </a>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="erp-action-btn btn-edit" title="Edit Patient Record">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient profile?');" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="erp-action-btn btn-delete border-0" title="Delete Patient Record">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fa-solid fa-user-injured"></i>
                            <h6 class="fw-bold text-dark mt-2">No patients found</h6>
                            <p class="text-muted small mb-3">No patient records match your search criteria.</p>
                            <a href="{{ route('patients.create') }}" class="btn btn-erp-teal btn-sm">
                                <i class="fa-solid fa-plus me-1"></i> Register New Patient
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($patients->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients</small>
            <div>{{ $patients->links() }}</div>
        </div>
    @endif
</div>
@endsection
