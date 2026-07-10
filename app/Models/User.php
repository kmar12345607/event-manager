<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Helper : est-ce un admin ?
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Helper : est-ce un participant ?
    public function isParticipant(): bool
    {
        return $this->role === 'participant';
    }

    // Helper : le compte a-t-il confirmé son email ? (1/0 côté DB via email_verified_at)
    public function isVerified(): bool
    {
        return ! is_null($this->email_verified_at);
    }
}