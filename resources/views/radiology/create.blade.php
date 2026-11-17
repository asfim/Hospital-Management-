@extends('layouts.admin')

@section('title', 'New Radiology & Imaging Order')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('radiology.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">New Radiology Investigation</h4>
                <p class="mb-0 text-white-50">Create Order for Digital X-Ray, CT Scan, MRI, USG or ECG</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4">
            <form action="{{ route('radiology.store') }}" method="POST">
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
                        <label class="form-label">Referring / Attending Doctor</label>
                        <select name="doctor_id" class="form-select">
                            <option value="">-- Self / Walk-in --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">Dr. {{ $doc->name }} ({{ $doc->specialization }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Investigation Name <span class="text-danger">*</span></label>
                        <input type="text" name="test_name" class="form-control" required placeholder="e.g. Chest X-Ray P/A View or MRI of Brain">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Imaging Modality <span class="text-danger">*</span></label>
                        <select name="modality" class="form-select" required>
                            <option value="Digital X-Ray" selected>Digital X-Ray</option>
                            <option value="Ultrasound (USG)">Ultrasound (USG)</option>
                            <option value="CT Scan">CT Scan (128 Slice)</option>
                            <option value="MRI">3 Tesla MRI</option>
                            <option value="ECG">12-Lead ECG</option>
                            <option value="Echocardiogram">Echocardiogram (Echo)</option>
                            <option value="Endoscopy">Endoscopy</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Charge Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" required placeholder="1200.00">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Link Inpatient (IPD) Admission</label>
                        <select name="admission_id" class="form-select">
                            <option value="">-- Outpatient (OPD) --</option>
                            @foreach($admissions as $adm)
                                <option value="{{ $adm->id }}">
                                    {{ $adm->admission_no }} - {{ $adm->patient->name }} (Bed: {{ $adm->bed->bed_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Clinical Indication / Reason for Scan <span class="text-danger">*</span></label>
                        <textarea name="clinical_indication" class="form-control" rows="2" required placeholder="e.g. Persistent cough with haemoptysis for 3 weeks, evaluate lung fields..."></textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('radiology.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> Generate Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
