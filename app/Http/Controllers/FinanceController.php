<?php

namespace App\Http\Controllers;

use App\Models\FinanceCategory;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Display finance dashboard.
     */
    public function dashboard()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Current month statistics
        $incomeThisMonth = FinanceTransaction::income()
            ->inMonth($currentYear, $currentMonth)
            ->sum('amount');

        $expenseThisMonth = FinanceTransaction::expense()
            ->inMonth($currentYear, $currentMonth)
            ->sum('amount');

        $balanceThisMonth = $incomeThisMonth - $expenseThisMonth;

        // Total all time
        $totalIncome = FinanceTransaction::income()->sum('amount');
        $totalExpense = FinanceTransaction::expense()->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;

        // Recent transactions
        $recentTransactions = FinanceTransaction::with('category', 'creator')
            ->latest('transaction_date')
            ->take(10)
            ->get();

        // Monthly summary for chart (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'income' => FinanceTransaction::income()->inMonth($date->year, $date->month)->sum('amount'),
                'expense' => FinanceTransaction::expense()->inMonth($date->year, $date->month)->sum('amount'),
            ];
        }

        return view('pages.finance.dashboard', compact(
            'incomeThisMonth',
            'expenseThisMonth',
            'balanceThisMonth',
            'totalIncome',
            'totalExpense',
            'totalBalance',
            'recentTransactions',
            'monthlyData'
        ));
    }

    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        $query = FinanceTransaction::with('category', 'creator');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('finance_category_id', $request->category);
        }

        // Filter by month
        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $query->inMonth($date->year, $date->month);
        }

        $transactions = $query->latest('transaction_date')->paginate(15);
        $categories = FinanceCategory::active()->get();

        return view('pages.finance.index', compact('transactions', 'categories'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $categories = FinanceCategory::active()->get()->groupBy('type');
        
        return view('pages.finance.create', compact('categories'));
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'finance_category_id' => 'required|exists:finance_categories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:500',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
        ]);

        $category = FinanceCategory::find($request->finance_category_id);

        FinanceTransaction::create([
            'finance_category_id' => $request->finance_category_id,
            'type' => $category->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'reference_number' => $request->reference_number,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a transaction.
     */
    public function edit(FinanceTransaction $transaction)
    {
        $categories = FinanceCategory::active()->get()->groupBy('type');
        
        return view('pages.finance.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, FinanceTransaction $transaction)
    {
        $request->validate([
            'finance_category_id' => 'required|exists:finance_categories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:500',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
        ]);

        $category = FinanceCategory::find($request->finance_category_id);

        $transaction->update([
            'finance_category_id' => $request->finance_category_id,
            'type' => $category->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'reference_number' => $request->reference_number,
        ]);

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(FinanceTransaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Display monthly report.
     */
    public function report(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($month);

        $transactions = FinanceTransaction::with('category')
            ->inMonth($date->year, $date->month)
            ->orderBy('transaction_date')
            ->get();

        $incomeTotal = $transactions->where('type', 'income')->sum('amount');
        $expenseTotal = $transactions->where('type', 'expense')->sum('amount');
        $balance = $incomeTotal - $expenseTotal;

        // Group by category
        $incomeByCategory = $transactions->where('type', 'income')
            ->groupBy('finance_category_id')
            ->map(fn($items) => [
                'category' => $items->first()->category->name,
                'total' => $items->sum('amount'),
            ]);

        $expenseByCategory = $transactions->where('type', 'expense')
            ->groupBy('finance_category_id')
            ->map(fn($items) => [
                'category' => $items->first()->category->name,
                'total' => $items->sum('amount'),
            ]);

        return view('pages.finance.report', compact(
            'month',
            'date',
            'transactions',
            'incomeTotal',
            'expenseTotal',
            'balance',
            'incomeByCategory',
            'expenseByCategory'
        ));
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($month);

        $transactions = FinanceTransaction::with('category')
            ->inMonth($date->year, $date->month)
            ->orderBy('transaction_date')
            ->get();

        $incomeTotal = $transactions->where('type', 'income')->sum('amount');
        $expenseTotal = $transactions->where('type', 'expense')->sum('amount');
        $balance = $incomeTotal - $expenseTotal;

        $pdf = Pdf::loadView('pages.finance.report-pdf', compact(
            'date',
            'transactions',
            'incomeTotal',
            'expenseTotal',
            'balance'
        ));

        $filename = 'Laporan_Keuangan_' . $date->format('F_Y') . '.pdf';
        
        return $pdf->download($filename);
    }
}
