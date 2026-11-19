<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\DiagnosticOrder;
use App\Models\PharmacySale;
use App\Models\Admission;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // 1. Revenue Streams
        // A. OPD & General Invoices
        $invoiceIncome = Invoice::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('paid');
        $invoiceDue = Invoice::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('due');

        // B. Lab & Diagnostic Orders
        $labIncome = DiagnosticOrder::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('paid_amount');
        $labDue = DiagnosticOrder::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('due_amount');

        // C. Pharmacy Sales
        $pharmacyIncome = PharmacySale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('paid');
        $pharmacyDue = PharmacySale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('due');

        // D. IPD Admissions Deposits
        $ipdIncome = Admission::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('total_deposit');

        // Total Hospital Income & Receivables
        $totalIncome = $invoiceIncome + $labIncome + $pharmacyIncome + $ipdIncome;
        $totalDue = $invoiceDue + $labDue + $pharmacyDue;

        // 2. Hospital Expenses
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;

        // Category breakdown of expenses
        $expenseCategories = ExpenseCategory::withSum(['expenses' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        }], 'amount')->get();

        // Recent Invoices
        $recentInvoices = Invoice::with('patient')->latest()->take(15)->get();

        // Recent Expenses
        $recentExpenses = Expense::with('category')->latest()->take(15)->get();

        return view('accounts.index', compact(
            'startDate',
            'endDate',
            'invoiceIncome',
            'invoiceDue',
            'labIncome',
            'labDue',
            'pharmacyIncome',
            'pharmacyDue',
            'ipdIncome',
            'totalIncome',
            'totalDue',
            'totalExpenses',
            'netBalance',
            'expenseCategories',
            'recentInvoices',
            'recentExpenses'
        ));
    }
}
