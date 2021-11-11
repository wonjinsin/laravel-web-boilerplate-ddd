<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Utils\CLOG;
use App\Utils\CError;
use App\Exceptions\GeneralException;

class UserService
{
	public function createUser($input)
	{
		CLOG::info('createUser', debug_backtrace(), array('input' => $input));
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
		CLOG::info('getUser', debug_backtrace(), array('userID' => $userID));
		$userRepo = new UserRepository;

		return $userRepo->getUser($userID);
	}

	public function updateUser($userID, $input)
	{
		CLOG::info('UpdateUser', debug_backtrace(), array('userID' => $userID, 'input' => $input));
		$rUser = $this->getUser($userID);
		if (!$rUser) return false;

		$userRepo = new UserRepository;
		return $userRepo->updateUser($rUser, $input);
	}

	public function deleteUser($userID)
	{
		CLOG::info('deleteUser', debug_backtrace(), array('userID' => $userID));
		$rUser = $this->getUser($userID);
		$userRepo = new UserRepository;
		return $userRepo->deleteUser($rUser);
	}
}
