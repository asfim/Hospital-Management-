@extends('layouts.admin')

@section('title', 'Author Radiology Report - ' . $order->order_no)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('radiology.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Author Radiology Report: {{ $order->test_name }}</h4>
                <p class="mb-0 text-white-50">Order # <strong class="text-white">{{ $order->order_no }}</strong> | Modality: {{ $order->modality }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Patient & Order Details -->
    <div class="col-lg-4">
        <div class="card card-premium shadow-sm p-4 h-100">
            <h6 class="fw-bold text-dark mb-3">Investigation Information</h6>
            <div style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Patient:</span>
                    <strong>{{ $order->patient->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Patient ID:</span>
                    <span class="id-badge">{{ $order->patient->patient_id ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Age / Gender:</span>
                    <span>{{ $order->patient->age ?? 'N/A' }} Y / {{ ucfirst($order->patient->gender ?? '') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Referring Doctor:</span>
                    <span>Dr. {{ $order->doctor->name ?? 'OPD' }}</span>
                </div>
                <div class="py-2 border-bottom">
                    <span class="text-muted d-block mb-1">Clinical Indication:</span>
                    <p class="mb-0 text-dark fw-semibold">{{ $order->clinical_indication }}</p>
                </div>
            </div>

            @if($order->report && $order->report->image_path)
                <div class="mt-3">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Attached Scan Image</label>
                    <a href="{{ asset('storage/' . $order->report->image_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->report->image_path) }}" class="img-fluid rounded border shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Findings & Impression Editor -->
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4 h-100">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-file-waveform text-primary me-2"></i>Radiologist Findings & Diagnosis</h6>

            <form action="{{ route('radiology.storeReport', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Radiological Findings <span class="text-danger">*</span></label>
                    <textarea name="findings" class="form-control" rows="8" required placeholder="Describe radiological visualization, bony cage, soft tissues, lung fields, cardiac silhouette, diaphragm, costophrenic angles...">{{ $order->report->findings ?? '' }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Impression / Final Diagnosis <span class="text-danger">*</span></label>
                    <textarea name="impression" class="form-control" rows="3" required placeholder="e.g. Findings are suggestive of Left lower lobe consolidation (Pneumonia). No pleural effusion seen.">{{ $order->report->impression ?? '' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload Scan Image / Radiograph (JPG, PNG)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('radiology.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="fa-solid fa-check-circle me-1"></i> Save & Authorize Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
