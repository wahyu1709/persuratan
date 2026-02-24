<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'nip',
        'role',
        'division_id',
        'study_level',
        'semester',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function submittedLetters(){
        return $this->hasMany(Letter::class, 'user_id');
    }

    public function approvedLetters(){
        return $this->hasMany(Letter::class, 'approved_by');
    }

    public function isStudent(){
        return $this->role === 'mahasiswa';
    }

    public function isStaff(){
        return in_array($this->role, ['staff', 'ketua_divisi']);
    }

    public function isDivisionHead(){
        return $this->role === 'ketua_divisi';
    }
}
