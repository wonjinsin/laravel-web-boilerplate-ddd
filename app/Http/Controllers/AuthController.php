<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Utils\CLog;
use App\Utils\CError;
use App\Utils\CResponse;
use Illuminate\Support\Facades\Config;
use App\Facades\Services\AuthService;

class AuthController extends Controller
{
    /**
     * Signup in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Utils\CResponse
     */
    public function signup(Request $request)
    {
        CLog::info('[New Request] signup', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $request->input()]);

        $input = $request->input();
        $rUser = AuthService::signup($input);
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'Signup OK', $rUser);
    }

    /**
     * login user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Utils\CResponse
     */
    public function login(Request $request)
    {
        CLog::info('[New Request] login', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $request->input()]);

        $rUser = AuthService::login($request->input());
        if ($rUser instanceof CError) {
            return CResponse::response($rUser->getHttpCode(), $rUser->getMsg());
        }

        return CResponse::response(Config::get('constants.httpCode.OK'), 'login OK', new UserResource($rUser));
    }
}
