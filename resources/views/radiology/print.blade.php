@extends('layouts.admin')

@section('title', 'Radiology Report - ' . $order->order_no)

@section('content')
<div class="d-print-none mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('radiology.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Radiology List
    </a>
    <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold">
        <i class="fa-solid fa-print me-1"></i> Print A4 Report
    </button>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card p-5 shadow-sm border bg-white" style="font-family: 'Inter', sans-serif;">
            <!-- Hospital Header -->
            <div class="text-center border-bottom pb-4 mb-4">
                <h3 class="fw-bold mb-1 text-primary">{{ config('app.name', 'Central Hospital & Medical Center') }}</h3>
                <h5 class="text-dark fw-bold mb-0">DEPARTMENT OF RADIOLOGY & IMAGING</h5>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Digital PACS & Diagnostic Imaging Division</p>
                <small class="text-muted">123 Health Avenue, Dhaka, Bangladesh | Tel: +880 1711 000 000</small>
            </div>

            <!-- Patient Info Bar -->
            <div class="p-3 bg-light rounded-3 border mb-4" style="font-size: 0.9rem;">
                <div class="row g-2">
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Patient Name:</span> <strong class="text-dark">{{ $order->patient->name }}</strong>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Patient ID:</span> <span class="id-badge">{{ $order->patient->patient_id }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Age / Sex:</span> <strong>{{ $order->patient->age }} Y / {{ ucfirst($order->patient->gender) }}</strong>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Order #:</span> <strong>{{ $order->order_no }}</strong>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Date:</span> <strong>{{ $order->created_at->format('d M, Y') }}</strong>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="text-muted">Ref. Doctor:</span> <strong>Dr. {{ $order->doctor->name ?? 'OPD' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Investigation Title -->
            <div class="text-center my-3">
                <h5 class="fw-bold text-decoration-underline text-uppercase text-dark">{{ $order->test_name }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $order->modality }}</span>
            </div>

            <!-- Clinical Indication -->
            <div class="mb-4">
                <strong class="text-muted text-uppercase small">Clinical Indication:</strong>
                <p class="mb-0 text-dark">{{ $order->clinical_indication }}</p>
            </div>

            <!-- Findings -->
            <div class="mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-1">FINDINGS:</h6>
                <div style="white-space: pre-line; line-height: 1.8; font-size: 0.95rem; color: #1e293b;">
                    {{ $order->report->findings ?? 'Report pending.' }}
                </div>
            </div>

            <!-- Attached Image if available -->
            @if($order->report && $order->report->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $order->report->image_path) }}" alt="Radiograph" style="max-height: 300px; max-width: 100%; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>
            @endif

            <!-- Impression -->
            <div class="p-3 bg-light rounded-3 border mb-5">
                <h6 class="fw-bold text-primary mb-1">IMPRESSION:</h6>
                <p class="mb-0 fw-bold text-dark" style="font-size: 1rem;">
                    {{ $order->report->impression ?? 'No impression entered.' }}
                </p>
            </div>

            <!-- Signatures -->
            <div class="row mt-5 pt-5 text-center">
                <div class="col-6">
                    <div class="border-top pt-2 d-inline-block px-4">
                        <small class="text-muted">Radiology Technologist</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-top pt-2 d-inline-block px-4">
                        <strong>{{ $order->report->radiologist->name ?? 'Consultant Radiologist' }}</strong><br>
                        <small class="text-muted">MBBS, FCPS / MD (Radiology & Imaging)</small><br>
                        <small class="text-muted">Consultant Radiologist</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
