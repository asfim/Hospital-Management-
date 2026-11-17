<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $attendanceDate = $request->get('attendance_date', date('Y-m-d'));
        $monthYear = $request->get('month_year', date('Y-m'));

        $staffList = Staff::orderBy('name')->get();

        // Attendance records for the selected date
        $attendances = StaffAttendance::with('staff')
            ->whereDate('date', $attendanceDate)
            ->get()
            ->keyBy('staff_id');

        // Salary payments for the selected month
        $salaries = SalaryPayment::with('staff')
            ->where('month_year', $monthYear)
            ->latest('payment_date')
            ->get();

        $totalDisbursed = $salaries->where('status', 'Paid')->sum('net_salary');
        $totalPending = $salaries->where('status', '!=', 'Paid')->sum('net_salary');

        return view('payroll.index', compact(
            'staffList',
            'attendanceDate',
            'monthYear',
            'attendances',
            'salaries',
            'totalDisbursed',
            'totalPending'
        ));
    }

    public function markAttendance(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late,On Leave',
            'sign_in' => 'nullable',
            'sign_out' => 'nullable',
        ]);

        StaffAttendance::updateOrCreate(
            [
                'staff_id' => $validated['staff_id'],
                'date' => $validated['date'],
            ],
            [
                'status' => $validated['status'],
                'sign_in' => $validated['sign_in'],
                'sign_out' => $validated['sign_out'],
            ]
        );

        return redirect()->route('payroll.index', ['attendance_date' => $validated['date']])
            ->with('success', 'Staff attendance updated successfully.');
    }

    public function storeSalary(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'month_year' => 'required|string|max:20',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'status' => 'required|in:Paid,Pending,Cancelled',
        ]);

        $allowances = $validated['allowances'] ?? 0;
        $deductions = $validated['deductions'] ?? 0;
        $netSalary = $validated['basic_salary'] + $allowances - $deductions;

        $salary = SalaryPayment::updateOrCreate(
            [
                'staff_id' => $validated['staff_id'],
                'month_year' => $validated['month_year'],
            ],
            [
                'basic_salary' => $validated['basic_salary'],
                'allowances' => $allowances,
                'deductions' => $deductions,
                'net_salary' => $netSalary,
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
            ]
        );

        return redirect()->route('payroll.index', ['month_year' => $validated['month_year']])
            ->with('success', "Salary record for {$validated['month_year']} saved successfully.");
    }

    public function payslip(SalaryPayment $salaryPayment)
    {
        $salaryPayment->load('staff');
        return view('payroll.payslip', compact('salaryPayment'));
    }
}
