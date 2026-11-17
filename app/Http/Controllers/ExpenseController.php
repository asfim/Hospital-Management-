<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $categoryId = $request->get('category_id');

        $query = Expense::with(['category', 'creator'])
            ->whereBetween('date', [$startDate, $endDate])
            ->latest('date');

        if ($categoryId) {
            $query->where('expense_category_id', $categoryId);
        }

        $expenses = $query->paginate(20);
        $categories = ExpenseCategory::all();

        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $todayExpenses = Expense::whereDate('date', today())->sum('amount');

        return view('expenses.index', compact('expenses', 'categories', 'totalExpenses', 'todayExpenses', 'startDate', 'endDate', 'categoryId'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('status', true)->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'payment_method' => 'required|string',
            'reference_no' => 'nullable|string|max:100',
            'note' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Hospital expense voucher recorded successfully!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense record deleted.');
    }
}
