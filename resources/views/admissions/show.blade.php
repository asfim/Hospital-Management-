@extends('layouts.admin')

@section('title', 'Inpatient Master File - ' . $admission->admission_no)

@section('content')
<!-- Page Header with Clinical Actions -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admissions.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-hospital-user me-2"></i>Inpatient File: {{ $admission->admission_no }}</h4>
                <p class="mb-0 text-white-50">
                    Patient: <strong class="text-white">{{ $admission->patient->name ?? 'N/A' }}</strong> ({{ $admission->patient->patient_id ?? '' }}) | 
                    Ward: <strong class="text-white">{{ $admission->ward->name ?? 'Ward' }}</strong> - 
                    Bed: <strong class="text-warning">{{ $admission->bed->bed_number ?? 'Bed N/A' }}</strong>
                </p>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        @if($admission->status === 'admitted')
            <button type="button" class="btn btn-warning text-dark fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#transferBedModal">
                <i class="fa-solid fa-arrows-split-up-and-left me-1"></i> Transfer Bed
            </button>
            <button type="button" class="btn btn-info text-white fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addChargeModal">
                <i class="fa-solid fa-plus-circle me-1"></i> Add Bill Charge
            </button>
            <button type="button" class="btn btn-light text-danger fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#dischargeModal">
                <i class="fa-solid fa-person-walking-arrow-right me-1"></i> Discharge Patient
            </button>
        @else
            <span class="badge bg-secondary fs-6 px-3 py-2 text-uppercase">
                <i class="fa-solid fa-check-circle me-1"></i> Discharged on {{ $admission->discharge_date ? $admission->discharge_date->format('M d, Y') : '' }}
            </span>
            <button onclick="window.print()" class="btn btn-light btn-sm fw-bold">
                <i class="fa-solid fa-print me-1"></i> Print Summary
            </button>
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

