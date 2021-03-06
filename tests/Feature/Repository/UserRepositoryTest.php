<?php

namespace Tests\Feature;

use App\Facades\Repositories\AuthRepository;
use App\Facades\Repositories\UserRepository;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * make user.
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
        $rUser = UserRepository::getUser($user->id);
        $this->assertEquals($rUser['id'], $user['id']);
    }

    /**
     * Test update user.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = $this->makeUser();
        $input = ['email' => $this->faker()->unique()->safeEmail()];
        $user = UserRepository::updateUser($user, $input);

        $this->assertEquals($input['email'], $user['email']);
    }

    /**
     * Test delete user.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = $this->makeUser();
        $user = UserRepository::deleteUser($user);

        $rUser = UserRepository::getUser($user->id);
        $this->assertNotEquals($rUser, $user);
        $this->assertInstanceOf(\App\Utils\CError::class, $rUser);
    }
}
