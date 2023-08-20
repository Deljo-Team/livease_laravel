<?php

namespace App\Providers;

use App\Interfaces\FileStorageInterface;
use App\Services\MobileOtpAdapter;
use App\Interfaces\OtpInterface;
use App\Services\EmailOtpAdapter;
use App\Services\FileStorageAdapter;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::useVite();
        $this->app->singleton(OtpInterface::class, function ($app) {
            switch ($app->make('config')->get('services.otp.interface')) {
                case 'email':
                    return new EmailOtpAdapter;
                default:
                    throw new \RuntimeException("Unknown OTP Service");
            }
        });  

        $this->app->singleton(FileStorageInterface::class, function ($app) {
            switch ($app->make('config')->get('services.file.interface')) {
                case 'file':
                    return new FileStorageAdapter;
                default:
                    throw new \RuntimeException("Unknown File Service");
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
