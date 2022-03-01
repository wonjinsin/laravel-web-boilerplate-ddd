<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Utils\CLog;
use App\Utils\CError;

class UserRepository
{
    /**
     * get user list in storage
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]|App\Utils\CError;
     */
    public function getUserList()
    {
        CLog::info('GetUserList', debug_backtrace());
        $rUsers = User::all();
        return $rUsers;
    }

    /**
     * Get user in storage
     *
     * @param int $uid
     * @return App\Models\User|App\Utils\CError;
     */
    public function getUser($uid)
    {
        CLog::info('GetUser', debug_backtrace(), ['uid' => $uid]);
        $rUser = User::find($uid);

        if (!$rUser) {
            CLog::warn('GetUser failed', debug_backtrace(), ['uid' => $uid]);
            return new CError(1404, 'User is not exist');
        }

        return $rUser;
    }

    /**
     * Update user in storage
     *
     * @param App\Models\User $rUser
     * @param mixed           $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function updateUser($rUser, $input)
    {
        CLog::info('UpdateUser', debug_backtrace(), ['rUser' => $rUser, 'input' => $input]);
        $rUser->updateUser($input);
        $result = $rUser->save();

        if (!$result) {
            CLog::warn('UpdateUser save failed', debug_backtrace(), ['rUser' => $rUser, 'input' => $input]);
            return new CError(1402, 'UpdateUser save failed');
        }
        return $rUser;
    }

    /**
     * Update user in storage
     *
     * @param App\Models\User $rUser
     * @param mixed           $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function deleteUser($rUser)
    {
        CLog::info('DeleteUser', debug_backtrace(), ['rUser' => $rUser]);

        $result = $rUser->delete();
        if (!$result) {
            CLog::warn('DeleteUser failed', debug_backtrace(), ['rUser' => $rUser]);
            return new CError(1402, 'UpdateUser save failed');
        }

        return $rUser;
    }
}
