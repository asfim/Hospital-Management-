@extends('layouts.admin')

@section('title', 'Pharmacy Receipt - ' . $sale->bill_no)

@section('content')
<div class="d-print-none mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('pharmacy.pos') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to POS Counter
    </a>
    <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold">
        <i class="fa-solid fa-print me-1"></i> Print Receipt
    </button>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4 shadow-sm border" style="background: #fff; font-family: monospace;">
            <div class="text-center border-bottom pb-3 mb-3">
                <h4 class="fw-bold mb-1">{{ config('app.name', 'Hospital ERP') }}</h4>
                <p class="mb-0 text-muted" style="font-size: 0.85rem;">Central Hospital Pharmacy & Drug Store</p>
                <small class="text-muted">Hotline: +880 1711 000 000 | 24/7 Service</small>
            </div>

            <div class="d-flex justify-content-between mb-3" style="font-size: 0.88rem;">
                <div>
                    <div><strong>Bill #:</strong> {{ $sale->bill_no }}</div>
                    <div><strong>Customer:</strong> {{ $sale->customer_name }}</div>
                    @if($sale->customer_phone)
                        <div><strong>Phone:</strong> {{ $sale->customer_phone }}</div>
                    @endif
                </div>
                <div class="text-end">
                    <div><strong>Date:</strong> {{ $sale->created_at->format('d/m/Y h:i A') }}</div>
                    <div><strong>Dispensed by:</strong> {{ $sale->seller->name ?? 'Pharmacist' }}</div>
                    <div><strong>Payment:</strong> {{ $sale->payment_method }}</div>
                </div>
            </div>

            <table class="table table-sm border-top border-bottom" style="font-size: 0.88rem;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Rate</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->medicine->name ?? 'Medicine' }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">৳{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end" style="font-size: 0.9rem;">
                <div style="min-width: 200px;">
                    <div class="d-flex justify-content-between py-1">
                        <span>Subtotal:</span>
                        <span>৳{{ number_format($sale->subtotal, 2) }}</span>
                    </div>
                    @if($sale->discount > 0)
                        <div class="d-flex justify-content-between py-1 text-danger">
                            <span>Discount:</span>
                            <span>-৳{{ number_format($sale->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between py-1 border-top border-bottom fw-bold">
                        <span>Grand Total:</span>
                        <span>৳{{ number_format($sale->total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span>Paid:</span>
                        <span>৳{{ number_format($sale->paid, 2) }}</span>
                    </div>
                    @if($sale->due > 0)
                        <div class="d-flex justify-content-between py-1 text-danger fw-bold">
                            <span>Due Balance:</span>
                            <span>৳{{ number_format($sale->due, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center border-top pt-3 mt-4 text-muted" style="font-size: 0.78rem;">
                <p class="mb-1">Sold medicines can be exchanged within 7 days with original receipt.</p>
                <p class="mb-0 fw-bold">Thank you for visiting! Wishing you a speedy recovery.</p>
            </div>
        </div>
    </div>
</div>
@endsection
