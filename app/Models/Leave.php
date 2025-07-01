<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'manager_comment',
        'approved_by',
        'supporting_document', // New field for supporting document
    ];

    /**
     * The user who applied for the leave.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The company the leave belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * The manager who approved/rejected the leave.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: Filter by pending leaves.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if leave is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if leave is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
