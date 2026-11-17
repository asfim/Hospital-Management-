@extends('layouts.admin')

@section('title', 'Patient Medical Profile - ' . $patient->name)

@section('content')
<!-- Page Header -->
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">{{ $patient->name }}</h4>
                <p class="mb-0 text-white-50">Patient ID: <strong class="text-white">{{ $patient->patient_id }}</strong> | Registered: {{ $patient->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-user-pen me-1"></i> Edit Profile
        </a>
        <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-warning text-dark btn-sm fw-bold shadow-sm">
            <i class="fa-solid fa-calendar-plus me-1"></i> New OPD
        </a>
        <a href="{{ route('admissions.create', ['patient_id' => $patient->id]) }}" class="btn btn-light text-primary btn-sm fw-bold shadow-sm">
            <i class="fa-solid fa-bed-pulse me-1"></i> Admit (IPD)
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Patient Demographics & Clinical Summary Banner -->
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <!-- Patient Info Card -->
        <div class="card card-premium shadow-sm text-center p-4 h-100">
            <div class="position-relative d-inline-block mx-auto mb-3">
                @if($patient->photo)
                    <img src="{{ asset('storage/' . $patient->photo) }}" alt="{{ $patient->name }}" class="rounded-circle shadow" style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #e0e7ff;">
                @else
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto" style="width: 110px; height: 110px; font-size: 2.5rem; font-weight: 700;">
                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                    </div>
                @endif
                <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-danger shadow px-2 py-1" style="font-size: 0.8rem;">
                    {{ $patient->blood_group ?? 'BG N/A' }}
                </span>
            </div>

            <h5 class="fw-bold mb-1">{{ $patient->name }}</h5>
            <span class="id-badge mb-3 d-inline-block">{{ $patient->patient_id }}</span>

            <div class="text-start border-top pt-3 mt-2" style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-venus-mars me-2 text-primary"></i>Gender:</span>
                    <span class="fw-semibold text-capitalize">{{ $patient->gender ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-cake-candles me-2 text-primary"></i>Age:</span>
                    <span class="fw-semibold">{{ $patient->age ? $patient->age . ' Years' : 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-phone me-2 text-primary"></i>Mobile:</span>
                    <span class="fw-semibold">{{ $patient->mobile ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-envelope me-2 text-primary"></i>Email:</span>
                    <span>{{ $patient->email ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-id-card me-2 text-primary"></i>NID:</span>
                    <span>{{ $patient->nid ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted"><i class="fa-solid fa-phone-volume me-2 text-danger"></i>Emergency Contact:</span>
                    <span class="fw-bold text-danger">{{ $patient->emergency_contact ?? 'N/A' }}</span>
                </div>
                <div class="py-1">
                    <span class="text-muted"><i class="fa-solid fa-location-dot me-2 text-primary"></i>Address:</span>
                    <p class="mb-0 text-dark ps-4">{{ $patient->address ?? 'Not provided' }}</p>
                </div>
            </div>

            <!-- Medical Alert / Allergies Box -->
            <div class="mt-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3 text-start">
                <div class="fw-bold text-danger mb-1" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Known Allergies:
                </div>
                <div class="text-dark small">
                    {{ $patient->allergies ?: 'No known drug or food allergies recorded.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Clinical History & Tabbed Details -->
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm h-100">
            <div class="card-header bg-white border-bottom p-0">
                <ul class="nav nav-tabs card-header-tabs m-0 px-3 border-0" id="patientTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active py-3 fw-semibold" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button" role="tab">
                            <i class="fa-solid fa-heart-pulse text-danger me-1"></i> Vitals
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-semibold" id="admissions-tab" data-bs-toggle="tab" data-bs-target="#admissions" type="button" role="tab">
                            <i class="fa-solid fa-bed-pulse text-primary me-1"></i> IPD Admissions ({{ $patient->admissions->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-semibold" id="opd-tab" data-bs-toggle="tab" data-bs-target="#opd" type="button" role="tab">
                            <i class="fa-solid fa-stethoscope text-info me-1"></i> OPD & Visits ({{ $patient->appointments->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-semibold" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button" role="tab">
                            <i class="fa-solid fa-prescription text-success me-1"></i> Prescriptions ({{ $patient->prescriptions->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-semibold" id="lab-tab" data-bs-toggle="tab" data-bs-target="#lab" type="button" role="tab">
                            <i class="fa-solid fa-flask-vial text-warning me-1"></i> Lab & Tests ({{ $patient->diagnosticOrders->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-semibold" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab">
                            <i class="fa-solid fa-file-invoice-dollar text-primary me-1"></i> Invoices ({{ $patient->invoices->count() }})
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 tab-content" id="patientTabsContent">
                <!-- Vitals Tab -->
                <div class="tab-pane fade show active" id="vitals" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-notes-medical text-danger me-2"></i>Patient Vitals History</h6>
                        <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addVitalModal">
                            <i class="fa-solid fa-plus me-1"></i> Record Vitals
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Date & Time</th>
                                    <th>BP (mmHg)</th>
                                    <th>Pulse (bpm)</th>
                                    <th>Temp (°F)</th>
                                    <th>SpO2 (%)</th>
                                    <th>Weight (kg)</th>
                                    <th>BMI</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->vitals as $v)
                                    <tr>
                                        <td><small class="fw-bold">{{ $v->recorded_at ? $v->recorded_at->format('M d, Y h:i A') : 'N/A' }}</small></td>
                                        <td>
                                            @if($v->systolic_bp && $v->diastolic_bp)
                                                <span class="badge bg-light text-dark border">{{ $v->systolic_bp }}/{{ $v->diastolic_bp }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $v->pulse_rate ? $v->pulse_rate . ' bpm' : '-' }}</td>
                                        <td>{{ $v->temperature ? $v->temperature . ' °F' : '-' }}</td>
                                        <td>
                                            @if($v->spo2)
                                                <span class="badge {{ $v->spo2 < 95 ? 'bg-danger' : 'bg-success' }}">{{ $v->spo2 }}%</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $v->weight ? $v->weight . ' kg' : '-' }}</td>
                                        <td>{{ $v->bmi ?? '-' }}</td>
                                        <td><small class="text-muted">{{ $v->notes ?? '-' }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No vital signs recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Admissions Tab -->
                <div class="tab-pane fade" id="admissions" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-hospital-user text-primary me-2"></i>IPD Admission Records</h6>
                        <a href="{{ route('admissions.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary rounded-pill">
                            <i class="fa-solid fa-bed-pulse me-1"></i> New Admission
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Admission No</th>
                                    <th>Ward & Bed</th>
                                    <th>Admitting Doctor</th>
                                    <th>Admitted Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->admissions as $adm)
                                    <tr>
                                        <td><span class="id-badge">{{ $adm->admission_no }}</span></td>
                                        <td>
                                            <strong>{{ $adm->ward->name ?? 'Ward' }}</strong><br>
                                            <small class="text-primary fw-bold">{{ $adm->bed->bed_number ?? 'Bed N/A' }}</small>
                                        </td>
                                        <td>{{ $adm->doctor->name ?? 'N/A' }}</td>
                                        <td>{{ $adm->admission_date ? $adm->admission_date->format('M d, Y h:i A') : '' }}</td>
                                        <td>
                                            <span class="badge {{ $adm->status == 'admitted' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($adm->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admissions.show', $adm->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-file-waveform me-1"></i> Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No IPD admissions recorded for this patient.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- OPD & Appointments Tab -->
                <div class="tab-pane fade" id="opd" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-stethoscope text-info me-2"></i>OPD Appointments & Consultations</h6>
                        <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-info text-white rounded-pill">
                            <i class="fa-solid fa-plus me-1"></i> Book OPD
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Doctor</th>
                                    <th>Date & Time</th>
                                    <th>Fee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->appointments as $apt)
                                    <tr>
                                        <td><span class="id-badge">{{ $apt->appointment_id }}</span></td>
                                        <td>{{ $apt->doctor->name ?? 'N/A' }}</td>
                                        <td>{{ $apt->date }} {{ $apt->time }}</td>
                                        <td>৳ {{ number_format($apt->consultation_fee, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $apt->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $apt->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No appointments recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Prescriptions Tab -->
                <div class="tab-pane fade" id="prescriptions" role="tabpanel">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-prescription-bottle-medical text-success me-2"></i>Medical Prescriptions</h6>
                    @forelse($patient->prescriptions as $rx)
                        <div class="card border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="id-badge me-2">{{ $rx->prescription_id }}</span>
                                    <strong>Dr. {{ $rx->doctor->name ?? 'Attending Doctor' }}</strong>
                                </div>
                                <small class="text-muted">{{ $rx->created_at->format('M d, Y h:i A') }}</small>
                            </div>
                            <div class="p-2 bg-light rounded-2 mb-2">
                                <small class="text-secondary fw-bold">Medicines Prescribed:</small>
                                <ul class="mb-0 mt-1" style="font-size: 0.85rem;">
                                    @foreach($rx->items as $it)
                                        <li><strong>{{ $it->medicine_name }}</strong> - {{ $it->dosage }} | {{ $it->duration }} ({{ $it->instruction }})</li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($rx->advice)
                                <small class="text-muted"><strong>Advice:</strong> {{ $rx->advice }}</small>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No prescriptions recorded.</div>
                    @endforelse
                </div>

                <!-- Lab & Tests Tab -->
                <div class="tab-pane fade" id="lab" role="tabpanel">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-microscope text-warning me-2"></i>Diagnostic Laboratory Orders</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->diagnosticOrders as $order)
                                    <tr>
                                        <td><span class="id-badge">{{ $order->order_id }}</span></td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>৳ {{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $order->payment_status == 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $order->order_status }}</span></td>
                                        <td>
                                            <a href="{{ route('diagnostic-orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye me-1"></i> Order
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No diagnostic orders recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Billing Tab -->
                <div class="tab-pane fade" id="billing" role="tabpanel">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-file-invoice text-primary me-2"></i>Billing & Invoices</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->invoices as $inv)
                                    <tr>
                                        <td><span class="id-badge">{{ $inv->invoice_no }}</span></td>
                                        <td>{{ $inv->date ? $inv->date->format('M d, Y') : '' }}</td>
                                        <td><span class="badge bg-light text-dark border text-uppercase">{{ $inv->invoice_type ?? 'General' }}</span></td>
                                        <td>৳ {{ number_format($inv->total, 2) }}</td>
                                        <td class="text-success fw-bold">৳ {{ number_format($inv->paid, 2) }}</td>
                                        <td class="text-danger fw-bold">৳ {{ number_format($inv->due, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $inv->payment_status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $inv->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('invoices.show', $inv->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No invoices on file.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Record Vitals -->
<div class="modal fade" id="addVitalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('vitals.store') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-heart-pulse me-2"></i>Record Patient Vitals</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Systolic BP (mmHg)</label>
                            <input type="number" name="systolic_bp" class="form-control" placeholder="e.g. 120">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Diastolic BP (mmHg)</label>
                            <input type="number" name="diastolic_bp" class="form-control" placeholder="e.g. 80">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pulse Rate (bpm)</label>
                            <input type="number" name="pulse_rate" class="form-control" placeholder="e.g. 72">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Temperature (°F)</label>
                            <input type="text" name="temperature" class="form-control" placeholder="e.g. 98.6">
                        </div>
                        <div class="col-6">
                            <label class="form-label">SpO2 (%)</label>
                            <input type="number" name="spo2" class="form-control" placeholder="e.g. 98">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" class="form-control" placeholder="e.g. 68.5">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Clinical Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Routine checkup vitals..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save Vitals</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
