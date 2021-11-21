<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Utils\CLog;
use App\Utils\CError;

class UserRepository
{
	public function createUser($input)
	{
		CLog::info('CreateUser', debug_backtrace(), array('input' => $input));
		$rUser = new User();
		try {
			$rUser = User::create($input);
		} catch (Throwable $e) {
			CLog::warn('CreateUser Failed. ' . $e->getMessage(), debug_backtrace(), array('input' => $input));
			return CError::set('Bad Request', 'CreateUser failed');
		}

		return $rUser;
	}

	public function getUserList()
	{
		CLog::info('GetUserList', debug_backtrace());
		$rUsers = User::all();
		return $rUsers;
	}

	public function getUser($userID)
	{
		CLog::info('GetUser', debug_backtrace(), array('userID' => $userID));
		$rUser = User::find($userID);

		if (!$rUser) {
			CLog::warn('GetUser failed', debug_backtrace(), array('userID' => $userID));
			return CError::set('Not Found', 'User is not exist');
		}

		return $rUser;
	}

	public function updateUser($rUser, $input)
	{
		CLog::info('UpdateUser', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
		$rUser->updateUser($input);
		$result = $rUser->save();

		if (!$result) {
			CLog::warn('UpdateUser save failed', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
			return CError::set('Bad Request', 'UpdateUser save failed');
		}

		return $rUser;
	}

	public function deleteUser($rUser)
	{
		CLog::info('DeleteUser', debug_backtrace(), array('rUser' => $rUser));

		$result = $rUser->delete();
		if (!$result) {
			CLog::warn('DeleteUser failed', debug_backtrace(), array('rUser' => $rUser));
			return CError::set('Bad Request', 'UpdateUser save failed');
		}

		return $rUser;
	}
}
