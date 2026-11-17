@extends('layouts.admin')

@section('title', 'Pharmacy POS Dispensing Counter')

@section('content')
<div class="page-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 36px; height: 36px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0"><i class="fa-solid fa-cash-register me-2"></i>Pharmacy POS Dispensing Counter</h4>
                <p class="mb-0 text-white-50">Fast Medication Dispensing, Stock Deduction & Inpatient Billing</p>
            </div>
        </div>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('pharmacy.storeSale') }}" method="POST" id="posForm">
    @csrf
    <div class="row g-4">
        <!-- Left: Medicine Search & Cart -->
        <div class="col-lg-8">
            <!-- Add Medicine Box -->
            <div class="card card-premium shadow-sm p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-magnifying-glass text-primary me-2"></i>Select Medicine from Formulary</h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <select id="medicineSelector" class="form-select select2">
                            <option value="">-- Choose Medicine to Add --</option>
                            @foreach($medicines as $m)
                                @php $stock = $m->totalStock(); @endphp
                                <option value="{{ $m->id }}" 
                                        data-name="{{ $m->name }}" 
                                        data-price="{{ $m->unit_price }}" 
                                        data-stock="{{ $stock }}"
                                        {{ $stock <= 0 ? 'disabled' : '' }}>
                                    {{ $m->name }} ({{ $m->dosage_form }}) - ৳ {{ number_format($m->unit_price, 2) }} [Stock: {{ $stock }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="addItemBtn" class="btn btn-primary w-100 fw-bold">
                            <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cart Table -->
            <div class="card card-premium shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-cart-shopping text-success me-2"></i>Dispensing Cart Items</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCart()">Clear</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="cartTable">
                        <thead class="table-light">
                            <tr>
                                <th>Medicine Item</th>
                                <th style="width: 120px;">Unit Price (৳)</th>
                                <th style="width: 130px;">Quantity</th>
                                <th style="width: 140px;" class="text-end">Total (৳)</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <tr id="emptyCartRow">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fa-solid fa-basket-shopping fs-1 mb-2 opacity-50"></i>
                                    <p class="mb-0">No medicines in dispensing cart. Select a medicine above.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Patient Info & Checkout -->
        <div class="col-lg-4">
            <div class="card card-premium shadow-sm p-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user me-2 text-primary"></i>Customer / Patient</h6>

                <div class="mb-3">
                    <label class="form-label">Inpatient Account (Charge to IPD)</label>
                    <select name="admission_id" id="admissionSelect" class="form-select" onchange="checkIpd(this.value)">
                        <option value="">-- Walk-in / Direct Cash --</option>
                        @foreach($admissions as $adm)
                            <option value="{{ $adm->id }}" data-patient-id="{{ $adm->patient_id }}" data-patient-name="{{ $adm->patient->name }}" data-patient-phone="{{ $adm->patient->mobile }}">
                                {{ $adm->bed->bed_number ?? 'Bed' }} - {{ $adm->patient->name }} ({{ $adm->admission_no }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="walkinFields">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" id="custName" class="form-control" value="Walk-in Customer">
                    <label class="form-label mt-2">Mobile Number</label>
                    <input type="text" name="customer_phone" id="custPhone" class="form-control" placeholder="017xxxxxxxx">
                </div>

                <hr>

                <!-- Payment Summary -->
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-receipt text-success me-2"></i>Bill Summary</h6>

                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Subtotal:</span>
                    <strong class="text-dark">৳ <span id="subtotalDisplay">0.00</span></strong>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Discount (৳):</span>
                        <input type="number" step="0.01" name="discount" id="discountInput" class="form-control form-control-sm text-end" value="0.00" style="width: 110px;" oninput="calculateTotals()">
                    </div>
                </div>

                <div class="d-flex justify-content-between py-2 border-top border-bottom mt-2 mb-3">
                    <span class="fs-5 fw-bold text-dark">Grand Total:</span>
                    <strong class="fs-4 text-success">৳ <span id="grandTotalDisplay">0.00</span></strong>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Payment Method</label>
                    <select name="payment_method" id="paymentMethodSelect" class="form-select" required>
                        <option value="Cash" selected>Cash</option>
                        <option value="Card">Credit / Debit Card</option>
                        <option value="bKash">bKash</option>
                        <option value="Nagad">Nagad</option>
                        <option value="IPD Credit">IPD Credit (Add to Hospital Bill)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm" id="checkoutBtn" disabled>
                    <i class="fa-solid fa-check-circle me-1"></i> Complete & Print Bill
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let cart = [];

    document.getElementById('addItemBtn').addEventListener('click', function() {
        const selector = document.getElementById('medicineSelector');
        const medId = selector.value;
        if (!medId) return;

        const opt = selector.options[selector.selectedIndex];
        const name = opt.getAttribute('data-name');
        const price = parseFloat(opt.getAttribute('data-price')) || 0;
        const stock = parseInt(opt.getAttribute('data-stock')) || 0;

        const existing = cart.find(i => i.id == medId);
        if (existing) {
            if (existing.qty < stock) {
                existing.qty++;
            } else {
                alert('Cannot exceed available stock of ' + stock);
            }
        } else {
            cart.push({ id: medId, name: name, price: price, qty: 1, stock: stock });
        }

        renderCart();
    });

    function renderCart() {
        const tbody = document.getElementById('cartTableBody');
        const emptyRow = document.getElementById('emptyCartRow');
        const checkoutBtn = document.getElementById('checkoutBtn');

        if (cart.length === 0) {
            tbody.innerHTML = `
                <tr id="emptyCartRow">
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fa-solid fa-basket-shopping fs-1 mb-2 opacity-50"></i>
                        <p class="mb-0">No medicines in dispensing cart. Select a medicine above.</p>
                    </td>
                </tr>`;
            checkoutBtn.disabled = true;
            calculateTotals();
            return;
        }

        checkoutBtn.disabled = false;
        let html = '';

        cart.forEach((item, index) => {
            const rowTotal = item.price * item.qty;
            html += `
                <tr>
                    <td>
                        <input type="hidden" name="items[${index}][medicine_id]" value="${item.id}">
                        <strong>${item.name}</strong><br>
                        <small class="text-muted">Stock: ${item.stock}</small>
                    </td>
                    <td>৳ ${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" name="items[${index}][quantity]" value="${item.qty}" min="1" max="${item.stock}" 
                               class="form-control form-control-sm" onchange="updateQty(${index}, this.value)">
                    </td>
                    <td class="text-end fw-bold text-dark">৳ ${rowTotal.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-circle" onclick="removeItem(${index})">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        calculateTotals();
    }

    function updateQty(index, val) {
        let q = parseInt(val) || 1;
        if (q > cart[index].stock) q = cart[index].stock;
        if (q < 1) q = 1;
        cart[index].qty = q;
        renderCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function calculateTotals() {
        let subtotal = 0;
        cart.forEach(i => subtotal += (i.price * i.qty));
        const discount = parseFloat(document.getElementById('discountInput').value) || 0;
        const grandTotal = Math.max(0, subtotal - discount);

        document.getElementById('subtotalDisplay').innerText = subtotal.toFixed(2);
        document.getElementById('grandTotalDisplay').innerText = grandTotal.toFixed(2);
    }

    function checkIpd(admissionId) {
        const paySelect = document.getElementById('paymentMethodSelect');
        const admSelect = document.getElementById('admissionSelect');
        const opt = admSelect.options[admSelect.selectedIndex];

        if (admissionId) {
            document.getElementById('custName').value = opt.getAttribute('data-patient-name') || '';
            document.getElementById('custPhone').value = opt.getAttribute('data-patient-phone') || '';
            paySelect.value = 'IPD Credit';
        } else {
            document.getElementById('custName').value = 'Walk-in Customer';
            document.getElementById('custPhone').value = '';
            paySelect.value = 'Cash';
        }
    }
</script>
@endpush
