@extends('layouts.admin')

@section('title', 'Emergency Case - ' . $emergency->case_no)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('emergency.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-truck-medical me-2"></i>Emergency Case # {{ $emergency->case_no }}</h4>
                <p class="mb-0 text-white-50">Arrival: {{ $emergency->arrival_time ? $emergency->arrival_time->format('M d, Y h:i A') : '' }} | Mode: {{ $emergency->arrival_mode }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        @if($emergency->status !== 'admitted_ipd' && $emergency->status !== 'discharged')
            <button type="button" class="btn btn-light text-primary fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#transferIpdModal">
                <i class="fa-solid fa-bed-pulse me-1"></i> Transfer to Inpatient (IPD)
            </button>
            <button type="button" class="btn btn-success btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#dischargeErModal">
                <i class="fa-solid fa-person-walking-arrow-right me-1"></i> Discharge from ER
            </button>
        @elseif($emergency->admission)
            <a href="{{ route('admissions.show', $emergency->admission->id) }}" class="btn btn-light text-primary fw-bold btn-sm">
                <i class="fa-solid fa-bed-pulse me-1"></i> View IPD Admission ({{ $emergency->admission->admission_no }})
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <!-- Patient & Triage Summary -->
    <div class="col-lg-4">
        <div class="card card-premium shadow-sm p-4 h-100">
            @php
                $badgeClass = match($emergency->triage_priority) {
                    'red' => 'bg-danger text-white',
                    'orange' => 'bg-warning text-dark',
                    'yellow' => 'bg-info text-dark',
                    'green' => 'bg-success text-white',
                    default => 'bg-secondary text-white'
                };
            @endphp
            <div class="text-center mb-3">
                <span class="badge {{ $badgeClass }} fs-5 px-4 py-2 text-uppercase mb-2 shadow-sm">
                    Priority: {{ $emergency->triage_priority }}
                </span>
                <h5 class="fw-bold mb-1">{{ $emergency->patient->name ?? 'Patient' }}</h5>
                <span class="id-badge">{{ $emergency->patient->patient_id ?? 'N/A' }}</span>
            </div>

            <div class="border-top pt-3" style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Status:</span>
                    <span class="badge bg-light text-dark border">{{ str_replace('_', ' ', $emergency->status) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Age / Gender:</span>
                    <span>{{ $emergency->patient->age ?? 'N/A' }} Y / {{ ucfirst($emergency->patient->gender ?? '') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Blood Group:</span>
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">{{ $emergency->patient->blood_group ?? 'Unknown' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Emergency Contact:</span>
                    <strong class="text-danger">{{ $emergency->patient->emergency_contact ?? $emergency->patient->mobile }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Doctor:</span>
                    <span>{{ $emergency->doctor->name ?? 'Unassigned' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Nurse:</span>
                    <span>{{ $emergency->nurse->name ?? 'Unassigned' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Treatment Fee:</span>
                    <strong class="text-success">৳ {{ number_format($emergency->treatment_fee, 2) }}</strong>
                </div>
            </div>

            @if($emergency->patient && $emergency->patient->allergies)
                <div class="mt-3 p-3 bg-danger bg-opacity-10 rounded-3 text-start">
                    <strong class="text-danger small"><i class="fa-solid fa-triangle-exclamation me-1"></i>Allergies:</strong>
                    <div class="small text-dark">{{ $emergency->patient->allergies }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Clinical Management & Treatment -->
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4 h-100">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-notes-medical text-primary me-2"></i>Emergency Clinical Notes</h6>

            <div class="p-3 bg-light rounded-3 mb-3 border">
                <label class="text-muted small fw-bold text-uppercase">Presenting Complaints</label>
                <p class="mb-0 fw-semibold text-dark">{{ $emergency->presenting_complaints }}</p>
            </div>

            <form action="{{ route('emergency.update', $emergency->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Emergency Treatment Administered</label>
                    <textarea name="treatment_given" class="form-control" rows="4" placeholder="Document emergency medications, fluids, defibrillation, wound dressing, or interventions...">{{ $emergency->treatment_given }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Update Triage Priority</label>
                        <select name="triage_priority" class="form-select">
                            <option value="red" {{ $emergency->triage_priority == 'red' ? 'selected' : '' }}>🔴 Red (Resuscitation)</option>
                            <option value="orange" {{ $emergency->triage_priority == 'orange' ? 'selected' : '' }}>🟠 Orange (Emergent)</option>
                            <option value="yellow" {{ $emergency->triage_priority == 'yellow' ? 'selected' : '' }}>🟡 Yellow (Urgent)</option>
                            <option value="green" {{ $emergency->triage_priority == 'green' ? 'selected' : '' }}>🟢 Green (Non-Urgent)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Clinical Care Status</label>
                        <select name="status" class="form-select">
                            <option value="triaged" {{ $emergency->status == 'triaged' ? 'selected' : '' }}>Triaged (Awaiting Care)</option>
                            <option value="under_treatment" {{ $emergency->status == 'under_treatment' ? 'selected' : '' }}>Under Active Treatment</option>
                            <option value="discharged" {{ $emergency->status == 'discharged' ? 'selected' : '' }}>Discharged</option>
                            <option value="transferred" {{ $emergency->status == 'transferred' ? 'selected' : '' }}>Transferred to Other Facility</option>
                            <option value="deceased" {{ $emergency->status == 'deceased' ? 'selected' : '' }}>Deceased in ER</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Emergency Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Transfer to IPD -->
<div class="modal fade" id="transferIpdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('emergency.transferToIpd', $emergency->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-bed-pulse me-2"></i>Direct Admission: Transfer ER to IPD Ward</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Select Ward <span class="text-danger">*</span></label>
                            <select name="ward_id" id="wardSelect" class="form-select" required onchange="filterBeds(this.value)">
                                <option value="">-- Choose Ward --</option>
                                @foreach($wards as $w)
                                    <option value="{{ $w->id }}">{{ $w->name }} ({{ $w->type }}) - {{ $w->availableBeds->count() }} Available</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Select Available Bed <span class="text-danger">*</span></label>
                            <select name="bed_id" id="bedSelect" class="form-select" required>
                                <option value="">-- Select Ward First --</option>
                                @foreach($wards as $w)
                                    @foreach($w->availableBeds as $bed)
                                        <option value="{{ $bed->id }}" data-ward="{{ $w->id }}">
                                            {{ $bed->bed_number }} (৳ {{ number_format($bed->daily_charge, 2) }}/day)
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Admitting Consultant</label>
                            <select name="doctor_id" class="form-select">
                                <option value="{{ $emergency->doctor_id }}">{{ $emergency->doctor->name ?? 'Same as ER Doctor' }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Initial Admission Deposit (৳)</label>
                            <input type="number" step="0.01" name="deposit_amount" class="form-control" value="2000.00">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Reason for Inpatient Admission <span class="text-danger">*</span></label>
                            <textarea name="admission_reason" class="form-control" rows="2" required placeholder="e.g. Requires ICU hemodynamic monitoring and intravenous therapy...">{{ $emergency->presenting_complaints }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Confirm IPD Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Discharge from ER -->
<div class="modal fade" id="dischargeErModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('emergency.update', $emergency->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="discharged">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-person-walking-arrow-right me-2"></i>Discharge Emergency Patient</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Discharge Instructions & Summary</label>
                        <textarea name="discharge_notes" class="form-control" rows="3" required placeholder="Condition stable, vitals normal, prescribed oral medications, advised to visit OPD if symptoms recur..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm fw-bold">Approve ER Discharge</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterBeds(wardId) {
        const bedSelect = document.getElementById('bedSelect');
        const options = bedSelect.querySelectorAll('option[data-ward]');
        let count = 0;
        options.forEach(opt => {
            if (!wardId || opt.getAttribute('data-ward') === wardId) {
                opt.style.display = '';
                if (count === 0) opt.selected = true;
                count++;
            } else {
                opt.style.display = 'none';
            }
        });
    }
</script>
@endpush
