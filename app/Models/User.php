<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'team',
    'avatar',
    'is_active',
    'last_login',
    'pref_dark_mode',
    'pref_email_notifications',
    'pref_sla_alerts',
    'pref_downtime_alerts',
    'pref_digest_frequency',
    'pref_quiet_hours'
])]

#[Hidden([
    'password',
    'remember_token',
])]

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    // Helpers
    public function isItStaff(): bool
    {
        return $this->role === 'it_staff';
    }

    public const ROLES = [
        'admin',
        'team_lead',
        'it_staff',
        'reporter',
    ];

    public const TEAMS = [
        'programmer',
        'network',
        'hardware',
    ];

    public const PREF_DIGEST_FREQUENCIES = [
        'immediate',
        'hourly',
        'daily',
        'weekly',
    ];

    // Relations
    public function reporter()
    {
        return $this->hasMany(Ticket::class, 'reporter_id');
    }

    public function assignee()
    {
        return $this->hasMany(Ticket::class, 'assigned_to_id');
    }

    public function convertBy()
    {
        return $this->hasMany(Ticket::class, 'converted_by');
    }
}
