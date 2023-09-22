<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Countries;
use App\Models\SubLocation;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'slug',
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function sub_locations()
    {
        return $this->hasMany(SubLocation::class);
    }
}
