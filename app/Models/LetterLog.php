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

    public function getActionColorClassAttribute()
    {
        return match($this->action) {
            'submitted' => 'bg-primary',
            'verified' => 'bg-warning',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            'cancelled' => 'bg-secondary',
            default => 'bg-gray-500',
        };
    }

    public function getActionDotColorAttribute()
    {
        return match($this->action) {
            'submitted' => 'bg-blue-500',
            'verified' => 'bg-yellow-500',
            'approved' => 'bg-green-500',
            'rejected' => 'bg-red-500',
            'cancelled' => 'bg-gray-500',
            default => 'bg-gray-400',
        };
    }
}