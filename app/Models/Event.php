<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'location',
        'start_date',
        'end_date',
        'is_all_day',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_all_day' => 'boolean',
    ];

    /**
     * Category labels.
     */
    public const CATEGORIES = [
        'rapat' => 'Rapat',
        'gotong_royong' => 'Gotong Royong',
        'pelatihan' => 'Pelatihan',
        'acara_desa' => 'Acara Desa',
        'lainnya' => 'Lainnya',
    ];

    /**
     * Category colors for calendar.
     */
    public const CATEGORY_COLORS = [
        'rapat' => '#3b82f6',
        'gotong_royong' => '#10b981',
        'pelatihan' => '#f59e0b',
        'acara_desa' => '#8b5cf6',
        'lainnya' => '#6b7280',
    ];

    /**
     * Get the user who created this event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    /**
     * Get category color.
     */
    public function getCategoryColorAttribute(): string
    {
        return self::CATEGORY_COLORS[$this->category] ?? '#6b7280';
    }

    /**
     * Get category badge.
     */
    public function getCategoryBadgeAttribute(): string
    {
        $color = $this->category_color;
        return "<span class=\"badge\" style=\"background-color: {$color};\">{$this->category_label}</span>";
    }

    /**
     * Get formatted start date.
     */
    public function getFormattedStartDateAttribute(): string
    {
        if ($this->is_all_day) {
            return $this->start_date->format('d M Y');
        }
        return $this->start_date->format('d M Y, H:i');
    }

    /**
     * Get formatted date range.
     */
    public function getDateRangeAttribute(): string
    {
        if ($this->is_all_day) {
            if ($this->end_date && $this->start_date->format('Y-m-d') !== $this->end_date->format('Y-m-d')) {
                return $this->start_date->format('d M') . ' - ' . $this->end_date->format('d M Y');
            }
            return $this->start_date->format('d M Y');
        }
        
        if ($this->end_date) {
            if ($this->start_date->format('Y-m-d') === $this->end_date->format('Y-m-d')) {
                return $this->start_date->format('d M Y, H:i') . ' - ' . $this->end_date->format('H:i');
            }
            return $this->start_date->format('d M Y, H:i') . ' - ' . $this->end_date->format('d M Y, H:i');
        }
        
        return $this->start_date->format('d M Y, H:i');
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
                     ->orderBy('start_date', 'asc');
    }

    /**
     * Scope for events in a month.
     */
    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('start_date', $year)
                     ->whereMonth('start_date', $month);
    }
}
