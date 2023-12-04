<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }
    // Variabili per tutte le pagine
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        view()->composer('app', function ($view) {
            $websiteTitle = 'Mirko Spino MyCity Test';
            $view->with('websiteTitle', $websiteTitle);
        });
        view()->composer('*', function ($view) {
            $bsClassFormLabels = 'col-md-4 col-form-label text-md-end text-start';
            $bsClassButtons = 'btn btn-primary btn-sm my-2';
            $view->with('bsClassFormLabels', $bsClassFormLabels);
            $view->with('bsClassButtons', $bsClassButtons);
        });
    }
}
