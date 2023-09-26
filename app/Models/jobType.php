<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobType extends Model
{
    use HasFactory;
    protected $table = 'job_type';
    protected $fillable = [
        'job_type',
        'status',
    ];
}
