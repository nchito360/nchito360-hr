<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{

    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'company_id',
        'position',
        'department',
        'branch',
        'profile_picture',
        'employment_status', // Added employment status
        'privileges', // Added privileges
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
            'contract_start_date' => 'date',
        ];
    }

public function company()
{
    return $this->belongsTo(Company::class, 'company_id');
}

public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPassword($token));
}

public function leaves()
{
    return $this->hasMany(Leave::class);
}

/**
 * Get total used leave days (only approved leaves)
 */
public function getUsedLeaveDays(): int
{
    return $this->leaves()
        ->where('status', 'approved')
        ->get()
        ->sum(function ($leave) {
            return $leave->start_date->diffInDays($leave->end_date) + 1;
        });
}

/**
 * Get remaining leave days based on a fixed annual entitlement
 */
public function getRemainingLeaveDays(int $entitlement = 30): int
{
    return max(0, $entitlement - $this->getUsedLeaveDays());
}

   

}