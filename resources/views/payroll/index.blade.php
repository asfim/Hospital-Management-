@extends('layouts.admin')

@section('title', 'Staff Attendance & Payroll')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-users-gear me-2 text-primary"></i>HR & Staff Payroll Management</h4>
        <p class="text-muted mb-0">Daily duty attendance, overtime, salary slips generation and disbursement</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateSalaryModal">
            <i class="fa-solid fa-money-check-dollar me-1"></i> Generate Payslip
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-3 shadow-sm border" id="payrollTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active px-4 py-2" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
            <i class="fa-solid fa-calendar-check me-1"></i> Daily Attendance
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-2" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary" type="button" role="tab">
            <i class="fa-solid fa-file-invoice-dollar me-1"></i> Monthly Salary Register
        </button>
    </li>
</ul>

<div class="tab-content" id="payrollTabsContent">
    <!-- Tab 1: Daily Attendance -->
    <div class="tab-pane fade show active" id="attendance" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-clipboard-user me-2 text-primary"></i>Staff Attendance Roster
                </h6>
                <form action="{{ route('payroll.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <label class="small text-muted mb-0">DATE:</label>
                    <input type="date" name="attendance_date" class="form-control form-control-sm" value="{{ $attendanceDate }}" onchange="this.form.submit()">
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Staff Member</th>
                                <th>Designation</th>
                                <th>Sign In Time</th>
                                <th>Sign Out Time</th>
                                <th>Attendance Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staffList as $stf)
                                @php
                                    $att = $attendances[$stf->id] ?? null;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $stf->name }}</div>
                                        <div class="small text-muted">{{ $stf->phone }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border">{{ $stf->designation ?? 'Hospital Staff' }}</span>
                                    </td>
                                    <form action="{{ route('payroll.mark-attendance') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="staff_id" value="{{ $stf->id }}">
                                        <input type="hidden" name="date" value="{{ $attendanceDate }}">
                                        <td>
                                            <input type="time" name="sign_in" class="form-control form-control-sm" value="{{ $att ? $att->sign_in : '08:00' }}" style="width: 120px;">
                                        </td>
                                        <td>
                                            <input type="time" name="sign_out" class="form-control form-control-sm" value="{{ $att ? $att->sign_out : '16:00' }}" style="width: 120px;">
                                        </td>
                                        <td>
                                            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                                <option value="Present" {{ ($att && $att->status == 'Present') ? 'selected' : '' }}>Present</option>
                                                <option value="Late" {{ ($att && $att->status == 'Late') ? 'selected' : '' }}>Late</option>
                                                <option value="On Leave" {{ ($att && $att->status == 'On Leave') ? 'selected' : '' }}>On Leave</option>
                                                <option value="Absent" {{ ($att && $att->status == 'Absent') ? 'selected' : '' }}>Absent</option>
                                            </select>
                                        </td>
                                        <td class="text-end">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-save me-1"></i> Save
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No staff members found. Add staff members in Staff Directory first.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Monthly Salary Register -->
    <div class="tab-pane fade" id="salary" role="tabpanel">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                    <div class="small fw-semibold text-uppercase">Disbursed Salaries ({{ $monthYear }})</div>
                    <div class="h3 fw-bold mb-0">৳{{ number_format($totalDisbursed, 2) }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                    <div class="small fw-semibold text-uppercase">Pending Payroll ({{ $monthYear }})</div>
                    <div class="h3 fw-bold mb-0">৳{{ number_format($totalPending, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-receipt me-2 text-primary"></i>Salary Disbursement Records
                </h6>
                <form action="{{ route('payroll.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    <label class="small text-muted mb-0">MONTH:</label>
                    <input type="month" name="month_year" class="form-control form-control-sm" value="{{ $monthYear }}" onchange="this.form.submit()">
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Staff Member</th>
                                <th>Month</th>
                                <th>Basic Salary</th>
                                <th>Allowances / Bonus</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                                <th class="text-end">Payslip</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salaries as $sal)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $sal->staff->name ?? 'Staff' }}</div>
                                        <div class="small text-muted">{{ $sal->staff->designation ?? '' }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $sal->month_year }}</span></td>
                                    <td>৳{{ number_format($sal->basic_salary, 2) }}</td>
                                    <td class="text-success">+৳{{ number_format($sal->allowances, 2) }}</td>
                                    <td class="text-danger">-৳{{ number_format($sal->deductions, 2) }}</td>
                                    <td class="fw-bold text-primary">৳{{ number_format($sal->net_salary, 2) }}</td>
                                    <td class="small">{{ \Carbon\Carbon::parse($sal->payment_date)->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sal->status == 'Paid' ? 'success' : 'warning text-dark' }}">{{ $sal->status }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('payroll.payslip', $sal->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-print me-1"></i> Payslip
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No salary records generated for {{ $monthYear }}. Click "Generate Payslip" above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Generate Salary -->
<div class="modal fade" id="generateSalaryModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('payroll.store-salary') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-money-check-dollar me-2 text-primary"></i>Generate Staff Salary Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Staff Member <span class="text-danger">*</span></label>
                            <select name="staff_id" class="form-select" required>
                                <option value="">-- Select Staff --</option>
                                @foreach($staffList as $stf)
                                    <option value="{{ $stf->id }}">{{ $stf->name }} ({{ $stf->designation ?? 'Staff' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Month-Year <span class="text-danger">*</span></label>
                            <input type="month" name="month_year" class="form-control" value="{{ $monthYear }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Basic Salary (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="basic_salary" class="form-control" required placeholder="e.g. 25000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Allowances (৳)</label>
                            <input type="number" step="0.01" name="allowances" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Deductions (৳)</label>
                            <input type="number" step="0.01" name="deductions" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select" required>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save & Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
