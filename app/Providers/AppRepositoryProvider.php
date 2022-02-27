<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\AuthRepository;

class AppRepositoryProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('userRepository', function () {
			return new UserRepository;
		});
		$this->app->singleton('authRepository', function () {
			return new AuthRepository;
		});
	}
}
