<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Utils\CLOG;

class UserService
{
	public function createUser($input)
	{
		CLOG::Info('createUser', debug_backtrace(), array('input' => $input));
		$userRepo = new UserRepository;
		return $userRepo->createUser($input);
	}

	public function getUserList()
	{
		$userRepo = new UserRepository;
		return $userRepo->getUserList();
	}

	public function getUser($userID)
	{
		CLOG::Info('getUser', debug_backtrace(), array('userID' => $userID));

		$userRepo = new UserRepository;
		return $userRepo->getUser($userID);
	}

	public function updateUser($userID, $input)
	{
		CLOG::Info('UpdateUser', debug_backtrace(), array('userID' => $userID, 'input' => $input));

		$rUser = $this->getUser($userID);
		if (!$rUser) return false;

		$userRepo = new UserRepository;
		return $userRepo->updateUser($rUser, $input);
	}

	public function deleteUser($userID)
	{
		CLOG::Info('deleteUser', debug_backtrace(), array('userID' => $userID));

		$rUser = $this->getUser($userID);
		$userRepo = new UserRepository;
		return $userRepo->deleteUser($rUser);
	}
}
