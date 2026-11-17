@extends('layouts.admin')

@section('title', 'Medication Administration Record (MAR)')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('nursing.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-pills me-2"></i>Medication Administration Record (MAR)</h4>
                <p class="mb-0 text-white-50">Inpatient Clinical Drug Charting & Dose Administration Logging</p>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('nursing.mar') }}" class="d-flex align-items-center gap-2">
            <select name="admission_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 250px;">
                <option value="">-- Choose Inpatient to Chart --</option>
                @foreach($admissions as $adm)
                    <option value="{{ $adm->id }}" {{ $admissionId == $adm->id ? 'selected' : '' }}>
                        {{ $adm->bed->bed_number ?? 'Bed' }} - {{ $adm->patient->name ?? 'Patient' }} ({{ $adm->admission_no }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($selectedAdmission)
    <!-- Selected Patient Banner -->
    <div class="card card-premium shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold mb-1">
                    {{ $selectedAdmission->ward->name ?? 'Ward' }} - {{ $selectedAdmission->bed->bed_number ?? 'Bed' }}
                </span>
                <h4 class="fw-bold mb-0 text-dark">{{ $selectedAdmission->patient->name ?? 'N/A' }}</h4>
                <small class="text-muted">
                    ID: {{ $selectedAdmission->patient->patient_id }} | 
                    Age: {{ $selectedAdmission->patient->age }} Y | 
                    Admitted: {{ $selectedAdmission->admission_date ? $selectedAdmission->admission_date->format('M d, Y') : '' }}
                </small>
            </div>
            <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
                <i class="fa-solid fa-plus-circle me-1"></i> Add Medication Order
            </button>
        </div>
    </div>

    <!-- Active MAR Chart List -->
    <div class="card card-premium shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-capsules text-warning me-2"></i>Prescribed Inpatient Medications</h6>
            <span class="badge bg-warning text-dark">{{ count($medicationCharts) }} Medications Active</span>
        </div>
        <div class="card-body p-4">
            @forelse($medicationCharts as $chart)
                <div class="card border rounded-3 p-3 mb-3 bg-light">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                        <div>
                            <h5 class="fw-bold text-primary mb-1">{{ $chart->medicine_name }}</h5>
                            <div class="text-dark">
                                <span class="badge bg-light text-dark border me-1">{{ $chart->dosage }}</span>
                                <span class="badge bg-light text-dark border me-1">{{ $chart->route }}</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold me-1">{{ $chart->frequency }}</span>
                                <small class="text-muted">Start: {{ $chart->start_date ? $chart->start_date->format('M d') : '' }} | Instructions: {{ $chart->instructions ?: 'As directed' }}</small>
                            </div>
                        </div>

                        <!-- 1-Click Dose Administration Buttons -->
                        <div class="d-flex gap-2">
                            <form action="{{ route('nursing.administer', $chart->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="given">
                                <button type="submit" class="btn btn-sm btn-success fw-bold">
                                    <i class="fa-solid fa-check me-1"></i> Give Dose Now
                                </button>
                            </form>
                            <form action="{{ route('nursing.administer', $chart->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="missed">
                                <button type="submit" class="btn btn-sm btn-outline-warning text-dark">
                                    Missed
                                </button>
                            </form>
                            <form action="{{ route('nursing.administer', $chart->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="refused">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Refused
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Dose Administration History for this medicine -->
                    <div class="border-top pt-2 mt-2">
                        <small class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 0.72rem;">Dose Administration Log:</small>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($chart->administrations->take(8) as $adm)
                                <span class="badge {{ $adm->status == 'given' ? 'bg-success' : 'bg-danger' }} p-2" style="font-size: 0.75rem;">
                                    {{ $adm->administered_at ? $adm->administered_at->format('M d, h:i A') : '' }}
                                    ({{ ucfirst($adm->status) }}) - {{ $adm->administrator->name ?? 'Nurse' }}
                                </span>
                            @empty
                                <span class="text-muted small">No doses administered yet today.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-pills fs-1 mb-2 opacity-50 text-warning"></i>
                    <p class="mb-0">No medications chartered for this patient. Click "Add Medication Order" to start.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal: Add Medication Order -->
    <div class="modal fade" id="addMedicationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('nursing.storeMedication') }}" method="POST">
                    @csrf
                    <input type="hidden" name="admission_id" value="{{ $selectedAdmission->id }}">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title fs-6"><i class="fa-solid fa-plus-circle me-2"></i>Prescribe Inpatient Medication Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                            <input type="text" name="medicine_name" class="form-control" required placeholder="e.g. Inj. Ceftriaxone 1g or Tab. Paracetamol">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label">Dosage <span class="text-danger">*</span></label>
                                <input type="text" name="dosage" class="form-control" required placeholder="e.g. 1g IV or 500mg">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Route <span class="text-danger">*</span></label>
                                <select name="route" class="form-select" required>
                                    <option value="IV (Intravenous)">IV (Intravenous)</option>
                                    <option value="Oral" selected>Oral (PO)</option>
                                    <option value="IM (Intramuscular)">IM (Intramuscular)</option>
                                    <option value="Subcutaneous (SC)">Subcutaneous (SC)</option>
                                    <option value="Inhalation">Inhalation / Nebulization</option>
                                    <option value="Topical">Topical</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Frequency <span class="text-danger">*</span></label>
                                <input type="text" name="frequency" class="form-control" required placeholder="e.g. 1-0-1 or 8 hourly (TDS)">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Instructions / Meal Relation</label>
                            <input type="text" name="instructions" class="form-control" placeholder="e.g. After food or dissolve in 100ml NS">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold">Save to MAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="card card-premium shadow-sm text-center py-5">
        <i class="fa-solid fa-hospital-user fs-1 text-primary opacity-50 mb-3"></i>
        <h5 class="fw-bold">Select an Inpatient to View & Administer Medications</h5>
        <p class="text-muted">Choose an admitted patient from the dropdown above to load their active Medication Administration Record (MAR).</p>
    </div>
@endif
@endsection
