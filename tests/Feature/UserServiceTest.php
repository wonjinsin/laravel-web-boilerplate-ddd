<?php

namespace Tests\Feature;

use App\Facades\Services\UserService;
use App\Facades\Repositories\AuthRepository;
use App\Utils\CError;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * Make user.
     *
     * @return App\Models\User|App\Utils\CError;
     */
    private function makeUser()
    {
        $user = (new UserFactory())->definition();
        return AuthRepository::signup($user);
    }

    /**
     * Test get user.
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = $this->makeUser();
        $rUser = UserService::getUser($user->id);
        $this->assertEquals($rUser['id'], $user['id']);
    }

    /**
     * Test update user.
     * 
     * @return void
     */
    public function testUpdateUser() {
        $user = $this->makeUser();
        $input = ['email' => $this->faker()->unique()->safeEmail()];
        $user = UserService::updateUser($user->id, $input);
        
        $this->assertEquals($input['email'], $user['email']);
    }

    /**
     * Test delete user.
     * 
     * @return void
     */
    public function testDeleteUser() {
        $user = $this->makeUser();
        $user = UserService::deleteUser($user->id);

        $rUser = UserService::getUser($user->id);
        $this->assertNotEquals($rUser, $user);
        $this->assertInstanceOf(CError::class, $rUser);
    }
}
