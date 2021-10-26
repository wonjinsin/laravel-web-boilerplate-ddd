<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
	public function getUser($userID) {
		$userRepo = new UserRepository;
		return $userRepo->getUser($userID);
	}
}
