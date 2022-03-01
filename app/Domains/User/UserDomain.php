<?php

declare(strict_types=1);

namespace App\Domains\User;

use Illuminate\Support\Facades\Hash;

trait UserDomain
{
    /**
     * The user deleted_at
     *
     * @var int    id
     * @var string name
     * @var string password
     * @var string email
     * @var date   emailVerifiedAt
     * @var string rememberToken
     * @var date   createdAt
     * @var date   updatedAt
     * @var date   deletedAt
     * @var string token
     */
    protected $userEntity = [
        'id',
        'name',
        'password',
        'email',
        'emailVerifiedAt',
        'rememberToken',
        'createdAt',
        'updatedAt',
        'deletedAt',
        'token'
    ];

    /**
     * Update UserDomain.
     *
     * @return void
     */
    public function updateUser(array $input)
    {
        if ($this->isEmailUpdatable($input['email'])) {
            $this->setAttribute('email', $input['email']);
        }
        if ($this->isPasswordUpdatable($input['password'])) {
            $this->setAttribute('password', $this->hashedPassword($input['password']));
        }
    }

    /**
     * Check Email is updatable.
     *
     * @param string $email
     * @return bool
     */
    private function isEmailUpdatable(string $email): bool
    {
        return isset($email) && $this->getOriginal('email') !== $email;
    }

    /**
     * Check Password is updatable.
     *
     * @param string $email
     * @return bool
     */
    private function isPasswordUpdatable(string $password): bool
    {
        return isset($password) && $this->getOriginal('password') !== $this->hashedPassword($password);
    }

    /**
     * Create hashedPassword.
     *
     * @param string $password
     * @return bool
     */
    private function hashedPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Generate token.
     *
     * @return void
     */
    public function setToken()
    {
        $this->setAttribute('token', $this->createToken($this->getAttribute('email'))->plainTextToken);
    }
}
