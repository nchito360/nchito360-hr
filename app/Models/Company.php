<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'logo',
        'description',
        'industry',
        'branches',
        'departments',
        'website',
        'email',
        'company_code',
    ];

    protected $casts = [
        'branches' => 'array',
        'departments' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

}
