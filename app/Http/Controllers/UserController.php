<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Utils\CLOG;

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
		CLOG::info('[New Request]', debug_backtrace(), array('input' => $request->input()));
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
		CLOG::info('[New Request]', debug_backtrace());
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
		CLOG::info('[New Request]', debug_backtrace(), array('userID' => $userID));
        $userService = new UserService;
        $data['resultData'] = new UserResource($userService->getUser($userID));

        return $data;
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
		CLOG::info('[New Request]', debug_backtrace(), array('userID' => $userID, 'input' => $request->input()));
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
		CLOG::info('[New Request]', debug_backtrace(), array('userID' => $userID));
        $userService = new UserService;
        $data['resultData'] = $userService->DeleteUser($userID);

        return $data;
    }
}