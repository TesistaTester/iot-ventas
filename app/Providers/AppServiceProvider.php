<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Modificando la plantilla por defecto del paginator
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        Paginator::defaultSimpleView('vendor.pagination.bootstrap-4');       

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
                
    }
}
