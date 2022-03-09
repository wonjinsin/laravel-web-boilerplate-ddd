<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Facades\Repositories\AuthRepository;
use App\Facades\Repositories\UserRepository;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Utils\CError;

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
        $this->assertEquals($user['id'], $rUser['id']);
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
     * Delete user.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = $this->makeUser();
        $user = UserRepository::deleteUser($user);

        $rUser = UserRepository::getUser($user->id);
        $this->assertNotEquals($user, $rUser);
        $this->assertInstanceOf(CError::class, $rUser);
    }
}
