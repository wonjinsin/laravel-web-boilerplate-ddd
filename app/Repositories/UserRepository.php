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
        CLog::info('GetUserList', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__));
        $rUsers = User::all();
        return $rUsers;
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
        $rUser = User::find($uid);

        if (!$rUser) {
            CLog::warn('GetUser failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);
            return new CError(1404, 'User is not exist');
        }

        return $rUser;
    }

    /**
     * Update user in storage
     *
     * @param App\Models\User $rUser
     * @param array           $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function updateUser(\App\Models\User $rUser, array $input)
    {
        CLog::info('UpdateUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['rUser' => $rUser, 'input' => $input]);
        $rUser->updateUser($input);
        $result = $rUser->save();

        if (!$result) {
            CLog::warn('UpdateUser save failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['rUser' => $rUser, 'input' => $input]);
            return new CError(1402, 'UpdateUser save failed');
        }
        return $rUser;
    }

    /**
     * Update user in storage
     *
     * @param App\Models\User $rUser
     * @param array           $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function deleteUser(\App\Models\User $rUser)
    {
        CLog::info('DeleteUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['rUser' => $rUser]);

        $result = $rUser->delete();
        if (!$result) {
            CLog::warn('DeleteUser failed', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['rUser' => $rUser]);
            return new CError(1402, 'Delete failed');
        }

        return $rUser;
    }
}
