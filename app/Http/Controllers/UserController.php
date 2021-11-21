<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Facades\CLog;
use App\Utils\CError;
use App\Utils\CResponse;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        CLog::info('[New Request]', debug_backtrace(), array('input' => $request->input()));
        $input = $request->input();
        $userService = new UserService;
        $data['resultData'] = $userService->createUser($input);

        return $data;
    }

    /**
     * Display the specified user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserList()
    {
        CLog::info('[New Request]', debug_backtrace());
        $userService = new UserService;

        $data['resultData'] = new UserCollection($userService->getUserList());

        return $data;
    }

    /**
     * Display the specified user.
     *
     * @param  int  $userID
     * @return \Illuminate\Http\Response
     */
    public function getUser($userID)
    {
        CLog::info('[New Request]', debug_backtrace(), array('userID' => $userID));
        $userService = new UserService;
        $user = $userService->getUser($userID);
        
        return CResponse::response(Config::get('constants.httpCode.httpOK'), 'success', new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userID
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $userID)
    {
        CLog::info('[New Request]', debug_backtrace(), array('userID' => $userID, 'input' => $request->input()));
        $input = $request->input();
        $userService = new UserService;

        $user = $userService->updateUser($userID, $input);
        $data['resultData'] = $user;

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userID
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($userID)
    {
        CLog::info('[New Request]', debug_backtrace(), array('userID' => $userID));
        $userService = new UserService;
        $data['resultData'] = $userService->DeleteUser($userID);

        return $data;
    }
}
