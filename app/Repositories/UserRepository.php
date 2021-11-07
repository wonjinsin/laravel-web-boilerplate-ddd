<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Exceptions\CustomException;

class UserRepository
{
	public function createUser($input)
	{
		$rUser = User::create($input);
		return $rUser;
	}

	public function getUserList()
	{
		$rUsers = User::all();
		return $rUsers;
	}

	public function getUser($userID)
	{
		$rUser = User::find($userID);
		return $rUser;
	}

	public function updateUser($rUser, $input)
	{
		throw new CustomException('test123');
		$rUser->updateUser($input);
		return $rUser->save();
	}

	public function deleteUser($rUser)
	{
		return $rUser->delete();
	}
}
