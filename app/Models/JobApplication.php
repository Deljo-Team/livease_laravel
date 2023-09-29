<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'linked_in_link',
        'visa_validity',
        'gender_id',
        'job_type_id',
        'experience_level',
        'current_job_id',
        'desire_job_id',
        'visa_type_id',
        'image',
        'cv',
        'proof',
        'note',
        'present_company',
        'present_salary',
        'expected_salary',
        'experience',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

