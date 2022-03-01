<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Repositories\AuthRepository;
use App\Utils\CLog;
use App\Utils\CError;

class AuthService
{
	/**
	 * Signup user
	 * 
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function signup($input)
	{
		CLog::info('Signup', debug_backtrace(), ['input' => $input]);
		return AuthRepository::signup($input);
	}

	/**
	 * Login user.
	 * 
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function login($input)
	{
		CLog::info('Login', debug_backtrace(), ['input' => $input]);
		$rUser = AuthRepository::login($input);

		if ($rUser instanceof CError) {
			CLog::warn('AuthService login failed', debug_backtrace(), ['input' => $input]);
			return $rUser;
		}
		return $rUser;
	}
}
