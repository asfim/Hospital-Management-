<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - {{ $salaryPayment->staff->name ?? 'Staff' }} - {{ $salaryPayment->month_year }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; }
        .payslip-container { max-width: 800px; margin: 30px auto; background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
        .hospital-header { border-bottom: 2px solid #0d9488; padding-bottom: 20px; margin-bottom: 25px; }
        .table th { background-color: #f1f5f9; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
        @media print {
            body { background: #fff; }
            .payslip-container { margin: 0; padding: 20px; box-shadow: none; border: none; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="container text-center my-3 no-print">
    <button onclick="window.print()" class="btn btn-primary px-4 py-2 fw-semibold">
        <i class="fa-solid fa-print me-2"></i> Print Payslip
    </button>
    <button onclick="window.close()" class="btn btn-outline-secondary px-4 py-2 ms-2">
        <i class="fa-solid fa-xmark me-2"></i> Close
    </button>
</div>

<div class="payslip-container">
    <div class="hospital-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="color: #0f172a !important;">
                <i class="fa-solid fa-hospital text-teal me-2" style="color: #0d9488;"></i>DHAKA CENTRAL HOSPITAL
            </h3>
            <p class="text-muted small mb-0">House 12, Road 5, Dhanmondi, Dhaka-1205 | Tel: +880 2-9660000</p>
        </div>
        <div class="text-end">
            <span class="badge bg-success fs-6 px-3 py-2 text-uppercase">{{ $salaryPayment->status }}</span>
            <div class="small text-muted mt-1">Payment Ref: SAL-{{ str_pad($salaryPayment->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold text-uppercase" style="letter-spacing: 1px; color: #334155;">Salary & Compensation Voucher</h5>
        <p class="text-muted small mb-0">Pay Period: <strong class="text-dark">{{ $salaryPayment->month_year }}</strong> | Payment Date: {{ \Carbon\Carbon::parse($salaryPayment->payment_date)->format('d F, Y') }}</p>
    </div>

    <div class="card bg-light border-0 rounded-3 p-3 mb-4">
        <div class="row g-2">
            <div class="col-6">
                <div class="text-muted small">EMPLOYEE NAME:</div>
                <div class="fw-bold text-dark fs-6">{{ $salaryPayment->staff->name ?? 'Staff Member' }}</div>
            </div>
            <div class="col-6">
                <div class="text-muted small">DESIGNATION:</div>
                <div class="fw-bold text-dark fs-6">{{ $salaryPayment->staff->designation ?? 'Hospital Staff' }}</div>
            </div>
            <div class="col-6">
                <div class="text-muted small">CONTACT NUMBER:</div>
                <div class="fw-medium text-dark">{{ $salaryPayment->staff->phone ?? 'N/A' }}</div>
            </div>
            <div class="col-6">
                <div class="text-muted small">PAYMENT METHOD:</div>
                <div class="fw-medium text-dark">{{ $salaryPayment->payment_method }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card h-100 border">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0 fw-bold text-success"><i class="fa-solid fa-plus-circle me-1"></i> Earnings</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td>Basic Salary</td>
                                <td class="text-end fw-semibold">৳{{ number_format($salaryPayment->basic_salary, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Allowances & Incentives</td>
                                <td class="text-end fw-semibold text-success">+৳{{ number_format($salaryPayment->allowances, 2) }}</td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td>Total Earnings</td>
                                <td class="text-end">৳{{ number_format($salaryPayment->basic_salary + $salaryPayment->allowances, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card h-100 border">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0 fw-bold text-danger"><i class="fa-solid fa-minus-circle me-1"></i> Deductions</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td>Tax / PF / Fine Deductions</td>
                                <td class="text-end fw-semibold text-danger">-৳{{ number_format($salaryPayment->deductions, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Other Adjustments</td>
                                <td class="text-end text-muted">৳0.00</td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td>Total Deductions</td>
                                <td class="text-end text-danger">-৳{{ number_format($salaryPayment->deductions, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25 p-3 rounded-3 mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-primary mb-0">NET SALARY PAYABLE:</h5>
                <small class="text-muted">Transferred via {{ $salaryPayment->payment_method }}</small>
            </div>
            <div class="fs-3 fw-bolder text-primary">৳{{ number_format($salaryPayment->net_salary, 2) }}</div>
        </div>
    </div>

    <div class="row pt-5 mt-4 text-center">
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <small class="text-muted fw-semibold">Employee Signature</small>
            </div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <small class="text-muted fw-semibold">HR Officer</small>
            </div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-3">
                <small class="text-muted fw-semibold">Accounts / Director</small>
            </div>
        </div>
    </div>

    <div class="text-center text-muted small mt-5 pt-3 border-top">
        This is a system generated salary payslip from Dhaka Central Hospital Management System (HMS).
    </div>
</div>

</body>
</html>
