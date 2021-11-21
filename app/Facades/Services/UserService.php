<?php

namespace App\Facades\Services;

use Illuminate\Support\Facades\Facade;

class UserService extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'userservice';
	}
}
