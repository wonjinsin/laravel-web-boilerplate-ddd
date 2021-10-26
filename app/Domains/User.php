<?php

declare(strict_types=1);

namespace App\Domains;

class UserDomain
{

	/**	
	 * The user pk
	 *  
	 * @var int 
	 */
	private $id;

	/**	
	 * The user name
	 * 
	 * @var string 
	 */
	private $name;

	/** 
	 * The user email
	 * 
	 * @var string	 
	 */
	private $email;

	/** 
	 * The user email_verified_at
	 * 
	 * @var date
	 */
	private $emailVerifiedAt;

	/** 
	 * The user password
	 * 
	 * @var string
	 */
	private $password;

	/**
	 * The user rememberToken
	 * 
	 * @var string 100
	 */
	private $rememberToken;

	/**
	 * The user created_at
	 * 
	 * @var date
	 */
	private $createdAt;

	/**
	 * The user deleted_at
	 * 
	 * @var date
	 */
	private $updatedAt;

	/**
	 * Set userinfo
	 * 
	 * @return bool
	 */

	public function setUser(array $input): bool
	{
		if (!$this->validateBind($input)) return false;

		$this->id = $input['id'] ? $input['id'] : NULL;
		$this->name = $input['name'] ? $input['name'] : NULL;
		$this->email = $input['email'] ? $input['email'] : NULL;
		$this->emailVerifiedAt = $input['emailVerifiedAt'] ? $input['emailVerifiedAt'] : NULL;
		$this->password = $input['password'] ? $input['password'] : NULL;
		$this->rememberToken = $input['rememberToken'] ? $input['rememberToken'] : NULL;
		$this->createdAt = $input['createAt'] ? $input['createAt'] : NULL;
		$this->updatedAt = $input['updatedAt'] ? $input['updatedAt'] : NULL;

		return true;
	}

	/**
	 * Get user all info
	 * 
	 * @return array
	 */
	public function getUser(): array{
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'emailVerifiedAt' => $this->emailVerifiedAt,
			'password' => $this->password,
			'rememberToken' => $this->rememberToken,
			'createdAt' => $this->createdAt,
			'updatedAt' => $this->updatedAt,
		);
	}

	/**
	 * Validate userbind
	 * 
	 * @return bool
	 */
	private function validateBind(array $input): bool
	{
		return !$input['id'];
	}

	/**
	 * Create user info for repository
	 * 
	 * @return array
	 */
	public function createUserForRepo(): array{
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'email_verified_at' => $this->emailVerifiedAt,
			'password' => $this->password,
			'remember_token' => $this->rememberToken,
			'created_at' => $this->createdAt,
			'updated_at' => $this->updatedAt,
		);
	}

}
