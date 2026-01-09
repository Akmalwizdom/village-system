<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceCategory extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all transactions for this category.
     */
    public function transactions()
    {
        return $this->hasMany(FinanceTransaction::class);
    }

    /**
     * Scope for active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for income categories.
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope for expense categories.
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'income' 
            ? '<span class="badge bg-success">Pemasukan</span>'
            : '<span class="badge bg-danger">Pengeluaran</span>';
    }
}
