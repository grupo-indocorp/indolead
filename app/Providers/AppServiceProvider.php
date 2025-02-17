<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::directive('formatSizeUnits', function ($bytes) {
            return "<?php 
            if ($bytes >= 1073741824) {
                echo number_format($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                echo number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                echo number_format($bytes / 1024, 2) . ' KB';
            } else {
                echo $bytes . ' bytes';
            }
        ?>";
        });
    }
}
