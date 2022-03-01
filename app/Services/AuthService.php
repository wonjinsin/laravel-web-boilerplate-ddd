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
		CLog::info('Signup', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
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
		CLog::info('Login', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
		$rUser = AuthRepository::login($input);

		if ($rUser instanceof CError) {
			CLog::warn('AuthService login failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
			return $rUser;
		}
		return $rUser;
	}
}
