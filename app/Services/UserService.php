<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Repositories\UserRepository;
use App\Utils\CLog;
use App\Utils\CError;

class UserService
{
	/**
	 * Create user in storage
	 * 
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function createUser($input)
	{
		CLog::info('createUser', debug_backtrace(), array('input' => $input));
		return UserRepository::createUser($input);
	}

	/**
	 * get user list in storage
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection|static[]|App\Utils\CError;
	 */
	public function getUserList()
	{
		return UserRepository::getUserList();
	}

	/**
	 * Get user in storage
	 * 
	 * @param int $userID
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function getUser($userID)
	{
		CLog::info('getUser', debug_backtrace(), array('userID' => $userID));
		return UserRepository::getUser($userID);
	}

	/**
	 * Update user in storage
	 * 
	 * @param int $userID
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function updateUser($userID, $input)
	{
		$rUser = $this->getUser($userID);

		if ($rUser instanceof CError) {
			CLog::warn('UserService getUser failed', debug_backtrace(), array('userID' => $userID, 'input' => $input));
			return $rUser;
		}

		return UserRepository::updateUser($rUser, $input);
	}

	/**
	 * Delete user in storage
	 * 
	 * @param int $userID
	 * @return App\Models\User|App\Utils\CError;
	 */
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
