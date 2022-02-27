<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Utils\CLog;
use App\Utils\CError;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
	/**
	 * Create user in storage
	 * 
	 * @param mixed $input
	 * @return string token |App\Utils\CError;
	 */
	public function login($input)
	{
		CLog::info('login', debug_backtrace(), array('input' => $input));
		$rUser = User::where('email', $input['email'])->first();
		if (!$rUser) {
			return new CError(1400, 'email not exist');
		}

		if (!Hash::check($input['password'], $rUser->password)) {
			return new CError(1401, 'Password is invalid');
		}

		$rUser->generateToken();
		return $rUser;
	}
}
