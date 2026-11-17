@extends('layouts.admin')

@section('title', 'Emergency Patient Intake & Triage')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('emergency.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-truck-medical me-2"></i>Emergency Patient Intake</h4>
                <p class="mb-0 text-white-50">Register Urgent or Critical Inflow & Assign Triage Priority</p>
            </div>
        </div>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('emergency.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <!-- Triage Priority Selection -->
        <div class="col-12">
            <div class="card card-premium shadow-sm border-0 p-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-gauge-high text-danger me-2"></i>Select Triage Priority Code</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="card p-3 border-danger border-2 text-center h-100 cursor-pointer shadow-sm hover-elevate">
                            <input type="radio" name="triage_priority" value="red" class="form-check-input mx-auto mb-2" required>
                            <span class="badge bg-danger text-white py-1 px-2 mb-2 fs-6">🔴 RED</span>
                            <strong class="text-danger">Resuscitation</strong>
                            <small class="text-muted d-block mt-1">Immediate life threat (Cardiac arrest, Severe trauma, Shock)</small>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="card p-3 border-warning border-2 text-center h-100 cursor-pointer shadow-sm hover-elevate">
                            <input type="radio" name="triage_priority" value="orange" class="form-check-input mx-auto mb-2">
                            <span class="badge bg-warning text-dark py-1 px-2 mb-2 fs-6">🟠 ORANGE</span>
                            <strong class="text-dark">Emergent</strong>
                            <small class="text-muted d-block mt-1">Severe pain, acute stroke, respiratory distress (&lt;15 mins)</small>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="card p-3 border-info border-2 text-center h-100 cursor-pointer shadow-sm hover-elevate">
                            <input type="radio" name="triage_priority" value="yellow" class="form-check-input mx-auto mb-2" checked>
                            <span class="badge bg-info text-dark py-1 px-2 mb-2 fs-6">🟡 YELLOW</span>
                            <strong class="text-info">Urgent</strong>
                            <small class="text-muted d-block mt-1">Moderate trauma, fractures, persistent vomiting (&lt;30 mins)</small>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="card p-3 border-success border-2 text-center h-100 cursor-pointer shadow-sm hover-elevate">
                            <input type="radio" name="triage_priority" value="green" class="form-check-input mx-auto mb-2">
                            <span class="badge bg-success text-white py-1 px-2 mb-2 fs-6">🟢 GREEN</span>
                            <strong class="text-success">Non-Urgent</strong>
                            <small class="text-muted d-block mt-1">Minor cut, mild fever, walking wounded (Standard queue)</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patient Demographics -->
        <div class="col-lg-6">
            <div class="card card-premium shadow-sm p-4 h-100">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-injured text-primary me-2"></i>Patient Identification</h6>
                
                <div class="mb-3">
                    <label class="form-label">Existing Patient (If registered)</label>
                    <select name="patient_id" id="patient_select" class="form-select select2">
                        <option value="">-- Or Register New Below --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">{{ $p->patient_id }} - {{ $p->name }} ({{ $p->mobile }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <small class="text-muted fw-bold text-uppercase d-block mb-2">Fast Emergency Registration (If not registered)</small>
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label small">Patient Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="patient_name" class="form-control" placeholder="Full name">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Mobile Number</label>
                            <input type="text" name="patient_mobile" class="form-control" placeholder="017xxxxxxxx">
                        </div>
                        <div class="col-3">
                            <label class="form-label small">Gender</label>
                            <select name="patient_gender" class="form-select">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label small">Age</label>
                            <input type="number" name="patient_age" class="form-control" placeholder="Years">
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Arrival Mode <span class="text-danger">*</span></label>
                        <select name="arrival_mode" class="form-select" required>
                            <option value="Ambulance">Ambulance</option>
                            <option value="Walk-in" selected>Walk-in / Relative</option>
                            <option value="Police">Police Escort</option>
                            <option value="Transfer">Clinic / Hospital Transfer</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Arrival Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="arrival_time" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clinical Complaints & Assignments -->
        <div class="col-lg-6">
            <div class="card card-premium shadow-sm p-4 h-100">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-stethoscope text-danger me-2"></i>Clinical Presentation & Staff</h6>
                
                <div class="mb-3">
                    <label class="form-label">Chief Complaints & Clinical Presentation <span class="text-danger">*</span></label>
                    <textarea name="presenting_complaints" class="form-control" rows="3" required placeholder="e.g. Acute severe chest pain radiating to left arm for 45 mins, diaphoresis, dyspnea..."></textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Attending Emergency Doctor</label>
                        <select name="doctor_id" class="form-select">
                            <option value="">-- Assign Doctor --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->specialization }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Duty Nurse</label>
                        <select name="nurse_id" class="form-select">
                            <option value="">-- Assign Nurse --</option>
                            @foreach($nurses as $nurse)
                                <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Immediate Emergency Treatment Given</label>
                    <textarea name="treatment_given" class="form-control" rows="2" placeholder="e.g. O2 inhalation 4L/min, IV Cannula inserted, Inj. Ceftriaxone given..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Emergency Admission / Treatment Fee (৳)</label>
                    <input type="number" step="0.01" name="treatment_fee" class="form-control" value="500.00">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('emergency.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-danger fw-bold px-4">
                        <i class="fa-solid fa-check me-1"></i> Register Emergency Case
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
