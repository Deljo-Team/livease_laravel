<?php

namespace App\Providers;

use App\Services\MobileOtpAdapter;
use App\Interfaces\OtpInterface;
use App\Services\EmailOtpAdapter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OtpInterface::class, function ($app) {
            switch ($app->make('config')->get('services.otp.interface')) {
                case 'phone':
                    return new MobileOtpAdapter;
                case 'email':
                    return new EmailOtpAdapter;
                default:
                    throw new \RuntimeException("Unknown OTP Service");
            }
        });  
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
