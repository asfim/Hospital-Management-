@extends('layouts.admin')

@section('title', 'Schedule Surgery - OT Department')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('ot.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Operation Theatre Booking</h4>
                <p class="mb-0 text-white-50">Schedule Surgical Procedure, Assign Surgeon Team & Reserve OT Room</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('ot.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-select select2" required>
                            <option value="">-- Choose Patient --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->patient_id }} - {{ $p->name }} ({{ $p->mobile }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Linked Inpatient Admission (Optional)</label>
                        <select name="admission_id" class="form-select">
                            <option value="">-- Not an Inpatient / Standalone Day Surgery --</option>
                            @foreach($admissions as $adm)
                                <option value="{{ $adm->id }}">
                                    {{ $adm->admission_no }} - {{ $adm->patient->name }} ({{ $adm->ward->name }} Bed {{ $adm->bed->bed_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Procedure / Surgery Name <span class="text-danger">*</span></label>
                        <input type="text" name="surgery_name" class="form-control" required placeholder="e.g. Laparoscopic Cholecystectomy or Appendectomy">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Surgery Category <span class="text-danger">*</span></label>
                        <select name="surgery_type" class="form-select" required>
                            <option value="Major" selected>Major Surgery</option>
                            <option value="Minor">Minor Procedure</option>
                            <option value="Emergency">Emergency Surgery</option>
                            <option value="Elective">Elective / Day Case</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">OT Theatre Room <span class="text-danger">*</span></label>
                        <select name="ot_room_id" class="form-select" required>
                            <option value="">-- Choose OT Room --</option>
                            @foreach($rooms as $rm)
                                <option value="{{ $rm->id }}">{{ $rm->name }} ({{ $rm->room_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lead Operating Surgeon <span class="text-danger">*</span></label>
                        <select name="lead_surgeon_id" class="form-select" required>
                            <option value="">-- Choose Lead Surgeon --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">Dr. {{ $doc->name }} ({{ $doc->specialization }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Consultant Anesthesiologist</label>
                        <select name="anesthesiologist_id" class="form-select">
                            <option value="">-- Choose Anesthesiologist --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">Dr. {{ $doc->name }} ({{ $doc->specialization }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Scheduled Start Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="scheduled_start" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime('+1 hour')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Expected End Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="scheduled_end" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime('+3 hours')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Anesthesia Type <span class="text-danger">*</span></label>
                        <select name="anesthesia_type" class="form-select" required>
                            <option value="General Anesthesia" selected>General Anesthesia (GA)</option>
                            <option value="Spinal Anesthesia">Spinal Anesthesia</option>
                            <option value="Epidural Anesthesia">Epidural Anesthesia</option>
                            <option value="Local Anesthesia">Local Anesthesia (LA)</option>
                            <option value="Sedation">Conscious Sedation</option>
                        </select>
                    </div>

                    <!-- Financials -->
                    <div class="col-12 border-top pt-3">
                        <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-coins text-warning me-1"></i>OT & Surgical Fees (৳)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Surgeon Fee (৳)</label>
                                <input type="number" step="0.01" name="surgeon_fee" class="form-control" value="15000.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Anesthesia Fee (৳)</label>
                                <input type="number" step="0.01" name="anesthesia_fee" class="form-control" value="5000.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">OT Room / Equipment Charge (৳)</label>
                                <input type="number" step="0.01" name="ot_room_charge" class="form-control" value="8000.00">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pre-Operative Preparation Notes & Checklist</label>
                        <textarea name="pre_op_notes" class="form-control" rows="2" placeholder="NPO since midnight, blood arranged (2 units PRBC cross-matched), pre-op consent signed..."></textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('ot.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fa-solid fa-calendar-check me-1"></i> Book Surgery
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
