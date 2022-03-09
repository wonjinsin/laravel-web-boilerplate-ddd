<?php

namespace Tests\Unit\Domain;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class UserDomainTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test update user.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = new User();
        $user->setAttribute('email', 'test@example.com');
        $user->setAttribute('password', 'votmdnjem');

        $input = [
            'email' => 'test2@example.com',
            'password' => 'votmdnjem123'
        ];

        $user->updateUser($input);

        $this->assertEquals($input['email'], $user->email);
        $this->assertTrue($user->checkPassword($input['password']));
    }

    /**
     * Test check password.
     *
     * @return void
     */
    public function testCheckPassword()
    {
        $user = new User();

        $input = [
            'password' => 'votmdnjem'
        ];

        $user->updateUser($input);
        $this->assertTrue($user->checkPassword('votmdnjem'));
    }

    /**
     * Test set token.
     *
     * @return void
     */
    public function testSetToken()
    {
        $user = new User();
        $user->setAttribute('id', 1);

        $input = [
            'email' => 'test.example.com'
        ];

        $user->updateUser($input);
        $user->setToken($input['email']);
        $preg = preg_match('/[0-9]+\|[a-zA-Z0-9]+$/', $user->token);
        $this->assertTrue(boolval($preg));
    }
}
