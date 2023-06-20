<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();

        //should not force https, instead use other methods for https example
        //APP URL, ASSET URL, which will generate proper https urls
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Passport::hashClientSecrets();
    }
}
