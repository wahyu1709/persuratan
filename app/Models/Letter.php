<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'letter_type_id',
        'status',
        'data',
        'file_path',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'data' => 'array',
        'approved_at' => 'datetime',
    ];

    public function student(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function letterType(){
        return $this->belongsTo(LetterType::class);
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeForCurrentUserDivision($query){
        if (auth()->check() && auth()->user()->isStaff()){
            return $query->whereHas('letterType', function($q){
                $q->where('division_id', auth()->user()->division_id);
            });
        }
        return $query;
    }

    public function scopePending($query){
        return $query->where('status', 'menunggu');
    }

    public function scopeApproved($query){
        return $query->where('status', 'disetujui');
    }

    public function scopeRejected($query){
        return $query->where('status', 'ditolak');
    }
}
