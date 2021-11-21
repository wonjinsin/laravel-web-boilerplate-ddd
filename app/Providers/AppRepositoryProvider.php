<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;

class AppRepositoryProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('userrepository', function () {
			return new UserRepository;
		});
	}
}
