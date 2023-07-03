<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;



class Otp extends Model
{
    use HasFactory, Prunable;

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('expires_at', '<', now()->addMinutes(2));
    }

    protected $fillable = [
        'otp',
        'token',
        'user_id',
        'type',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
