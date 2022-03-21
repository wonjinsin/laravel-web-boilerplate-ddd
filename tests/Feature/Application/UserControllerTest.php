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
     * Test get user list.
     *
     * @return void
     */
    public function testGetUserList()
    {
        $user = $this->makeUser();
        $response = $this->get('/api/v1/user');
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
        $response = $this->get(sprintf('/api/v1/user/%s', $user->uid));
        $response->assertOk();
    }
}
