<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Country::class);
    }

    public function sub_locations()
    {
        return $this->hasMany(SubLocation::class);
    }
}
