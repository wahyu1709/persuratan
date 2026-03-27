<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'required_fields',
        'division_id',
        'active',
    ];

    protected $casts = [
        'required_fields' => 'array',
        'active' => 'boolean',
    ];

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function letters(){
        return $this->hasMany(Letter::class);
    }

    public function scopeActive($query){
        return $query->where('active', true);
    }
}
