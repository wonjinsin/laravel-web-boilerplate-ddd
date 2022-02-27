<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('userService', function () {
      return new UserService;
    });
    $this->app->singleton('authService', function () {
      return new AuthService;
    });
  }
}
