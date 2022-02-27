<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Utils\CLog;
use App\Utils\CError;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
	/**
	 * Create user in storage
	 * 
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function createUser($input)
	{
		CLog::info('CreateUser', debug_backtrace(), array('input' => $input));
		try {
			$input['password'] = Hash::make($input['password']);
			$rUser = User::create($input);
		} catch (Throwable $e) {
			CLog::warn('CreateUser Failed. ' . $e->getMessage(), debug_backtrace(), array('input' => $input));
			return new CError(402, 'CreateUser failed');
		}

		return $rUser;
	}
	
	/**
	 * get user list in storage
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection|static[]|App\Utils\CError;
	 */
	public function getUserList()
	{
		CLog::info('GetUserList', debug_backtrace());
		$rUsers = User::all();
		return $rUsers;
	}
	
	/**
	 * Get user in storage
	 * 
	 * @param int $userID
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function getUser($userID)
	{
		CLog::info('GetUser', debug_backtrace(), array('userID' => $userID));
		$rUser = User::find($userID);

		if (!$rUser) {
			CLog::warn('GetUser failed', debug_backtrace(), array('userID' => $userID));
			return new CError(404, 'User is not exist');
		}

		return $rUser;
	}

	/**
	 * Update user in storage
	 * 
	 * @param App\Models\User $rUser
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function updateUser($rUser, $input)
	{
		CLog::info('UpdateUser', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
		$rUser->updateUser($input);
		$result = $rUser->save();

		if (!$result) {
			CLog::warn('UpdateUser save failed', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
			return new CError(402, 'UpdateUser save failed');
		}

		return $rUser;
	}
	
	/**
	 * Update user in storage
	 * 
	 * @param App\Models\User $rUser
	 * @param mixed $input
	 * @return App\Models\User|App\Utils\CError;
	 */
	public function deleteUser($rUser)
	{
		CLog::info('DeleteUser', debug_backtrace(), array('rUser' => $rUser));

		$result = $rUser->delete();
		if (!$result) {
			CLog::warn('DeleteUser failed', debug_backtrace(), array('rUser' => $rUser));
			return new CError(402, 'UpdateUser save failed');
		}

		return $rUser;
	}
}
