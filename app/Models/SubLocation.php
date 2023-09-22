<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
