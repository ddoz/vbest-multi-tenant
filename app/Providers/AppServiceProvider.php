<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(Environment::class, function ($app) {
        //     return $app[Environment::class]->hostname($app[HostnameRepository::class]->findByHostname(request()->getHost()));
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

    }
}
