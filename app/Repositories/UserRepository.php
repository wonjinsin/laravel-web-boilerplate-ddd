<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Exceptions\CustomException;
use App\Utils\CLOG;

class UserRepository
{
	public function createUser($input)
	{
		CLOG::info('CreateUser', debug_backtrace(), array('input' => $input));
		$rUser = new User();
		try {
			$rUser = User::create($input);
		} catch (Throwable $e) {
			CLOG::warn('CreateUser Failed. ' . $e->getMessage(), debug_backtrace(), array('input' => $input));
			return false;
		}

		return $rUser;
	}

	public function getUserList()
	{
		CLOG::info('getUserList', debug_backtrace());
		$rUsers = User::all()->where('id', '=', '21323');
		return $rUsers;
	}

	public function getUser($userID)
	{
		CLOG::info('updateUser', debug_backtrace(), array('userID' => $userID));
		$rUser = User::find($userID);
		return $rUser;
	}

	public function updateUser($rUser, $input)
	{
		CLOG::info('updateUser', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
		$rUser->updateUser($input);
		return $rUser->save();
	}

	public function deleteUser($rUser)
	{
		CLOG::info('deleteUser', debug_backtrace(), array('rUser' => $rUser));
		return $rUser->delete();
	}
}