<!-- Patient Demographics & Financial Snapshot -->
<div class="row g-4 mb-4">
    <!-- Patient Demographic Card -->
    <div class="col-lg-4">
        <div class="card card-premium shadow-sm p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: 700;">
                    {{ strtoupper(substr($admission->patient->name ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0">{{ $admission->patient->name ?? 'N/A' }}</h5>
                    <span class="id-badge">{{ $admission->patient->patient_id ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="border-top pt-3" style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Age / Gender:</span>
                    <span class="fw-semibold">{{ $admission->patient->age ?? 'N/A' }} Y / {{ ucfirst($admission->patient->gender ?? '') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Blood Group:</span>
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">{{ $admission->patient->blood_group ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Mobile:</span>
                    <span>{{ $admission->patient->mobile ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Emergency Contact:</span>
                    <strong class="text-danger">{{ $admission->patient->emergency_contact ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Admitting Doctor:</span>
                    <strong class="text-primary">{{ $admission->doctor->name ?? 'Unassigned' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Admission Date:</span>
                    <span>{{ $admission->admission_date ? $admission->admission_date->format('M d, Y h:i A') : '' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Days Hospitalized:</span>
                    <span class="fw-bold text-dark">
                        {{ max(1, (int) now()->diffInDays($admission->admission_date) + 1) }} Days
                    </span>
                </div>
            </div>

            @if($admission->patient && $admission->patient->allergies)
                <div class="mt-3 p-2 bg-danger bg-opacity-10 rounded-3 text-start small">
                    <strong class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>Allergies:</strong>
                    <div>{{ $admission->patient->allergies }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Financial Billing Snapshot -->
    <div class="col-lg-8">
        <div class="row g-3 h-100">
            <div class="col-md-4">
                <div class="card card-premium p-4 text-center border-start border-primary border-4 shadow-sm h-100">
                    <span class="text-muted text-uppercase small fw-bold">Total Running Charges</span>
                    <h3 class="fw-bold text-primary mt-2 mb-0">৳ {{ number_format($totalCharges, 2) }}</h3>
                    <small class="text-muted">{{ $admission->dailyCharges->count() }} bill items</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-premium p-4 text-center border-start border-success border-4 shadow-sm h-100">
                    <span class="text-muted text-uppercase small fw-bold">Total Deposit Paid</span>
                    <h3 class="fw-bold text-success mt-2 mb-0">৳ {{ number_format($totalDeposit, 2) }}</h3>
                    <small class="text-success"><i class="fa-solid fa-check-circle me-1"></i>Deposited</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-premium p-4 text-center border-start border-danger border-4 shadow-sm h-100">
                    <span class="text-muted text-uppercase small fw-bold">Current Net Balance</span>
                    <h3 class="fw-bold {{ $balance > 0 ? 'text-danger' : 'text-success' }} mt-2 mb-0">
                        ৳ {{ number_format(abs($balance), 2) }}
                    </h3>
                    <small class="{{ $balance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        {{ $balance > 0 ? 'Amount Payable' : 'Credit / Advance' }}
                    </small>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-premium shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Provisional Diagnosis:</span>
                            <div class="fw-semibold text-dark">{{ $admission->provisional_diagnosis ?: 'Under clinical observation' }}</div>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Ward & Bed:</span>
                            <div class="fw-bold text-primary">{{ $admission->ward->name ?? 'Ward' }} ({{ $admission->bed->bed_number ?? 'Bed' }})</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inpatient Multi-Tab Clinical & Financial Chart -->
<div class="card card-premium shadow-sm">
    <div class="card-header bg-white border-bottom p-0">
        <ul class="nav nav-tabs card-header-tabs m-0 px-3 border-0" id="admissionTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active py-3 fw-semibold" id="charges-tab" data-bs-toggle="tab" data-bs-target="#charges" type="button" role="tab">
                    <i class="fa-solid fa-receipt text-primary me-1"></i> Running Bill & Charges ({{ $admission->dailyCharges->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 fw-semibold" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button" role="tab">
                    <i class="fa-solid fa-heart-pulse text-danger me-1"></i> Inpatient Vitals ({{ $admission->vitals->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 fw-semibold" id="nursing-tab" data-bs-toggle="tab" data-bs-target="#nursing" type="button" role="tab">
                    <i class="fa-solid fa-user-nurse text-info me-1"></i> Nursing Notes ({{ $admission->nursingNotes->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 fw-semibold" id="mar-tab" data-bs-toggle="tab" data-bs-target="#mar" type="button" role="tab">
                    <i class="fa-solid fa-pills text-warning me-1"></i> Medication Chart (MAR)
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 fw-semibold" id="transfers-tab" data-bs-toggle="tab" data-bs-target="#transfers" type="button" role="tab">
                    <i class="fa-solid fa-bed text-secondary me-1"></i> Bed History ({{ $admission->bedTransfers->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 fw-semibold" id="discharge-tab" data-bs-toggle="tab" data-bs-target="#dischargeSummaryTab" type="button" role="tab">
                    <i class="fa-solid fa-file-medical text-success me-1"></i> Discharge Summary
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4 tab-content" id="admissionTabsContent">
        <!-- 1. Running Bill & Charges Tab -->
        <div class="tab-pane fade show active" id="charges" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>Itemized Hospital Bill</h6>
                @if($admission->status === 'admitted')
                    <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addChargeModal">
                        <i class="fa-solid fa-plus me-1"></i> Add Custom Charge
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Charge Date</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th class="text-end">Amount (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admission->dailyCharges as $chg)
                            <tr>
                                <td>{{ $chg->charge_date ? $chg->charge_date->format('M d, Y') : '' }}</td>
                                <td><span class="badge bg-light text-dark border text-uppercase">{{ $chg->charge_type }}</span></td>
                                <td><strong>{{ $chg->description }}</strong></td>
                                <td class="text-end fw-bold text-dark">৳ {{ number_format($chg->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No charges logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Total Billed:</td>
                            <td class="text-end text-primary fs-6">৳ {{ number_format($totalCharges, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Less Total Deposit:</td>
                            <td class="text-end text-success fs-6">- ৳ {{ number_format($totalDeposit, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Net Balance Due:</td>
                            <td class="text-end text-danger fs-5">৳ {{ number_format(max(0, $balance), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- 2. Vitals Tab -->
        <div class="tab-pane fade" id="vitals" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-heart-pulse text-danger me-2"></i>Inpatient Continuous Vitals Chart</h6>
                <button type="button" class="btn btn-sm btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#recordVitalModal">
                    <i class="fa-solid fa-plus me-1"></i> Record Vitals
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Recorded Time</th>
                            <th>BP (mmHg)</th>
                            <th>Pulse</th>
                            <th>Temp (°F)</th>
                            <th>SpO2</th>
                            <th>Weight</th>
                            <th>Recorded By</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admission->vitals as $vital)
                            <tr>
                                <td><small class="fw-bold">{{ $vital->recorded_at ? $vital->recorded_at->format('M d, h:i A') : '' }}</small></td>
                                <td><span class="badge bg-light text-dark border">{{ $vital->systolic_bp }}/{{ $vital->diastolic_bp }}</span></td>
                                <td>{{ $vital->pulse_rate ? $vital->pulse_rate . ' bpm' : '-' }}</td>
                                <td>{{ $vital->temperature ? $vital->temperature . ' °F' : '-' }}</td>
                                <td>
                                    <span class="badge {{ $vital->spo2 < 95 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $vital->spo2 ? $vital->spo2 . '%' : '-' }}
                                    </span>
                                </td>
                                <td>{{ $vital->weight ? $vital->weight . ' kg' : '-' }}</td>
                                <td><small class="text-muted">{{ $vital->recorder->name ?? 'Nurse' }}</small></td>
                                <td><small>{{ $vital->notes ?? '-' }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No vitals charted during this hospitalization yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Nursing Notes Tab -->
        <div class="tab-pane fade" id="nursing" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-user-nurse text-info me-2"></i>Nursing Shift Handover & Care Notes</h6>
                <button type="button" class="btn btn-sm btn-info text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#addNursingNoteModal">
                    <i class="fa-solid fa-plus me-1"></i> Add Nurse Note
                </button>
            </div>

            @forelse($admission->nursingNotes as $nn)
                <div class="card border rounded-3 p-3 mb-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="badge bg-info text-white me-2">{{ $nn->shift }} Shift</span>
                            <span class="badge bg-light text-dark border">{{ $nn->note_type }}</span>
                            <strong class="ms-2">{{ $nn->nurse->name ?? 'Duty Nurse' }}</strong>
                        </div>
                        <small class="text-muted">{{ $nn->recorded_at ? $nn->recorded_at->format('M d, Y h:i A') : '' }}</small>
                    </div>
                    <p class="mb-0 text-dark mt-2" style="font-size: 0.9rem;">{{ $nn->content }}</p>
                </div>
            @empty
                <div class="text-center text-muted py-4">No nursing shift notes recorded yet.</div>
            @endforelse
        </div>

        <!-- 4. Medication Chart (MAR) Tab -->
        <div class="tab-pane fade" id="mar" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-prescription-bottle text-warning me-2"></i>Medication Administration Record (MAR)</h6>
                <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
                    <i class="fa-solid fa-plus me-1"></i> Prescribe Inpatient Med
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage & Route</th>
                            <th>Frequency</th>
                            <th>Start / End Date</th>
                            <th>Instructions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admission->medicationCharts as $med)
                            <tr>
                                <td><strong class="text-dark">{{ $med->medicine_name }}</strong></td>
                                <td>{{ $med->dosage }} (<span class="badge bg-light text-dark border">{{ $med->route }}</span>)</td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $med->frequency }}</span></td>
                                <td><small>{{ $med->start_date ? $med->start_date->format('M d') : '' }} - {{ $med->end_date ? $med->end_date->format('M d') : 'Ongoing' }}</small></td>
                                <td><small class="text-muted">{{ $med->instructions ?? '-' }}</small></td>
                                <td>
                                    <span class="badge {{ $med->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($med->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No inpatient medications active in MAR.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. Bed Transfer History Tab -->
        <div class="tab-pane fade" id="transfers" role="tabpanel">
            <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i>Ward & Bed Relocation History</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th>Transfer Time</th>
                            <th>From Bed</th>
                            <th>To Bed</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admission->bedTransfers as $bt)
                            <tr>
                                <td>{{ $bt->transferred_at ? $bt->transferred_at->format('M d, Y h:i A') : '' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $bt->fromBed->bed_number ?? 'Initial' }}</span></td>
                                <td><span class="badge bg-primary text-white">{{ $bt->toBed->bed_number ?? 'Target' }}</span></td>
                                <td>{{ $bt->reason }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Patient has remained in their initial allocated bed.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 6. Discharge Summary Tab -->
        <div class="tab-pane fade" id="dischargeSummaryTab" role="tabpanel">
            @if($admission->dischargeSummary)
                @php $ds = $admission->dischargeSummary; @endphp
                <div class="p-4 border rounded-3 bg-white" id="printableDischargeSummary">
                    <div class="text-center border-bottom pb-3 mb-4">
                        <h4 class="fw-bold text-dark mb-0">HOSPITAL DISCHARGE SUMMARY</h4>
                        <p class="text-muted mb-0">Clinical Report & Post-Hospitalization Care Plan</p>
                    </div>

                    <div class="row g-3 mb-4 p-3 bg-light rounded-3" style="font-size: 0.9rem;">
                        <div class="col-md-6">
                            <div><strong>Patient Name:</strong> {{ $admission->patient->name }}</div>
                            <div><strong>Patient ID:</strong> {{ $admission->patient->patient_id }}</div>
                            <div><strong>Age / Gender:</strong> {{ $admission->patient->age }} Y / {{ ucfirst($admission->patient->gender) }}</div>
                        </div>
                        <div class="col-md-6">
                            <div><strong>Admission Date:</strong> {{ $admission->admission_date ? $admission->admission_date->format('M d, Y') : '' }}</div>
                            <div><strong>Discharge Date:</strong> {{ $ds->discharge_date ? $ds->discharge_date->format('M d, Y') : '' }}</div>
                            <div><strong>Consultant:</strong> Dr. {{ $admission->doctor->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-primary mb-1">Final Diagnosis</h6>
                        <p class="p-2 border rounded-2 bg-light mb-0">{{ $ds->final_diagnosis }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-primary mb-1">Condition on Discharge</h6>
                        <p class="p-2 border rounded-2 bg-light mb-0"><span class="badge bg-success">{{ $ds->condition_on_discharge }}</span></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-primary mb-1">Treatment Given During Hospitalization</h6>
                        <p class="p-2 border rounded-2 bg-light mb-0">{{ $ds->treatment_given }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold text-primary mb-1">Discharge Medications</h6>
                        <p class="p-2 border rounded-2 bg-light mb-0">{{ $ds->discharge_medications ?: 'None' }}</p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-1">Dietary & Activity Advice</h6>
                            <p class="p-2 border rounded-2 bg-light mb-0">{{ $ds->dietary_advice ?: 'Regular nutritious diet' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-1">Follow-up Instructions</h6>
                            <p class="p-2 border rounded-2 bg-light mb-0">
                                {{ $ds->follow_up_instructions }} 
                                @if($ds->follow_up_date)
                                    <br><strong>Follow-up Date:</strong> {{ $ds->follow_up_date->format('M d, Y') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mt-5 pt-4 text-center">
                        <div class="col-6">
                            <div class="border-top pt-2 d-inline-block px-4">
                                <small class="text-muted">Prepared By / Ward Staff</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-top pt-2 d-inline-block px-4">
                                <strong>Dr. {{ $admission->doctor->name ?? 'Consultant' }}</strong><br>
                                <small class="text-muted">Consultant Physician Signature</small>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-file-waveform fs-1 mb-2 opacity-50"></i>
                    <p class="mb-0">Patient is currently admitted. Discharge summary will be generated upon discharge.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Transfer Bed -->
<div class="modal fade" id="transferBedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admissions.transferBed', $admission->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-arrows-split-up-and-left me-2"></i>Bed Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Current Bed</label>
                        <input type="text" class="form-control" value="{{ $admission->ward->name }} - {{ $admission->bed->bed_number }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Target Bed <span class="text-danger">*</span></label>
                        <select name="new_bed_id" class="form-select" required>
                            <option value="">-- Choose Vacant Bed --</option>
                            @foreach($wards as $w)
                                <optgroup label="{{ $w->name }}">
                                    @foreach($w->availableBeds as $bed)
                                        <option value="{{ $bed->id }}">{{ $bed->bed_number }} (৳ {{ number_format($bed->daily_charge, 2) }}/day)</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Transfer <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="2" required placeholder="e.g. Patient stepped down from ICU to General Ward..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold">Execute Bed Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add Daily Charge -->
<div class="modal fade" id="addChargeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admissions.addDailyCharge', $admission->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-plus-circle me-2"></i>Add Hospital Bill Charge Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Charge Category <span class="text-danger">*</span></label>
                        <select name="charge_type" class="form-select" required>
                            <option value="doctor_round">Doctor Round / Consultation</option>
                            <option value="nursing">Special Nursing Care</option>
                            <option value="equipment">Medical Equipment / Monitor / O2</option>
                            <option value="service">Hospital Service / Procedure</option>
                            <option value="other">Miscellaneous Charge</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Charge Date <span class="text-danger">*</span></label>
                        <input type="date" name="charge_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required placeholder="e.g. Daily Consultant Visit Fee">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" required placeholder="500.00">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Post Charge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Discharge & Summary -->
<div class="modal fade" id="dischargeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admissions.discharge', $admission->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-person-walking-arrow-right me-2"></i>Inpatient Discharge Clearance & Summary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Discharge Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="discharge_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Condition on Discharge <span class="text-danger">*</span></label>
                            <select name="condition_on_discharge" class="form-select" required>
                                <option value="Cured">Cured</option>
                                <option value="Improved" selected>Improved</option>
                                <option value="Unchanged">Unchanged</option>
                                <option value="Transferred">Transferred to Higher Center</option>
                                <option value="DOR">Discharged on Request (DOR)</option>
                                <option value="LAMA">Left Against Medical Advice (LAMA)</option>
                                <option value="Dead">Expired / Deceased</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Final Clinical Diagnosis <span class="text-danger">*</span></label>
                            <textarea name="final_diagnosis" class="form-control" rows="2" required placeholder="e.g. Acute exacerbation of COPD resolved, Type 2 Diabetes Mellitus...">{{ $admission->provisional_diagnosis }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Treatment & Procedures Given During Stay <span class="text-danger">*</span></label>
                            <textarea name="treatment_given" class="form-control" rows="3" required placeholder="IV Antibiotics course, bronchodilators, nebulization, sliding scale insulin..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Discharge Medications</label>
                            <textarea name="discharge_medications" class="form-control" rows="3" placeholder="1. Tab. Cefuroxime 500mg (1-0-1) x 5 days&#10;2. Tab. Pantoprazole 20mg (1-0-1) before meal x 14 days"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dietary & Activity Advice</label>
                            <textarea name="dietary_advice" class="form-control" rows="2" placeholder="Low salt, diabetic diet, gentle walking..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Follow-up Date & Instructions</label>
                            <input type="date" name="follow_up_date" class="form-control mb-2" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                            <input type="text" name="follow_up_instructions" class="form-control" placeholder="Report to OPD Room with RBS and Serum Creatinine">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">Approve & Discharge Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Record Inpatient Vitals -->
<div class="modal fade" id="recordVitalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('vitals.store') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $admission->patient_id }}">
                <input type="hidden" name="admission_id" value="{{ $admission->id }}">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-heart-pulse me-2"></i>Record Inpatient Vitals</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Systolic BP</label>
                            <input type="number" name="systolic_bp" class="form-control" placeholder="120">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Diastolic BP</label>
                            <input type="number" name="diastolic_bp" class="form-control" placeholder="80">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pulse (bpm)</label>
                            <input type="number" name="pulse_rate" class="form-control" placeholder="75">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Temperature (°F)</label>
                            <input type="text" name="temperature" class="form-control" placeholder="98.4">
                        </div>
                        <div class="col-6">
                            <label class="form-label">SpO2 (%)</label>
                            <input type="number" name="spo2" class="form-control" placeholder="98">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" class="form-control" placeholder="70">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Clinical Remarks</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Patient resting comfortably..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Save Vitals</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
