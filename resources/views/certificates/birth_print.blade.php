<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Certificate - {{ $record->record_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Georgia', serif; color: #1e293b; }
        .cert-container { max-width: 850px; margin: 30px auto; background: #fff; padding: 50px 60px; border-radius: 8px; border: 8px double #0d9488; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; }
        .hospital-title { font-family: 'Segoe UI', Tahoma, sans-serif; color: #0f172a; font-weight: 800; letter-spacing: 1px; }
        .cert-heading { font-size: 2.2rem; font-weight: 700; color: #0d9488; text-transform: uppercase; letter-spacing: 2px; margin: 25px 0 10px 0; border-bottom: 2px solid #0d9488; display: inline-block; padding-bottom: 5px; }
        .cert-body { font-size: 1.15rem; line-height: 2.2; margin-top: 30px; text-align: justify; }
        .cert-fill { font-weight: bold; color: #0f172a; border-bottom: 1px dotted #334155; padding: 0 8px; font-family: 'Segoe UI', sans-serif; }
        @media print {
            body { background: #fff; }
            .cert-container { margin: 0; box-shadow: none; max-width: 100%; border: 6px double #0d9488; padding: 40px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="text-center my-3 no-print">
    <button onclick="window.print()" class="btn btn-success px-4 py-2 fw-semibold">
        <i class="fa-solid fa-print me-2"></i> Print Birth Certificate
    </button>
    <button onclick="window.close()" class="btn btn-outline-secondary px-4 py-2 ms-2">
        <i class="fa-solid fa-xmark me-2"></i> Close
    </button>
</div>

<div class="cert-container text-center">
    <div>
        <h2 class="hospital-title mb-1"><i class="fa-solid fa-hospital text-teal me-2" style="color: #0d9488;"></i>DHAKA CENTRAL HOSPITAL</h2>
        <p class="text-muted small mb-0 font-sans" style="font-family: sans-serif;">Dhanmondi, Dhaka, Bangladesh | Department of Obstetrics & Gynecology</p>
    </div>

    <div class="text-center">
        <div class="cert-heading">Certificate of Live Birth</div>
        <div class="small text-muted font-sans" style="font-family: sans-serif;">Official Registry Ref: <strong>{{ $record->record_no }}</strong></div>
    </div>

    <div class="cert-body">
        This is to officially certify that a live infant <span class="cert-fill">{{ $record->gender == 'Male' ? 'Boy' : 'Girl' }}</span> named 
        <span class="cert-fill">{{ $record->baby_name ?? 'Infant' }}</span> was safely delivered at this hospital on 
        <span class="cert-fill">{{ \Carbon\Carbon::parse($record->birth_date)->format('F j, Y') }}</span> 
        @if($record->birth_time)
            at <span class="cert-fill">{{ date('h:i A', strtotime($record->birth_time)) }}</span>
        @endif
        . The birth weight recorded was <span class="cert-fill">{{ $record->weight_kg ? $record->weight_kg . ' kg' : 'N/A' }}</span>.
        <br><br>
        The child was born to Mother <span class="cert-fill">{{ $record->mother_name }}</span> 
        @if($record->father_name)
            and Father <span class="cert-fill">{{ $record->father_name }}</span>
        @endif
        . The delivery procedure was conducted and supervised under sterile medical conditions.
        @if($record->remarks)
            <br>
            <span class="small text-muted" style="font-family: sans-serif;">Delivery Notes: {{ $record->remarks }}</span>
        @endif
    </div>

    <div class="row pt-5 mt-5 text-center font-sans" style="font-family: sans-serif;">
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <div class="fw-bold text-dark">{{ $record->doctor->name ?? 'Attending Obstetrician' }}</div>
                <small class="text-muted">Obstetrician & Gynecologist</small>
            </div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <div class="fw-bold text-dark">Hospital Medical Seal</div>
                <small class="text-muted">Official Seal</small>
            </div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <div class="fw-bold text-dark">Medical Superintendent</div>
                <small class="text-muted">Director of Hospital</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
