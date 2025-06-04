<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JoinCompanyRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}

