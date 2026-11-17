@extends('layouts.admin')

@section('title', 'Hospital Accounts & Financial Ledger')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-scale-balanced me-2 text-primary"></i>Hospital Financial Ledger & Accounts</h4>
        <p class="text-muted mb-0">Complete balance sheet: Inpatient, Outpatient, Pharmacy, Diagnostics & Operating Expenses</p>
    </div>
    <form action="{{ route('accounts.index') }}" method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 shadow-sm border">
        <div>
            <label class="small text-muted d-block" style="font-size: 0.7rem;">FROM</label>
            <input type="date" name="start_date" class="form-control form-control-sm border-0 bg-light" value="{{ $startDate }}">
        </div>
        <div>
            <label class="small text-muted d-block" style="font-size: 0.7rem;">TO</label>
            <input type="date" name="end_date" class="form-control form-control-sm border-0 bg-light" value="{{ $endDate }}">
        </div>
        <div class="align-self-end">
            <button type="submit" class="btn btn-sm btn-primary px-3">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Primary Financial KPIs -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 text-white h-100" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fa-solid fa-coins position-absolute opacity-25" style="font-size: 4.5rem; right: -10px; bottom: -10px;"></i>
                <div class="text-uppercase fw-semibold small opacity-75 mb-1">Total Hospital Income</div>
                <h3 class="fw-bold mb-0">৳{{ number_format($totalIncome, 2) }}</h3>
                <div class="small opacity-75 mt-2">Period: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 text-white h-100" style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fa-solid fa-file-invoice-dollar position-absolute opacity-25" style="font-size: 4.5rem; right: -10px; bottom: -10px;"></i>
                <div class="text-uppercase fw-semibold small opacity-75 mb-1">Total Expenses</div>
                <h3 class="fw-bold mb-0">৳{{ number_format($totalExpenses, 2) }}</h3>
                <div class="small opacity-75 mt-2"><a href="{{ route('expenses.index') }}" class="text-white text-decoration-underline">View vouchers &rarr;</a></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 text-white h-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fa-solid fa-chart-line position-absolute opacity-25" style="font-size: 4.5rem; right: -10px; bottom: -10px;"></i>
                <div class="text-uppercase fw-semibold small opacity-75 mb-1">Net Operating Balance</div>
                <h3 class="fw-bold mb-0">৳{{ number_format($netBalance, 2) }}</h3>
                <div class="small opacity-75 mt-2 {{ $netBalance >= 0 ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                    {{ $netBalance >= 0 ? 'Surplus / Operating Profit' : 'Operating Deficit' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 text-white h-100" style="background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fa-solid fa-clock-rotate-left position-absolute opacity-25" style="font-size: 4.5rem; right: -10px; bottom: -10px;"></i>
                <div class="text-uppercase fw-semibold small opacity-75 mb-1">Outstanding Receivables</div>
                <h3 class="fw-bold mb-0">৳{{ number_format($totalDue, 2) }}</h3>
                <div class="small opacity-75 mt-2">Unpaid patient dues</div>
            </div>
        </div>
    </div>
</div>

<!-- Department Revenue Breakdown -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-chart-pie me-2 text-teal"></i>Revenue Distribution by Department
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Department / Service</th>
                                <th class="text-end">Collections (Paid)</th>
                                <th class="text-end">Outstanding (Due)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary me-2">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </div>
                                        <span class="fw-medium">OPD & Consultation Invoices</span>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($invoiceIncome, 2) }}</td>
                                <td class="text-end text-danger">৳{{ number_format($invoiceDue, 2) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info me-2">
                                            <i class="fa-solid fa-bed-pulse"></i>
                                        </div>
                                        <span class="fw-medium">IPD Admission Deposits</span>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($ipdIncome, 2) }}</td>
                                <td class="text-end text-muted">-</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success me-2">
                                            <i class="fa-solid fa-prescription-bottle-medical"></i>
                                        </div>
                                        <span class="fw-medium">Hospital Pharmacy POS</span>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($pharmacyIncome, 2) }}</td>
                                <td class="text-end text-danger">৳{{ number_format($pharmacyDue, 2) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 text-warning me-2">
                                            <i class="fa-solid fa-vial-virus"></i>
                                        </div>
                                        <span class="fw-medium">Pathology & Radiology Tests</span>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($labIncome, 2) }}</td>
                                <td class="text-end text-danger">৳{{ number_format($labDue, 2) }}</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Total Hospital Revenue</td>
                                <td class="text-end text-success">৳{{ number_format($totalIncome, 2) }}</td>
                                <td class="text-end text-danger">৳{{ number_format($totalDue, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses by Category -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-tags me-2 text-danger"></i>Operating Expenses by Category
                </h6>
                <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-plus me-1"></i> Add Voucher
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenseCategories as $cat)
                                @php
                                    $catAmt = $cat->expenses_sum_amount ?? 0;
                                    $pct = $totalExpenses > 0 ? round(($catAmt / $totalExpenses) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $cat->name }}</span>
                                    </td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($catAmt, 2) }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-light text-secondary border">{{ $pct }}%</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No expense categories registered.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Total Operating Outflow</td>
                                <td class="text-end text-danger">৳{{ number_format($totalExpenses, 2) }}</td>
                                <td class="text-end">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-receipt me-2 text-primary"></i>Recent Patient Billing Invoices
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Invoice</th>
                                <th>Patient</th>
                                <th>Status</th>
                                <th class="text-end">Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices as $inv)
                                <tr>
                                    <td>
                                        <a href="{{ route('invoices.show', $inv->id) }}" class="fw-bold text-primary">
                                            #{{ $inv->invoice_number ?? $inv->id }}
                                        </a>
                                        <div class="small text-muted">{{ $inv->created_at->format('d M, h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $inv->patient->name ?? 'Guest' }}</div>
                                        <div class="small text-muted">{{ $inv->patient->phone ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $inv->status == 'paid' ? 'success' : ($inv->status == 'partial' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($inv->status ?? 'unpaid') }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($inv->paid ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No recent invoices recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-file-invoice-dollar me-2 text-danger"></i>Recent Expense Vouchers
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Title / Voucher</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentExpenses as $exp)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ $exp->title }}</div>
                                        <div class="small text-muted">{{ $exp->reference_no ?? 'VOUCH-' . $exp->id }}</div>
                                    </td>
                                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">{{ $exp->category->name ?? 'General' }}</span></td>
                                    <td class="small text-muted">{{ \Carbon\Carbon::parse($exp->date)->format('d M, Y') }}</td>
                                    <td class="text-end fw-bold text-danger">৳{{ number_format($exp->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No recent expenses recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
