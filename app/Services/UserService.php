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
        CLog::info('getUserList', debug_backtrace());
        return UserRepository::getUserList();
    }

    /**
     * Get user in storage
     *
     * @param int $uid
     * @return App\Models\User|App\Utils\CError;
     */
    public function getUser($uid)
    {
        CLog::info('getUser', debug_backtrace(), ['uid' => $uid]);
        return UserRepository::getUser($uid);
    }

    /**
     * Update user in storage
     *
     * @param int   $uid
     * @param mixed $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function updateUser($uid, $input)
    {
        $rUser = $this->getUser($uid);

        if ($rUser instanceof CError) {
            CLog::warn('UserService getUser failed', debug_backtrace(), ['uid' => $uid, 'input' => $input]);
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
    public function deleteUser($uid)
    {
        CLog::info('deleteUser', debug_backtrace(), ['uid' => $uid]);

        $rUser = $this->getUser($uid);
        if ($rUser instanceof CError) {
            CLog::warn('UserService getUser failed', debug_backtrace(), ['uid' => $uid]);
            return $rUser;
        }

        return UserRepository::deleteUser($rUser);
    }
}
