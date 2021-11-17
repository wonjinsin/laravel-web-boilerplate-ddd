<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utils\CLog;
use App\Domains\Logger\LogDomain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('clog', function () {
            return new CLog;
        });
    }
}
