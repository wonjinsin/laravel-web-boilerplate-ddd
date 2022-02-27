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
     * Create user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Utils\CResponse
     */
    public function createUser(Request $request)
    {
        CLog::info('[New Request] createUser', debug_backtrace(), array('input' => $request->input()));
        
        $input = $request->input();
        $rUser = UserService::createUser($input);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'CreateUser OK', $rUser);
    }

    /**
     * Display the specified user list.
     *
     * @return \App\Utils\CResponse
     */
    public function getUserList()
    {
        CLog::info('[New Request] getUserList', debug_backtrace());

        $rUsers = new UserCollection(UserService::getUserList());
        if ($rUsers instanceof CError) {
            return CResponse::response($rUsers->getHttpCode(), $rUsers->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'GetuserList OK', $rUsers);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $userID
     * @return \App\Utils\CResponse
     */
    public function getUser($userID)
    {
        CLog::info('[New Request] getUser', debug_backtrace(), array('userID' => $userID));
        
        $rUser = UserService::getUser($userID);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'GetUser OK', new UserResource($rUser));
    }

    /**
     * Update user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userID
     * 
     * @return \App\Utils\CResponse
     */
    public function updateUser(Request $request, $userID)
    {
        CLog::info('[New Request] updateUser', debug_backtrace(), array('userID' => $userID, 'input' => $request->input()));
        
        $input = $request->input();
        $rUser = UserService::updateUser($userID, $input);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'UpdateUser OK', new UserResource($rUser));
    }

    /**
     * Remove user from storage.
     *
     * @param  int  $userID
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($userID)
    {
        CLog::info('[New Request] deleteUser', debug_backtrace(), array('userID' => $userID));
        $rUser = UserService::DeleteUser($userID);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'DeleteUser OK', new UserResource($rUser));
    }
}
