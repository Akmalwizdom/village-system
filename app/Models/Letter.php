<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Letter extends Model
{
    protected $fillable = [
        'letter_number',
        'letter_template_id',
        'resident_id',
        'purpose',
        'generated_content',
        'qr_code',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($letter) {
            // Generate unique letter number
            $letter->letter_number = $letter->generateLetterNumber();
            
            // Generate QR code hash
            $letter->qr_code = $letter->generateQrCode();
        });
    }

    /**
     * Get the template for this letter.
     */
    public function template()
    {
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id');
    }

    /**
     * Get the resident who requested this letter.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the user who approved this letter.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Generate unique letter number.
     */
    public function generateLetterNumber(): string
    {
        $template = LetterTemplate::find($this->letter_template_id);
        $code = $template ? $template->code : 'SRT';
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        
        // Get the last letter number for this month
        $lastLetter = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastLetter ? ((int) Str::afterLast($lastLetter->letter_number, '/') + 1) : 1;
        
        return sprintf('%s/%s/%s/%04d', $code, $month, $year, $sequence);
    }

    /**
     * Generate unique QR code hash.
     */
    public function generateQrCode(): string
    {
        return hash('sha256', Str::uuid() . time() . Str::random(16));
    }

    /**
     * Generate the letter content from template.
     */
    public function generateContent(): string
    {
        $template = $this->template;
        $resident = $this->resident;
        
        if (!$template || !$resident) {
            return '';
        }

        $content = $template->content;

        // Replace placeholders
        $replacements = [
            '{{nama}}' => $resident->name,
            '{{nik}}' => $resident->nik,
            '{{tempat_lahir}}' => $resident->birth_place,
            '{{tanggal_lahir}}' => Carbon::parse($resident->birth_date)->format('d F Y'),
            '{{jenis_kelamin}}' => $resident->gender == 'male' ? 'Laki-laki' : 'Perempuan',
            '{{agama}}' => $resident->religion ?? '-',
            '{{pekerjaan}}' => $resident->occupation ?? '-',
            '{{alamat}}' => $resident->address,
            '{{keperluan}}' => $this->purpose,
            '{{nomor_surat}}' => $this->letter_number,
            '{{tanggal_surat}}' => Carbon::now()->format('d F Y'),
        ];

        foreach ($replacements as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        return $content;
    }

    /**
     * Get verification URL for QR code.
     */
    public function getVerificationUrl(): string
    {
        return url('/verify-letter/' . $this->qr_code);
    }

    /**
     * Get status label with badge.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'approved' => '<span class="badge bg-success">Disetujui</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
            default => '<span class="badge bg-secondary">-</span>',
        };
    }
}
