<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'asset_types_id',
        'asset_name',
        'description',
        'service_category_id',
        'sub_category_id',
        'reminder_date',
        'expire_date',
        'date',
        'email',
        'nominee_name',
        'nominee_phone_number',
        'alternative_name',
        'alternative_phone',
        'status'
    ];
}
