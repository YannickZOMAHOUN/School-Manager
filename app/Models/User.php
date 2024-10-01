<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_fa_expires_at' => 'datetime', // Cast added here
    ];

    // Relationship with School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Relationship with Staff
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    // Reset 2FA code and expiration
    public function resetTwoFactorCode()
    {
        $this->two_fa_code = null;
        $this->two_fa_expires_at = null;
        $this->save();
    }
}
