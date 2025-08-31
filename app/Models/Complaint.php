<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'new' => '<span class="badge bg-secondary">Baru</span>',
            'Processing' => '<span class="badge bg-warning">Sedang Diproses</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            default => '<span class="badge bg-danger">Tidak Diketahui</span>',
        };
    }

    public function getReportDateLabelAtAttribute()
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y, H:i:s');
    }
}
