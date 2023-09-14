<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\FileStorageInterface;

class Servicemen extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'vendor_company_id',
        'id_proof',
        'category_id',
        'sub_category_id',
        'is_available',
        'is_verified',
    ];
    // protected function idProof(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => config('app.url') . '/storage/' . $value,
    //     );
    // }
    protected function idProof(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $storage = app(FileStorageInterface::class);
                return $storage->getBase64File($value);
            } 
        );
    }
    public function vendor_company()
    {
        return $this->belongsTo(VendorCompany::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'servicemen_categories')
            ->withTimestamps();
    }
    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class, 'servicemen_sub_categories')
            ->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
