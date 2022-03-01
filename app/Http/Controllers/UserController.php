<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Utils\CLog;
use App\Utils\CError;
use App\Utils\CResponse;
use Illuminate\Support\Facades\Config;
use App\Facades\Services\UserService;

class UserController extends Controller
{
    /**
     * Display the specified user list.
     *
     * @return \App\Utils\CResponse
     */
    public function getUserList()
    {
        CLog::info('[New Request] getUserList', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__));

        $rUsers = new UserCollection(UserService::getUserList());
        if ($rUsers instanceof CError) {
            return CResponse::response($rUsers->getHttpCode(), $rUsers->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'GetuserList OK', $rUsers);
    }

    /**
     * Display the specified user.
     *
     * @param  int                  $uid
     * @return \App\Utils\CResponse
     */
    public function getUser(int $uid)
    {
        CLog::info('[New Request] getUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);

        $rUser = UserService::getUser($uid);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'GetUser OK', new UserResource($rUser));
    }

    /**
     * Update user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $uid
     * @return \App\Utils\CResponse
     */
    public function updateUser(Request $request, int $uid)
    {
        $input = $request->input();
        CLog::info('[New Request] updateUser', CLog::getReqTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid, 'input' => $input]);
        if ($request->user()->id !== $uid) {
            $error = new CError(1401, 'User is invalid');
            return CResponse::response($error->getHttpCode(), $error->getMsg());
        };

        $rUser = UserService::updateUser($uid, $input);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'UpdateUser OK', new UserResource($rUser));
    }

    /**
     * Remove user from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $uid
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request, int $uid)
    {
        CLog::info('[New Request] deleteUser', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['uid' => $uid]);

        if ($request->user()->id !== $uid) {
            $error = new CError(1401, 'User is invalid');
            return CResponse::response($error->getHttpCode(), $error->getMsg());
        };

        $rUser = UserService::DeleteUser($uid);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'DeleteUser OK', new UserResource($rUser));
    }
}
