<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'account_no',
        'ifse',
        'image',
        'percentage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
