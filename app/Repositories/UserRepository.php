<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
	public function getUser($userID)
	{
		$user = User::find($userID);
		return $user;
	}
}
