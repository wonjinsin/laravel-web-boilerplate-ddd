<?php

namespace Tests\Feature\Application;

use App\Facades\Repositories\AuthRepository;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    private $sanctum;

    /**
     * Make user.
     *
     * @return App\Models\User|App\Utils\CError;
     */
    private function makeUser()
    {
        $user = $this->getUserDefinition();
        return AuthRepository::signup($user);
    }

    /**
     * Get user definition
     *
     * @return array
     */
    private function getUserDefinition(): array
    {
        return (new UserFactory())->definition();
    }

    /**
     * Test get user list.
     *
     * @return void
     */
    public function testGetUserList()
    {
        $this->makeUser();
        $response = $this->get('/api/v1/user');
        $response->assertOk();
    }

    /**
     * Test signup.
     *
     * @return void
     */
    public function testSignUp()
    {
        $user = $this->getUserDefinition();
        $response = $this->postJSON(
            '/api/v1/auth/signup',
            [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password']
            ]
        );
        $response->assertOk();
    }

    /**
     * Test get user.
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = $this->makeUser();
        $response = $this->get(sprintf('/api/v1/user/%s', $user->id));
        $response->assertOk();
    }

    /**
     * Test update user.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = $this->makeUser();
        $loggedIn = $this->postJSON(
            '/api/v1/auth/login',
            [
                'email' => $user->email,
                'password' => $this->getUserDefinition()['password']
            ]
        );
        $loggedIn->assertOk();

        $token = $loggedIn['resultData']['token'];
        $response = $this->putJSON(sprintf('api/v1/user/%s', $user->id), ['name' => 'changed name'], ['Authorization' => sprintf('Bearer %s', $token)]);
        $response->assertStatus(200);
    }

    /**
     * Test delete user.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = $this->makeUser();
        $loggedIn = $this->postJSON(
            '/api/v1/auth/login',
            [
                'email' => $user->email, 
                'password' => $this->getUserDefinition()['password']
            ]
        );
        $loggedIn->assertOk();

        $token = $loggedIn['resultData']['token'];
        $response = $this->deleteJSON(sprintf('api/v1/user/%s', $user->id), ['name' => 'changed name'], ['Authorization' => sprintf('Bearer %s', $token)]);
        $response->assertStatus(200);
    }
}
