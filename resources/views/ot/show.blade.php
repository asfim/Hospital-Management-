@extends('layouts.admin')

@section('title', 'Surgical Operation File - ' . $ot->surgery_no)

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('ot.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-syringe me-2"></i>{{ $ot->surgery_name }}</h4>
                <p class="mb-0 text-white-50">Operation # <strong class="text-white">{{ $ot->surgery_no }}</strong> | Room: {{ $ot->room->name ?? 'OT' }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-light btn-sm fw-bold">
            <i class="fa-solid fa-print me-1"></i> Print OT Notes
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <!-- Patient & Team Summary -->
    <div class="col-lg-4">
        <div class="card card-premium shadow-sm p-4 h-100">
            @php
                $sBadge = match($ot->status) {
                    'scheduled' => 'bg-warning text-dark',
                    'in_progress' => 'bg-danger text-white animate-pulse',
                    'completed' => 'bg-success text-white',
                    default => 'bg-secondary'
                };
            @endphp
            <div class="text-center mb-3">
                <span class="badge {{ $sBadge }} fs-6 px-3 py-2 text-uppercase mb-2 shadow-sm">
                    Status: {{ str_replace('_', ' ', $ot->status) }}
                </span>
                <h5 class="fw-bold mb-1">{{ $ot->patient->name ?? 'Patient' }}</h5>
                <span class="id-badge">{{ $ot->patient->patient_id ?? 'N/A' }}</span>
            </div>

            <div class="border-top pt-3" style="font-size: 0.88rem;">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Lead Surgeon:</span>
                    <strong class="text-primary">Dr. {{ $ot->leadSurgeon->name ?? 'Surgeon' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Anesthesiologist:</span>
                    <span>Dr. {{ $ot->anesthesiologist->name ?? 'Unassigned' }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Anesthesia:</span>
                    <span class="badge bg-light text-dark border">{{ $ot->anesthesia_type }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Scheduled:</span>
                    <small class="fw-bold">{{ $ot->scheduled_start ? $ot->scheduled_start->format('M d, Y h:i A') : '' }}</small>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Total OT Charge:</span>
                    <strong class="text-success fs-6">৳ {{ number_format($ot->total_charge, 2) }}</strong>
                </div>
            </div>

            <!-- Surgical Team -->
            <div class="border-top pt-3 mt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.85rem;">Surgical Staff Team</h6>
                    <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                        <i class="fa-solid fa-plus"></i> Add
                    </button>
                </div>
                <ul class="list-unstyled mb-0" style="font-size: 0.8rem;">
                    @forelse($ot->staffTeam as $st)
                        <li class="py-1 border-bottom d-flex justify-content-between">
                            <span>{{ $st->staff->name ?? 'Staff' }}</span>
                            <span class="badge bg-light text-dark border">{{ $st->role }}</span>
                        </li>
                    @empty
                        <li class="text-muted">No additional staff assigned yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Operative Notes & Checklist -->
    <div class="col-lg-8">
        <div class="card card-premium shadow-sm p-4 h-100">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-file-medical text-primary me-2"></i>Operative Notes & Surgical Record</h6>

            <form action="{{ route('ot.updateNotes', $ot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pre-Operative Preparation Checklist</label>
                        <textarea name="pre_op_notes" class="form-control" rows="3">{{ $ot->pre_op_notes }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Post-Operative Recovery Orders</label>
                        <textarea name="post_op_notes" class="form-control" rows="3" placeholder="NPO for 6 hours, monitor vitals q15m x 1h then q1h, Inj. Pethidine 50mg IM SOS...">{{ $ot->post_op_notes }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Intra-Operative Surgical Findings & Technique</label>
                        <textarea name="op_notes" class="form-control" rows="6" placeholder="Under general anesthesia, patient in supine position. Abdomen prepped and draped. 4-port laparoscopy performed... Specimen retrieved, hemostasis achieved, port sites closed in layers.">{{ $ot->op_notes }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Update Surgery Status</label>
                        <select name="status" class="form-select" required>
                            <option value="scheduled" {{ $ot->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="in_progress" {{ $ot->status == 'in_progress' ? 'selected' : '' }}>In Progress (Surgery Underway)</option>
                            <option value="completed" {{ $ot->status == 'completed' ? 'selected' : '' }}>Completed (Patient in Recovery)</option>
                            <option value="cancelled" {{ $ot->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-end align-self-end">
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Operative Notes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add Staff to Surgical Team -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('ot.addStaff', $ot->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6"><i class="fa-solid fa-user-plus me-2"></i>Add Team Member to Surgery</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Staff Member <span class="text-danger">*</span></label>
                        <select name="staff_id" class="form-select" required>
                            <option value="">-- Choose Staff --</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->designation ?? 'Staff' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role in Surgery <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="Assistant Surgeon">Assistant Surgeon</option>
                            <option value="Scrub Nurse">Scrub Nurse</option>
                            <option value="Circulating Nurse">Circulating Nurse</option>
                            <option value="OT Technician">OT Technician</option>
                            <option value="Anesthesia Assistant">Anesthesia Assistant</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
