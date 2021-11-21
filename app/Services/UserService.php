<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Repositories\UserRepository;
use App\Utils\CLog;
use App\Utils\CError;

class UserService
{
	public function createUser($input)
	{
		CLog::info('createUser', debug_backtrace(), array('input' => $input));
		return UserRepository::createUser($input);
	}

	public function getUserList()
	{
		return UserRepository::getUserList();
	}

	public function getUser($userID)
	{
		CLog::info('getUser', debug_backtrace(), array('userID' => $userID));
		return UserRepository::getUser($userID);
	}

	public function updateUser($userID, $input)
	{
		CLog::info('UpdateUser', debug_backtrace(), array('userID' => $userID, 'input' => $input));
		$rUser = $this->getUser($userID);

		if ($rUser instanceof CError) {
			CLog::warn('UserService getUser failed', debug_backtrace(), array('userID' => $userID, 'input' => $input));
			return $rUser;
		}

		return UserRepository::updateUser($rUser, $input);
	}

	public function deleteUser($userID)
	{
		CLog::info('deleteUser', debug_backtrace(), array('userID' => $userID));

		$rUser = $this->getUser($userID);
		if ($rUser instanceof CError) {
			CLog::warn('UserService getUser failed', debug_backtrace(), array('userID' => $userID));
			return $rUser;
		}

		return UserRepository::deleteUser($rUser);
	}
}
