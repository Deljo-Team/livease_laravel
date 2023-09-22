<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'email',
        'password',
        'country_code',
        'phone',
        'is_email_verified',
        'email_verified_at',
        'latitude',
        'longitude',
        'avatar',
        'type',
        'remember_token',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the vendor company associated with the user.
     */
    public function vendor_company()
    {
        return $this->hasOne(VendorCompany::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'users_locations', 'user_id', 'location_id');
    }

    public function sub_locations()
    {
        return $this->belongsToMany(SubLocation::class, 'users_sub_locations', 'user_id', 'sub_location_id');
    }

    public function scopeCustomers($query)
    {
        return $query->where('type', 'customer');
    }

    public function scopeVendors($query)
    {
        return $query->where('type', 'vendor');
    }
}
