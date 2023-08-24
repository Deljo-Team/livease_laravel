<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => config('app.url') . '/storage/' . $value,
        );
    }
    protected function signature(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => config('app.url') . '/storage/' . $value,
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicemen()
    {
        return $this->hasMany(Servicemen::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'vendor_company_categories')
            ->withTimestamps();
    }
    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class, 'vendor_company_sub_categories')
            ->withTimestamps();
    }
}
