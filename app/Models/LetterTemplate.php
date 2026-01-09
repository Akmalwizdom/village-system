<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterTemplate extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all letters using this template.
     */
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    /**
     * Scope to get only active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get available placeholders for this template.
     */
    public static function getAvailablePlaceholders(): array
    {
        return [
            '{{nama}}' => 'Nama Lengkap',
            '{{nik}}' => 'NIK',
            '{{tempat_lahir}}' => 'Tempat Lahir',
            '{{tanggal_lahir}}' => 'Tanggal Lahir',
            '{{jenis_kelamin}}' => 'Jenis Kelamin',
            '{{agama}}' => 'Agama',
            '{{pekerjaan}}' => 'Pekerjaan',
            '{{alamat}}' => 'Alamat',
            '{{keperluan}}' => 'Keperluan Surat',
            '{{nomor_surat}}' => 'Nomor Surat',
            '{{tanggal_surat}}' => 'Tanggal Surat',
            '{{qr_code}}' => 'QR Code Verifikasi',
        ];
    }
}
