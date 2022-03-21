<?php

namespace Tests\Feature;

use App\Facades\Repositories\AuthRepository;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthRepositoryTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * Test signup user.
     *
     * @return App\Models\User|App\Utils\CError;
     */
    public function testSignUp()
    {
        $user = (new UserFactory())->definition();
        $rUser = AuthRepository::signup($user);

        $this->assertEquals($rUser['email'], $user['email']);
    }

    /**
     * Test login.
     *
     * @return App\Models\User|App\Utils\CError;
     */
    public function testLogin()
    {
        $user = (new UserFactory())->definition();
        AuthRepository::signup($user);

        $input['email'] = $user['email'];
        $input['password'] = $user['password'];

        $loggedInUser = AuthRepository::login($input);
        $this->assertInstanceOf(\App\Models\User::class, $loggedInUser);
        $this->assertIsString($loggedInUser->token);
    }
}
