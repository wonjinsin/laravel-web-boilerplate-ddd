<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Repositories\UserRepository;
use App\Utils\CLog;
use App\Utils\CError;

class UserService
{
    /**
     * get user list in storage
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]|App\Utils\CError;
     */
    public function getUserList()
    {
        CLog::info('GetUserList', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__));
        return UserRepository::getUserList();
    }

    /**
     * Get user in storage
     *
     * @param int $uid
     * @return App\Models\User|App\Utils\CError;
     */
    public function getUser(int $uid)
    {
        CLog::info('GetUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);
        return UserRepository::getUser($uid);
    }

    /**
     * Update user in storage
     *
     * @param int   $uid
     * @param array $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function updateUser(int $uid, array $input)
    {
        CLog::info('UpdateUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid, 'input' => $input]);

        $rUser = $this->getUser($uid);
        if ($rUser instanceof CError) {
            CLog::warn('UserService getUser failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid, 'input' => $input]);
            return $rUser;
        }

        return UserRepository::updateUser($rUser, $input);
    }

    /**
     * Delete user in storage
     *
     * @param int $uid
     * @return App\Models\User|App\Utils\CError;
     */
    public function deleteUser(int $uid)
    {
        CLog::info('DeleteUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);

        $rUser = $this->getUser($uid);
        if ($rUser instanceof CError) {
            CLog::warn('UserService getUser failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);
            return $rUser;
        }

        return UserRepository::deleteUser($rUser);
    }
}
