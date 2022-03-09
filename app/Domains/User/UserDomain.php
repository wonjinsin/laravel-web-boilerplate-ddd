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
     * Update userDomain.
     *
     * @return void
     */
    public function updateUser(array $input)
    {
        if (isset($input['email']) && $this->isEmailUpdatable($input['email'])) {
            $this->setAttribute('email', $input['email']);
        }
        if (isset($input['password']) && $this->isPasswordUpdatable($input['password'])) {
            $this->setAttribute('password', $this->getHashedPassword($input['password']));
        }
    }

    /**
     * Check email is updatable.
     *
     * @param  string $email
     * @return bool
     */
    private function isEmailUpdatable(string $email): bool
    {
        return isset($email) && $this->getAttribute('email') !== $email;
    }

    /**
     * Check password is updatable.
     *
     * @param  string $email
     * @return bool
     */
    private function isPasswordUpdatable(string $password): bool
    {
        return isset($password) && $this->getAttribute('password') !== $this->getHashedPassword($password);
    }

    /**
     * Create getHashedPassword.
     *
     * @param  string $password
     * @return string
     */
    private function getHashedPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Check password correct.
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->getAttribute('password'));
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
