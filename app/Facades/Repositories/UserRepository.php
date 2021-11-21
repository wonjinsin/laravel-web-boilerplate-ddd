<?php

namespace App\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class UserRepository extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'userrepository';
	}
}
