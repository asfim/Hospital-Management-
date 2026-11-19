@extends('layouts.admin')

@section('title', 'Hospital Accounts & Financial Ledger')

@push('styles')
<style>
/* ====================================================================
   ACCOUNTS & FINANCIAL LEDGER LUXURY DESIGN SYSTEM
   ==================================================================== */
.accounts-page-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2), 0 4px 10px -2px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}

.accounts-page-header::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -40px;
    width: 260px;
    height: 260px;
    background: radial-gradient(circle, rgba(13, 148, 136, 0.25) 0%, rgba(13, 148, 136, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.accounts-page-header::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: 20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(225, 29, 72, 0.18) 0%, rgba(225, 29, 72, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.accounts-header-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: rgba(13, 148, 136, 0.2);
    border: 1px solid rgba(13, 148, 136, 0.4);
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #5eead4;
    margin-bottom: 0.5rem;
}

.accounts-page-header h3 {
    color: #ffffff !important;
    font-weight: 800;
    font-size: 1.6rem;
    letter-spacing: -0.5px;
    margin-bottom: 0.25rem;
}

.accounts-page-header p {
    color: #cbd5e1 !important;
    font-size: 0.88rem;
    margin-bottom: 0;
}

/* Date Filter Box inside Header */
.accounts-filter-box {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 14px;
    padding: 8px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.accounts-filter-box .filter-field label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #94a3b8;
    margin-bottom: 2px;
    display: block;
}

.accounts-filter-box .form-control {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    color: #1e293b;
    font-size: 0.82rem;
    border-radius: 8px;
    padding: 4px 8px;
}

/* KPI Financial Metric Cards */
.kpi-metric-card {
    position: relative;
    border-radius: 16px;
    padding: 1.25rem 1.4rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.kpi-metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.kpi-metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.08), 0 4px 8px -2px rgba(0, 0, 0, 0.03);
}

/* Specific Variant Styles */
.kpi-income {
    background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    border-color: #bbf7d0;
}
.kpi-income::before {
    background: linear-gradient(90deg, #10b981, #059669);
}
.kpi-income .kpi-icon-bubble {
    background: #dcfce7;
    color: #059669;
}
.kpi-income .kpi-num {
    color: #065f46;
}

.kpi-expense {
    background: linear-gradient(180deg, #ffffff 0%, #fff1f2 100%);
    border-color: #fecdd3;
}
.kpi-expense::before {
    background: linear-gradient(90deg, #f43f5e, #be123c);
}
.kpi-expense .kpi-icon-bubble {
    background: #ffe4e6;
    color: #e11d48;
}
.kpi-expense .kpi-num {
    color: #9f1239;
}

.kpi-balance-surplus {
    background: linear-gradient(180deg, #ffffff 0%, #f0fdfa 100%);
    border-color: #99f6e4;
}
.kpi-balance-surplus::before {
    background: linear-gradient(90deg, #0d9488, #0f766e);
}
.kpi-balance-surplus .kpi-icon-bubble {
    background: #ccfbf1;
    color: #0f766e;
}
.kpi-balance-surplus .kpi-num {
    color: #115e59;
}

.kpi-balance-deficit {
    background: linear-gradient(180deg, #ffffff 0%, #fff7ed 100%);
    border-color: #fed7aa;
}
.kpi-balance-deficit::before {
    background: linear-gradient(90deg, #f97316, #ea580c);
}
.kpi-balance-deficit .kpi-icon-bubble {
    background: #ffedd5;
    color: #ea580c;
}
.kpi-balance-deficit .kpi-num {
    color: #9a3412;
}

.kpi-receivable {
    background: linear-gradient(180deg, #ffffff 0%, #fefce8 100%);
    border-color: #fef08a;
}
.kpi-receivable::before {
    background: linear-gradient(90deg, #eab308, #ca8a04);
}
.kpi-receivable .kpi-icon-bubble {
    background: #fef9c3;
    color: #ca8a04;
}
.kpi-receivable .kpi-num {
    color: #854d0e;
}

.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.kpi-title {
    font-size: 0.76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin: 0;
}

.kpi-icon-bubble {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    transition: transform 0.25s ease;
}

.kpi-metric-card:hover .kpi-icon-bubble {
    transform: scale(1.1) rotate(4deg);
}

.kpi-num {
    font-size: 1.85rem;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.5px;
    margin-bottom: 6px;
}

.kpi-meta {
    font-size: 0.74rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Financial Health Ratio Strip */
.cashflow-ratio-bar {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    margin-bottom: 1.75rem;
}

.ratio-progress {
    height: 10px;
    border-radius: 20px;
    background: #f1f5f9;
    overflow: hidden;
    display: flex;
    margin: 10px 0 6px;
}

.ratio-progress .bar-income {
    background: linear-gradient(90deg, #10b981, #059669);
    transition: width 0.6s ease;
}

.ratio-progress .bar-expense {
    background: linear-gradient(90deg, #f43f5e, #e11d48);
    transition: width 0.6s ease;
}

/* Modern Card Styling */
.accounts-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.accounts-card-header {
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
    padding: 1rem 1.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.accounts-card-header .card-title {
    font-size: 0.96rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Scrollable Container with Smooth Styled Scrollbar */
.card-scroll-body {
    flex-grow: 1;
    height: 320px;
    max-height: 320px;
    overflow-y: auto;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f8fafc;
}

.card-scroll-body::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.card-scroll-body::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 4px;
}

.card-scroll-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.card-scroll-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Modern Tables & Sticky Headers / Footers */
.table-finance {
    border-collapse: separate !important;
    border-spacing: 0;
}

.table-finance th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-finance-sticky thead th {
    position: sticky;
    top: 0;
    z-index: 5;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.table-finance-sticky tfoot td {
    position: sticky;
    bottom: 0;
    z-index: 5;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.table-finance td {
    padding: 12px 16px;
    font-size: 0.88rem;
    border-bottom: 1px solid #f1f5f9;
}

.table-finance tbody tr:hover {
    background: #f8fafc;
}

/* Service Dept Avatars */
.dept-avatar {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    margin-right: 12px;
}
</style>
@endpush

@section('content')

<!-- ====================================================================
     PREMIUM HEADER WITH INTEGRATED DATE FILTER & ACTIONS
     ==================================================================== -->
<div class="accounts-page-header">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="accounts-header-badge">
                <i class="fa-solid fa-vault"></i> Finance & Revenue Management
            </div>
            <h3>Hospital Financial Ledger & Accounts</h3>
            <p>Real-time consolidated balance sheet: IPD, OPD, Pharmacy, Diagnostics & Operating Expenses</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Date Filter Form -->
            <form action="{{ route('accounts.index') }}" method="GET" class="accounts-filter-box">
                <div class="filter-field">
                    <label>From Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                </div>
                <div class="filter-field">
                    <label>To Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                </div>
                <div class="align-self-end">
                    <button type="submit" class="btn btn-sm btn-primary px-3 fw-bold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #0d9488, #0f766e); border: none; padding: 6px 14px;">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>

            <div class="d-flex gap-2">
                <button type="button" onclick="window.print()" class="btn btn-outline-light px-3 py-2 fw-semibold rounded-3 shadow-sm" title="Print Balance Sheet">
                    <i class="fa-solid fa-print me-1"></i> Print
                </button>
                <a href="{{ route('expenses.create') }}" class="btn btn-danger px-3 py-2 fw-bold rounded-3 shadow" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none;">
                    <i class="fa-solid fa-plus-circle me-1"></i> Add Voucher
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ====================================================================
     PRIMARY FINANCIAL KPI METRIC TILES
     ==================================================================== -->
<div class="row g-3 mb-4">
    <!-- 1. Total Hospital Income -->
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-metric-card kpi-income">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Total Hospital Revenue</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
                <div class="kpi-num">৳{{ number_format($totalIncome, 2) }}</div>
            </div>
            <div class="kpi-meta">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                    <i class="fa-solid fa-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- 2. Operating Expenses -->
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-metric-card kpi-expense">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Total Operating Outflows</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                </div>
                <div class="kpi-num">৳{{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="kpi-meta">
                <a href="{{ route('expenses.index') }}" class="text-danger fw-semibold text-decoration-none small">
                    <i class="fa-solid fa-receipt me-1"></i>View Expense Vouchers &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Net Operating Balance -->
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-metric-card {{ $netBalance >= 0 ? 'kpi-balance-surplus' : 'kpi-balance-deficit' }}">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Net Operating Balance</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid {{ $netBalance >= 0 ? 'fa-scale-balanced' : 'fa-scale-unbalanced' }}"></i>
                    </div>
                </div>
                <div class="kpi-num">
                    @if($netBalance < 0)
                        -৳{{ number_format(abs($netBalance), 2) }}
                    @else
                        +৳{{ number_format($netBalance, 2) }}
                    @endif
                </div>
            </div>
            <div class="kpi-meta">
                @if($netBalance >= 0)
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-bold">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i>Surplus / Operating Profit
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill fw-bold">
                        <i class="fa-solid fa-arrow-trend-down me-1"></i>Operating Deficit
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Outstanding Receivables -->
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-metric-card kpi-receivable">
            <div>
                <div class="kpi-header">
                    <h6 class="kpi-title">Outstanding Receivables</h6>
                    <div class="kpi-icon-bubble">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
                <div class="kpi-num">৳{{ number_format($totalDue, 2) }}</div>
            </div>
            <div class="kpi-meta">
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                    <i class="fa-solid fa-hourglass-half me-1"></i>Uncollected Patient Dues
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================
     FINANCIAL COMPARATIVE CASH FLOW HEALTH STRIP
     ==================================================================== -->
@php
    $totalCombined = $totalIncome + $totalExpenses;
    $incomeRatio = $totalCombined > 0 ? round(($totalIncome / $totalCombined) * 100, 1) : 50;
    $expenseRatio = $totalCombined > 0 ? round(($totalExpenses / $totalCombined) * 100, 1) : 50;
@endphp
<div class="cashflow-ratio-bar">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
        <div class="small fw-bold text-uppercase text-dark d-flex align-items-center gap-2">
            <i class="fa-solid fa-chart-simple text-primary"></i> Income vs Operating Expenses Comparison
        </div>
        <div class="small d-flex align-items-center gap-3">
            <span class="d-flex align-items-center gap-1">
                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #10b981;"></span>
                <span class="text-muted">Collections:</span> <strong class="text-success">{{ $incomeRatio }}%</strong>
            </span>
            <span class="d-flex align-items-center gap-1">
                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #e11d48;"></span>
                <span class="text-muted">Expenses:</span> <strong class="text-danger">{{ $expenseRatio }}%</strong>
            </span>
        </div>
    </div>
    <div class="ratio-progress">
        <div class="bar-income" style="width: {{ $incomeRatio }}%;" title="Income: {{ $incomeRatio }}%"></div>
        <div class="bar-expense" style="width: {{ $expenseRatio }}%;" title="Expenses: {{ $expenseRatio }}%"></div>
    </div>
</div>

<!-- ====================================================================
     DEPARTMENT REVENUE & EXPENSES BREAKDOWN
     ==================================================================== -->
<div class="row g-4 mb-4">
    <!-- Department Revenue Distribution -->
    <div class="col-lg-6">
        <div class="accounts-card">
            <div class="accounts-card-header">
                <h6 class="card-title">
                    <i class="fa-solid fa-chart-pie text-teal" style="color: #0d9488;"></i> Revenue Distribution by Department
                </h6>
                <span class="badge bg-light text-secondary border px-2 py-1">4 Streams</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive m-0 card-scroll-body">
                    <table class="table table-finance table-finance-sticky align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Department / Service</th>
                                <th class="text-end">Collections (Paid)</th>
                                <th class="text-end">Outstanding (Due)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- OPD Invoices -->
                            @php
                                $opdShare = $totalIncome > 0 ? round(($invoiceIncome / $totalIncome) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="dept-avatar bg-primary-subtle text-primary">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">OPD & Consultation Invoices</div>
                                            <div class="small text-muted">{{ $opdShare }}% of Total Inflow</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($invoiceIncome, 2) }}</td>
                                <td class="text-end">
                                    @if($invoiceDue > 0)
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">৳{{ number_format($invoiceDue, 2) }}</span>
                                    @else
                                        <span class="text-muted small">৳0.00</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- IPD Deposits -->
                            @php
                                $ipdShare = $totalIncome > 0 ? round(($ipdIncome / $totalIncome) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="dept-avatar bg-info-subtle text-info">
                                            <i class="fa-solid fa-bed-pulse"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">IPD Admissions Deposits</div>
                                            <div class="small text-muted">{{ $ipdShare }}% of Total Inflow</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($ipdIncome, 2) }}</td>
                                <td class="text-end text-muted small">-</td>
                            </tr>

                            <!-- Pharmacy Sales -->
                            @php
                                $pharmacyShare = $totalIncome > 0 ? round(($pharmacyIncome / $totalIncome) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="dept-avatar bg-success-subtle text-success">
                                            <i class="fa-solid fa-prescription-bottle-medical"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">Hospital Pharmacy POS</div>
                                            <div class="small text-muted">{{ $pharmacyShare }}% of Total Inflow</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($pharmacyIncome, 2) }}</td>
                                <td class="text-end">
                                    @if($pharmacyDue > 0)
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">৳{{ number_format($pharmacyDue, 2) }}</span>
                                    @else
                                        <span class="text-muted small">৳0.00</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Diagnostic Orders -->
                            @php
                                $labShare = $totalIncome > 0 ? round(($labIncome / $totalIncome) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="dept-avatar bg-warning-subtle text-warning-emphasis">
                                            <i class="fa-solid fa-flask-vial"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">Pathology & Radiology Orders</div>
                                            <div class="small text-muted">{{ $labShare }}% of Total Inflow</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳{{ number_format($labIncome, 2) }}</td>
                                <td class="text-end">
                                    @if($labDue > 0)
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">৳{{ number_format($labDue, 2) }}</span>
                                    @else
                                        <span class="text-muted small">৳0.00</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Total Hospital Revenue</td>
                                <td class="text-end text-success fs-6">৳{{ number_format($totalIncome, 2) }}</td>
                                <td class="text-end text-danger fs-6">৳{{ number_format($totalDue, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Operating Expenses by Category -->
    <div class="col-lg-6">
        <div class="accounts-card">
            <div class="accounts-card-header">
                <h6 class="card-title">
                    <i class="fa-solid fa-tags text-danger"></i> Operating Expenses by Category
                </h6>
                <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-outline-danger rounded-3 fw-semibold">
                    <i class="fa-solid fa-plus me-1"></i> Add Voucher
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive m-0 card-scroll-body">
                    <table class="table table-finance table-finance-sticky align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Expense Category</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end" style="width: 130px;">Share</th>
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
                                        <span class="fw-semibold text-dark">{{ $cat->name }}</span>
                                    </td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($catAmt, 2) }}</td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px; max-width: 60px;">
                                                <div class="progress-bar bg-danger" style="width: {{ $pct }}%;"></div>
                                            </div>
                                            <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem;">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No expense categories registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Total Operating Outflow</td>
                                <td class="text-end text-danger fs-6">৳{{ number_format($totalExpenses, 2) }}</td>
                                <td class="text-end"><span class="badge bg-danger-subtle text-danger">100%</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================
     RECENT TRANSACTIONS: INVOICES & EXPENSE VOUCHERS
     ==================================================================== -->
<div class="row g-4">
    <!-- Recent Invoices -->
    <div class="col-lg-6">
        <div class="accounts-card">
            <div class="accounts-card-header">
                <h6 class="card-title">
                    <i class="fa-solid fa-receipt text-primary"></i> Recent Patient Billing Invoices
                </h6>
                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-link text-primary text-decoration-none fw-semibold p-0">
                    View All &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive m-0 card-scroll-body">
                    <table class="table table-finance table-finance-sticky align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Patient</th>
                                <th>Status</th>
                                <th class="text-end">Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices as $inv)
                                <tr>
                                    <td>
                                        <a href="{{ route('invoices.show', $inv->id) }}" class="fw-bold text-primary text-decoration-none">
                                            <i class="fa-solid fa-hashtag me-1 text-muted"></i>{{ $inv->invoice_number ?? $inv->id }}
                                        </a>
                                        <div class="small text-muted">{{ $inv->created_at->format('d M, h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $inv->patient->name ?? 'Walk-in Guest' }}</div>
                                        <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $inv->patient->mobile ?? $inv->patient->phone ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        @if($inv->status == 'paid')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                                <i class="fa-solid fa-circle-check me-1"></i>Paid
                                            </span>
                                        @elseif($inv->status == 'partial')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                                                <i class="fa-solid fa-circle-half-stroke me-1"></i>Partial
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                                                <i class="fa-solid fa-circle-xmark me-1"></i>Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($inv->paid ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent invoices recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="col-lg-6">
        <div class="accounts-card">
            <div class="accounts-card-header">
                <h6 class="card-title">
                    <i class="fa-solid fa-file-invoice-dollar text-danger"></i> Recent Expense Vouchers
                </h6>
                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold p-0">
                    View All &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive m-0 card-scroll-body">
                    <table class="table table-finance table-finance-sticky align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Voucher Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentExpenses as $exp)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $exp->title }}</div>
                                        <div class="small text-muted"><i class="fa-solid fa-ticket me-1"></i>{{ $exp->reference_no ?? 'VOUCH-' . $exp->id }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-3">
                                            {{ $exp->category->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($exp->date)->format('d M, Y') }}
                                    </td>
                                    <td class="text-end fw-bold text-danger">৳{{ number_format($exp->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent expenses recorded.</td>
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
