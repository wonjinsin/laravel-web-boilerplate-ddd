<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('userservice', function () {
			return new UserService;
		});
    }
}
