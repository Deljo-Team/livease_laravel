<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'comapny_type',
        'email',
        'phone',
        'category_id',
        'sub_category_id',
        'country_id',
        'latitude',
        'longitude',
        'logo',
        'signature',
        'is_admin_verified',
        'status',
    ];
}
