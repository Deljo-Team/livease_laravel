<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reminder',
        'date_time',
        'person_name',
        'reminder_type',
        'alert',
        'icon',
        'status'
    ];
}
