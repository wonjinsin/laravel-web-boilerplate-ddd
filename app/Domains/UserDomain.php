<?php

declare(strict_types=1);

namespace App\Domains;

use Illuminate\Support\Str;

trait UserDomain
{
	/**
	 * The user deleted_at
	 * 
	 * @var int id
	 * @var string name 
	 * @var string password
	 * @var string email
	 * @var date emailVerifiedAt
	 * @var string rememberToken
	 * @var date createdAt
	 * @var date updatedAt
	 * @var date deletedAt
	 */
	protected $DefaultEntity = [
		'id',
		'name',
		'password',
		'email',
		'emailVerifiedAt',
		'rememberToken',
		'createdAt',
		'updatedAt',
		'deletedAt',
	];

	public function updateUser($input)
	{
		if (isset($input['email']) && $this->getOriginal('email') !== $input['email']) {
			$this->setAttribute('email', $input['email']);
		}
		if (isset($input['password']) && $this->getOriginal('password') !== $input['password']) {
			$this->setAttribute('password', $input['password']);
		}
	}
}
