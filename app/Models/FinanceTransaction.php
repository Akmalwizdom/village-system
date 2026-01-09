<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FinanceTransaction extends Model
{
    protected $fillable = [
        'finance_category_id',
        'type',
        'amount',
        'description',
        'transaction_date',
        'reference_number',
        'created_by',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    /**
     * Get the category for this transaction.
     */
    public function category()
    {
        return $this->belongsTo(FinanceCategory::class, 'finance_category_id');
    }

    /**
     * Get the user who created this transaction.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for income transactions.
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope for expense transactions.
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope for transactions in a specific month.
     */
    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('transaction_date', $year)
                     ->whereMonth('transaction_date', $month);
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get type label with badge.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'income' 
            ? '<span class="badge bg-success">Pemasukan</span>'
            : '<span class="badge bg-danger">Pengeluaran</span>';
    }

    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->transaction_date)->format('d M Y');
    }
}
