<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Facades\CLog;
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
			return false;
		}

		return $rUser;
	}

	public function getUserList()
	{
		CLog::info('getUserList', debug_backtrace());
		$rUsers = User::all()->where('id', '=', '21323');
		return $rUsers;
	}

	public function getUser($userID)
	{
		CLog::info('updateUser', debug_backtrace(), array('userID' => $userID));
		$rUser = User::find($userID);
		// $rUser2 = User::check123();

		// var_dump($rUser2::check123());

		return $rUser;
	}

	public function updateUser($rUser, $input)
	{
		CLog::info('updateUser', debug_backtrace(), array('rUser' => $rUser, 'input' => $input));
		$rUser->updateUser($input);
		return $rUser->save();
	}

	public function deleteUser($rUser)
	{
		CLog::info('deleteUser', debug_backtrace(), array('rUser' => $rUser));
		return $rUser->delete();
	}
}
