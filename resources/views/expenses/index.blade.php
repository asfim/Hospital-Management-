@extends('layouts.admin')

@section('title', 'Hospital Expenses & Accounts')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4 class="mb-1"><i class="fa-solid fa-money-bill-transfer me-2"></i>Hospital Expense Vouchers</h4>
        <p class="mb-0 text-white-50">Utilities, Medical Consumables, Maintenance, Stationery & Operational Costs</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('expenses.create') }}" class="btn btn-light text-primary fw-bold btn-sm shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Add Expense Voucher
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-premium p-4 border-start border-danger border-4 shadow-sm">
            <span class="text-muted small text-uppercase fw-bold">Period Total Expenses</span>
            <h3 class="fw-bold text-danger mt-1 mb-0">৳ {{ number_format($totalExpenses, 2) }}</h3>
            <small class="text-muted">Between {{ $startDate }} and {{ $endDate }}</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-premium p-4 border-start border-warning border-4 shadow-sm">
            <span class="text-muted small text-uppercase fw-bold">Today's Expenses</span>
            <h3 class="fw-bold text-dark mt-1 mb-0">৳ {{ number_format($todayExpenses, 2) }}</h3>
            <small class="text-muted">Paid today</small>
        </div>
    </div>
</div>

<div class="card card-premium shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold text-dark">Expense Transactions</h6>
        <form method="GET" action="{{ route('expenses.index') }}" class="d-flex gap-2 flex-wrap">
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">-- All Categories --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-premium align-middle mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Title & Description</th>
                    <th>Payment Method</th>
                    <th>Ref #</th>
                    <th>Amount (৳)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $exp)
                    <tr>
                        <td><strong>{{ $exp->date ? $exp->date->format('M d, Y') : '' }}</strong></td>
                        <td><span class="badge bg-light text-dark border">{{ $exp->category->name ?? 'Expense' }}</span></td>
                        <td>
                            <strong>{{ $exp->title }}</strong>
                            @if($exp->note)
                                <br><small class="text-muted">{{ $exp->note }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $exp->payment_method }}</span></td>
                        <td><small>{{ $exp->reference_no ?? '-' }}</small></td>
                        <td class="fw-bold text-danger">৳ {{ number_format($exp->amount, 2) }}</td>
                        <td>
                            <form action="{{ route('expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Delete this expense?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-btn-del" title="Delete Expense">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">No expense transactions recorded in this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($expenses->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $expenses->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
