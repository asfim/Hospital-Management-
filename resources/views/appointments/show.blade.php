@extends('layouts.admin')

@section('title', 'Appointment Details - ' . $appointment->appointment_id)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Appointment # {{ $appointment->appointment_id }}</h4>
                <p class="mb-0 text-white-50">Token: <strong>#{{ $appointment->token ?? $appointment->id }}</strong> | Date: {{ $appointment->date }} at {{ $appointment->time }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-premium-new btn-sm">
            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Appointment
        </a>
        <button onclick="window.print()" class="btn btn-light btn-sm fw-bold">
            <i class="fa-solid fa-print me-1"></i> Print Token
        </button>
    </div>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">OPD Consultation Token</h5>
                    <span class="id-badge fs-6">{{ $appointment->appointment_id }}</span>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-5 px-3 py-2">Token #{{ $appointment->token ?? $appointment->id }}</span>
                    <div class="mt-1">
                        <span class="badge {{ $appointment->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $appointment->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4" style="font-size: 0.95rem;">
                <div class="col-md-6">
                    <label class="text-muted fw-bold">Patient Details</label>
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="fw-bold mb-1">{{ $appointment->patient->name ?? 'N/A' }}</h6>
                        <div>Patient ID: <span class="id-badge">{{ $appointment->patient->patient_id ?? 'N/A' }}</span></div>
                        <div>Mobile: {{ $appointment->patient->mobile ?? 'N/A' }}</div>
                        <div>Age / Gender: {{ $appointment->patient->age ?? 'N/A' }} Y / {{ ucfirst($appointment->patient->gender ?? 'N/A') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted fw-bold">Doctor Details</label>
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="fw-bold mb-1">{{ $appointment->doctor->name ?? 'N/A' }}</h6>
                        <div>Specialization: <span class="text-primary fw-semibold">{{ $appointment->doctor->specialization ?? 'General' }}</span></div>
                        <div>Room: <strong>{{ $appointment->doctor->room_no ?? 'OPD Room' }}</strong></div>
                        <div>Consultation Fee: ৳ {{ number_format($appointment->consultation_fee, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 mb-4">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Consultation Fee:</span>
                    <strong>৳ {{ number_format($appointment->consultation_fee, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Discount:</span>
                    <span class="text-danger">- ৳ {{ number_format($appointment->discount ?? 0, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Paid Amount:</span>
                    <strong class="text-success">৳ {{ number_format($appointment->paid, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span>Due Balance:</span>
                    <strong class="{{ $appointment->due > 0 ? 'text-danger' : 'text-muted' }}">৳ {{ number_format($appointment->due ?? 0, 2) }}</strong>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Appointments
                </a>
                @if($appointment->status != 'Completed')
                    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-check-circle me-1"></i> Mark as Completed
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
