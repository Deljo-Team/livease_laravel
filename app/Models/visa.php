<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visa extends Model
{
    use HasFactory;
    protected $table = 'visa';
    protected $fillable = [
        'visa',
        'status',
    ];
}
