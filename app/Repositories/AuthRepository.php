<?php

declare(strict_types=1);

namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\Utils\CLog;
use App\Utils\CError;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    /**
     * Signup user
     *
     * @param  mixed  $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function signup($input)
    {
        CLog::info('Signup', debug_backtrace(), ['input' => $input]);
        try {
            $input['password'] = Hash::make($input['password']);
            $rUser = User::create($input);
        } catch (Throwable $e) {
            CLog::warn('Signup Failed. ' . $e->getMessage(), debug_backtrace(), ['input' => $input]);
            return new CError(1402, 'CreateUser failed');
        }

        return $rUser;
    }

    /**
     * Login user
     *
     * @param mixed $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function login($input)
    {
        CLog::info('Login', debug_backtrace(), ['input' => $input]);
        $rUser = User::where('email', $input['email'])->first();
        if (!$rUser) {
            return new CError(1400, 'Email not exist');
        }

        if (!Hash::check($input['password'], $rUser->password)) {
            return new CError(1401, 'Password is invalid');
        }

        $rUser->generateToken();
        return $rUser;
    }
}
