<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'team',
        'avatar',
        'is_active',
        'last_login',
        'created_at',
        'updated_at',
        'pref_dark_mode',
        'pref_email_notifications',
        'pref_sla_alerts',
        'pref_downtime_alerts',
        'pref_digest_frequency',
        'pref_quiet_hours'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
}
