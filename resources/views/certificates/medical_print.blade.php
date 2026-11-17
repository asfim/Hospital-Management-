<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Certificate - {{ $certificate->certificate_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, sans-serif; color: #1e293b; }
        .cert-container { max-width: 850px; margin: 30px auto; background: #fff; padding: 50px 60px; border-radius: 8px; border: 4px solid #2563eb; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; }
        .hospital-header { border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; }
        .cert-heading { font-size: 1.8rem; font-weight: 700; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
        .cert-body { font-size: 1.15rem; line-height: 2.2; margin-top: 25px; text-align: justify; }
        .cert-fill { font-weight: bold; color: #0f172a; border-bottom: 1px dotted #334155; padding: 0 6px; }
        @media print {
            body { background: #fff; }
            .cert-container { margin: 0; box-shadow: none; max-width: 100%; border: 3px solid #2563eb; padding: 35px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="text-center my-3 no-print">
    <button onclick="window.print()" class="btn btn-primary px-4 py-2 fw-semibold">
        <i class="fa-solid fa-print me-2"></i> Print Medical Certificate
    </button>
    <button onclick="window.close()" class="btn btn-outline-secondary px-4 py-2 ms-2">
        <i class="fa-solid fa-xmark me-2"></i> Close
    </button>
</div>

<div class="cert-container">
    <div class="hospital-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1" style="color: #0f172a;">
                <i class="fa-solid fa-hospital-user text-primary me-2"></i>DHAKA CENTRAL HOSPITAL
            </h3>
            <p class="text-muted small mb-0">House 12, Road 5, Dhanmondi, Dhaka-1205 | Tel: +880 2-9660000</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6 px-3 py-2 text-uppercase">{{ $certificate->type }}</span>
            <div class="small text-muted mt-1">Ref: <strong>{{ $certificate->certificate_no }}</strong></div>
            <div class="small text-muted">Date: {{ \Carbon\Carbon::parse($certificate->created_at)->format('d F, Y') }}</div>
        </div>
    </div>

    <div class="text-center">
        <div class="cert-heading">{{ strtoupper($certificate->type) }}</div>
        <div class="text-muted small">TO WHOM IT MAY CONCERN</div>
    </div>

    <div class="cert-body">
        This is to certify that Mr./Ms. <span class="cert-fill">{{ $certificate->patient->name ?? 'Patient' }}</span>, 
        aged <span class="cert-fill">{{ $certificate->patient->age ?? 'N/A' }} years</span>, 
        gender <span class="cert-fill">{{ $certificate->patient->gender ?? 'N/A' }}</span>, 
        bearing Contact No. <span class="cert-fill">{{ $certificate->patient->phone ?? 'N/A' }}</span>, 
        has been under my direct medical consultation and clinical evaluation at this healthcare facility.
        <br><br>
        <strong>Clinical Diagnosis / Finding:</strong><br>
        <div class="p-3 my-2 bg-light border rounded fw-semibold text-dark">
            {{ $certificate->diagnosis ?? 'Patient was examined and found medically evaluated with normal systemic findings.' }}
        </div>

        @if($certificate->from_date && $certificate->to_date)
            <strong>Period of Recommended Rest / Validity:</strong><br>
            The patient is advised medical rest from 
            <span class="cert-fill">{{ \Carbon\Carbon::parse($certificate->from_date)->format('d F, Y') }}</span> 
            to 
            <span class="cert-fill">{{ \Carbon\Carbon::parse($certificate->to_date)->format('d F, Y') }}</span> 
            inclusive.
            <br><br>
        @endif

        @if($certificate->recommendations)
            <strong>Doctor's Advice & Clinical Recommendation:</strong><br>
            <div class="p-3 my-2 bg-light border rounded text-dark">
                {{ $certificate->recommendations }}
            </div>
        @endif
    </div>

    <div class="row pt-5 mt-5 text-center">
        <div class="col-6 text-start">
            <div class="border-top border-dark pt-2 d-inline-block px-4">
                <div class="fw-bold text-dark">Hospital Superintendent Seal</div>
                <small class="text-muted">Dhaka Central Hospital</small>
            </div>
        </div>
        <div class="col-6 text-end">
            <div class="border-top border-dark pt-2 d-inline-block px-4 text-center">
                <div class="fw-bold text-dark">{{ $certificate->doctor->name ?? 'Consultant Physician' }}</div>
                <div class="small text-muted">{{ $certificate->doctor->speciality ?? 'Specialist Practitioner' }}</div>
                <small class="text-muted">BMDC Reg. Verified Doctor</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
