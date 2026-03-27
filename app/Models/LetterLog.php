<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterLog extends Model
{
    protected $fillable = [
        'letter_id',
        'user_id',
        'action',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: hanya untuk satu surat
    public function scopeForLetter($query, $letterId)
    {
        return $query->where('letter_id', $letterId);
    }

    // Helper: deskripsi aksi dalam bahasa manusia
    public function getActionLabelAttribute()
    {
        return match($this->action) {
            'submitted' => 'Diajukan',
            'verified' => 'Diverifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->action),
        };
    }
}