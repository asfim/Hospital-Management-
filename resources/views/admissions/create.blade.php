@extends('layouts.admin')

@section('title', 'Inpatient (IPD) Admission Registration')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admissions.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Patient Admission Form (IPD)</h4>
                <p class="mb-0 text-white-50">Inpatient Hospitalization, Bed Allocation & Initial Deposit</p>
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

<form action="{{ route('admissions.store') }}" method="POST">
    @csrf
    <div class="row g-4 justify-content-center">
        <!-- Patient & Doctor Details -->
        <div class="col-lg-6">
            <div class="card card-premium shadow-sm p-4 h-100">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-injured text-primary me-2"></i>Patient & Doctor Information</h6>

                <div class="mb-3">
                    <label class="form-label">Select Patient <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select select2" required>
                        <option value="">-- Choose Registered Patient --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ (old('patient_id', $patientId) == $p->id) ? 'selected' : '' }}>
                                {{ $p->patient_id }} - {{ $p->name }} ({{ $p->mobile }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Not registered? <a href="{{ route('patients.create') }}" target="_blank">Register patient first</a></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admitting Consultant Doctor <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">-- Choose Admitting Doctor --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                                {{ $doc->name }} ({{ $doc->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Referring Doctor / Clinic (Optional)</label>
                    <input type="text" name="referred_by" class="form-control" placeholder="Referred by Dr. Name or Hospital">
                </div>

                <div class="mb-3">
                    <label class="form-label">Admission Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="admission_date" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reason for Hospitalization <span class="text-danger">*</span></label>
                    <textarea name="admission_reason" class="form-control" rows="2" required placeholder="e.g. Acute severe pneumonia with respiratory distress..."></textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label">Provisional Diagnosis</label>
                    <textarea name="provisional_diagnosis" class="form-control" rows="2" placeholder="e.g. Community Acquired Pneumonia (Severe)"></textarea>
                </div>
            </div>
        </div>

        <!-- Bed Allocation & Financial Deposit -->
        <div class="col-lg-6">
            <div class="card card-premium shadow-sm p-4 h-100">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-bed text-primary me-2"></i>Ward & Bed Allocation</h6>

                <div class="mb-3">
                    <label class="form-label">Select Ward <span class="text-danger">*</span></label>
                    <select name="ward_id" id="wardSelect" class="form-select" required onchange="filterBeds(this.value)">
                        <option value="">-- Choose Ward --</option>
                        @foreach($wards as $w)
                            <option value="{{ $w->id }}" {{ old('ward_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->name }} ({{ $w->type }}) - {{ $w->availableBeds->count() }} Available (৳{{ number_format($w->daily_charge, 2) }}/day)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Select Available Bed <span class="text-danger">*</span></label>
                    <select name="bed_id" id="bedSelect" class="form-select" required>
                        <option value="">-- Select Ward First --</option>
                        @foreach($wards as $w)
                            @foreach($w->availableBeds as $bed)
                                <option value="{{ $bed->id }}" data-ward="{{ $w->id }}" {{ old('bed_id') == $bed->id ? 'selected' : '' }}>
                                    {{ $bed->bed_number }} (৳ {{ number_format($bed->daily_charge, 2) }}/day)
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i>Only clean and vacant beds are listed.</small>
                </div>

                <h6 class="fw-bold text-dark mb-3 border-top pt-3"><i class="fa-solid fa-receipt text-success me-2"></i>Initial Admission Deposit</h6>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Deposit Amount (৳)</label>
                        <input type="number" step="0.01" name="deposit_amount" class="form-control" value="3000.00">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="Cash">Cash</option>
                            <option value="Card">Credit / Debit Card</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Bank">Bank Deposit</option>
                        </select>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 mb-4 text-muted small">
                    <i class="fa-solid fa-shield-check text-success me-1"></i>
                    An official admission invoice and deposit voucher will be generated automatically.
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admissions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="fa-solid fa-check me-1"></i> Confirm Admission
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
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
    document.addEventListener('DOMContentLoaded', function() {
        const initialWard = document.getElementById('wardSelect').value;
        if (initialWard) filterBeds(initialWard);
    });
</script>
@endpush
