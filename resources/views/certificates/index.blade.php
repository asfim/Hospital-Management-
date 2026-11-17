@extends('layouts.admin')

@section('title', 'Vital Records & Medical Certificates')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-stamp me-2 text-primary"></i>Vital Records & Medical Certificates</h4>
        <p class="text-muted mb-0">Official birth registration, cause of death certificates and medical fitness documentation</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#newBirthModal">
            <i class="fa-solid fa-baby me-1"></i> New Birth Record
        </button>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newDeathModal">
            <i class="fa-solid fa-ribbon me-1"></i> New Death Record
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMedicalModal">
            <i class="fa-solid fa-file-waveform me-1"></i> Issue Medical Certificate
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-3 shadow-sm border" id="certTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $tab == 'birth' ? 'active' : '' }} px-4 py-2" id="birth-tab" data-bs-toggle="tab" data-bs-target="#birth" type="button" role="tab">
            <i class="fa-solid fa-baby me-1 text-success"></i> Birth Records ({{ $birthRecords->total() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $tab == 'death' ? 'active' : '' }} px-4 py-2" id="death-tab" data-bs-toggle="tab" data-bs-target="#death" type="button" role="tab">
            <i class="fa-solid fa-ribbon me-1 text-secondary"></i> Death Records ({{ $deathRecords->total() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $tab == 'medical' ? 'active' : '' }} px-4 py-2" id="med-tab" data-bs-toggle="tab" data-bs-target="#med" type="button" role="tab">
            <i class="fa-solid fa-file-medical me-1 text-primary"></i> Medical Fitness / Sick Leave ({{ $medicalCertificates->total() }})
        </button>
    </li>
</ul>

<div class="tab-content" id="certTabsContent">
    <!-- Tab 1: Birth Records -->
    <div class="tab-pane fade {{ $tab == 'birth' ? 'show active' : '' }}" id="birth" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-baby-carriage me-2 text-success"></i>Registered Birth Records
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Certificate No.</th>
                                <th>Baby Name & Gender</th>
                                <th>Date & Time of Birth</th>
                                <th>Weight</th>
                                <th>Parents Details</th>
                                <th>Attending Doctor</th>
                                <th class="text-end">Print Certificate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($birthRecords as $brt)
                                <tr>
                                    <td class="fw-bold text-success">{{ $brt->record_no }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $brt->baby_name ?? 'Infant (Unnamed)' }}</div>
                                        <span class="badge bg-{{ $brt->gender == 'Male' ? 'info' : 'pink' }} bg-opacity-10 text-{{ $brt->gender == 'Male' ? 'primary' : 'danger' }} border">
                                            {{ $brt->gender }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($brt->birth_date)->format('d M, Y') }}</div>
                                        <div class="small text-muted">{{ $brt->birth_time ?? '' }}</div>
                                    </td>
                                    <td>{{ $brt->weight_kg ? $brt->weight_kg . ' kg' : 'N/A' }}</td>
                                    <td>
                                        <div><strong>Mother:</strong> {{ $brt->mother_name }}</div>
                                        @if($brt->father_name)
                                            <div class="small text-muted"><strong>Father:</strong> {{ $brt->father_name }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $brt->doctor->name ?? 'Attending Obstetrician' }}</div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('certificates.print-birth', $brt->id) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fa-solid fa-print me-1"></i> Certificate
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No birth records registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($birthRecords->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $birthRecords->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Death Records -->
    <div class="tab-pane fade {{ $tab == 'death' ? 'show active' : '' }}" id="death" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-ribbon me-2 text-secondary"></i>Hospital Death Registry
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Record No.</th>
                                <th>Patient Name</th>
                                <th>Date & Time of Demise</th>
                                <th>Cause of Death</th>
                                <th>Certifying Doctor</th>
                                <th>Admission Ref</th>
                                <th class="text-end">Certificate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deathRecords as $dth)
                                <tr>
                                    <td class="fw-bold text-secondary">{{ $dth->record_no }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $dth->patient->name ?? 'Patient' }}</div>
                                        <div class="small text-muted">{{ $dth->patient->age ?? '' }} yrs / {{ $dth->patient->gender ?? '' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($dth->death_date)->format('d M, Y') }}</div>
                                        <div class="small text-muted">{{ $dth->death_time ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-danger">{{ $dth->cause_of_death }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $dth->doctor->name ?? 'Certifying Physician' }}</div>
                                    </td>
                                    <td>
                                        @if($dth->admission)
                                            <span class="badge bg-light text-dark border">#{{ $dth->admission->admission_number }}</span>
                                        @else
                                            <span class="text-muted small">OPD / Emergency</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('certificates.print-death', $dth->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-print me-1"></i> Certificate
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No death records on file.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($deathRecords->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $deathRecords->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 3: Medical Fitness Certificates -->
    <div class="tab-pane fade {{ $tab == 'medical' ? 'show active' : '' }}" id="med" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-file-medical me-2 text-primary"></i>Medical & Fitness Certificates
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Certificate No.</th>
                                <th>Patient</th>
                                <th>Certificate Type</th>
                                <th>Diagnosis / Findings</th>
                                <th>Leave / Validity Period</th>
                                <th>Issued By</th>
                                <th class="text-end">Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicalCertificates as $med)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $med->certificate_no }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $med->patient->name ?? 'Patient' }}</div>
                                        <div class="small text-muted">{{ $med->patient->phone ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border">{{ $med->type }}</span>
                                    </td>
                                    <td>{{ $med->diagnosis ?? 'Clinically fit upon physical evaluation' }}</td>
                                    <td>
                                        @if($med->from_date && $med->to_date)
                                            <div>{{ \Carbon\Carbon::parse($med->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($med->to_date)->format('d M, Y') }}</div>
                                        @else
                                            <span class="text-muted">General</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $med->doctor->name ?? 'Authorized Doctor' }}</div>
                                        <div class="small text-muted">{{ $med->doctor->speciality ?? '' }}</div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('certificates.print-medical', $med->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-print me-1"></i> Print
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No medical certificates issued yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($medicalCertificates->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $medicalCertificates->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: New Birth Record -->
<div class="modal fade" id="newBirthModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('certificates.store-birth') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-baby me-2 text-success"></i>Register New Birth</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Baby Name (Optional)</label>
                            <input type="text" name="baby_name" class="form-control" placeholder="Baby of Mrs. ...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Birth Weight (kg)</label>
                            <input type="number" step="0.01" min="0.5" max="10" name="weight_kg" class="form-control" placeholder="e.g. 3.2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="birth_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Time of Birth</label>
                            <input type="time" name="birth_time" class="form-control" value="{{ date('H:i') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mother's Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="mother_name" class="form-control" required placeholder="e.g. Nusrat Jahan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Father's Full Name</label>
                            <input type="text" name="father_name" class="form-control" placeholder="e.g. Mahfuz Rahman">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Attending Doctor / Obstetrician</label>
                            <select name="doctor_id" class="form-select">
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->speciality ?? 'Doctor' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Linked Mother Patient Profile</label>
                            <select name="patient_id" class="form-select">
                                <option value="">-- None / Walk-in --</option>
                                @foreach($patients->where('gender', 'Female') as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Delivery Type / Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="e.g. Normal Spontaneous Vaginal Delivery / Lower Segment Cesarean Section (LSCS)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Birth Record</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Death Record -->
<div class="modal fade" id="newDeathModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('certificates.store-death') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-ribbon me-2 text-secondary"></i>Register Death Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Deceased Patient <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">-- Select Patient --</option>
                                @foreach($patients as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->phone }}) - {{ $pt->age ?? '' }}y/{{ $pt->gender }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Associated Inpatient Admission</label>
                            <select name="admission_id" class="form-select">
                                <option value="">-- None / Emergency / OPD --</option>
                                @foreach($admissions as $adm)
                                    <option value="{{ $adm->id }}">#{{ $adm->admission_number }} - {{ $adm->patient->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Death <span class="text-danger">*</span></label>
                            <input type="date" name="death_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Time of Death</label>
                            <input type="time" name="death_time" class="form-control" value="{{ date('H:i') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Cause of Death (Medical Diagnosis) <span class="text-danger">*</span></label>
                            <input type="text" name="cause_of_death" class="form-control" required placeholder="e.g. Cardiopulmonary arrest secondary to acute myocardial infarction">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Certifying Physician</label>
                            <select name="doctor_id" class="form-select">
                                <option value="">-- Select Physician --</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->speciality ?? 'Doctor' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Remarks / Body Handover Details</label>
                            <input type="text" name="remarks" class="form-control" placeholder="e.g. Body handed over to patient's son">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-secondary">Record Death</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: New Medical Certificate -->
<div class="modal fade" id="newMedicalModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('certificates.store-medical') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-file-medical me-2 text-primary"></i>Issue Medical Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">-- Select Patient --</option>
                                @foreach($patients as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Issuing Doctor <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-select" required>
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->speciality ?? 'Doctor' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Certificate Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="Medical Fitness">Certificate of Medical Fitness</option>
                                <option value="Sick Leave">Sick Leave / Medical Rest Certificate</option>
                                <option value="Medical Exemption">Medical Exemption / Disability Certificate</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Diagnosis / Condition</label>
                            <input type="text" name="diagnosis" class="form-control" placeholder="e.g. Acute Viral Gastroenteritis with Dehydration">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rest / Validity From</label>
                            <input type="date" name="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rest / Validity To</label>
                            <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Clinical Recommendations & Advice</label>
                            <textarea name="recommendations" class="form-control" rows="3" placeholder="e.g. Patient is advised absolute bed rest for 7 days and is unfit for active duty during this period. Fit to resume duties on ..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Issue Certificate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
