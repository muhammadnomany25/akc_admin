<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Maatwebsite\Excel\ExcelServiceProvider;

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
    public function boot(): void
    {
        Model::unguard();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']);
        });

        $locale = session('locale', 'ar'); // Default to English if no locale is set in the session
        App::setLocale($locale);

        if (class_exists(ExcelServiceProvider::class)) {
            $this->app->register(ExcelServiceProvider::class);
        }
//        Maatwebsite\Excel\ExcelServiceProvider::class
    }
}
