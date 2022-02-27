<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Repositories\AuthRepository;
use App\Utils\CLog;
use App\Utils\CError;

class AuthService
{
	/**
	 * login user.
	 * 
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function login($input)
	{
		CLog::info('login', debug_backtrace(), array('input' => $input));
		$rUser = AuthRepository::login($input);

		if ($rUser instanceof CError) {
			CLog::warn('AuthService login failed', debug_backtrace(), array('input' => $input));
			return $rUser;
		}
		return $rUser;
	}
}
