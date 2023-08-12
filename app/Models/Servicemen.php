<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicemen extends Model
{
    use HasFactory;
    
    public function vendor_company()
    {
        return $this->belongsTo(VendorCompany::class);
    }
}
