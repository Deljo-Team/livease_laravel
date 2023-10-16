<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GeneralServices;
class Service extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();
        static::created(function ($service) {
            $id = $service->id;
            $service = Service::find($id);
            $generalServices = new GeneralServices();
            $orderId = $generalServices->generateUniqueOrderId($id, $service->user_id);
            $service->update([
                'order_id' => $orderId
            ]);
        });
    }
    protected $fillable = [
        'user_id',
        'order_id'
    ];
    
}

