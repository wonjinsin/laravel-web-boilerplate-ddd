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
     * @param array $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function signup(array $input)
    {
        CLog::info('Signup', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
        try {
            $input['password'] = Hash::make($input['password']);
            $rUser = User::create($input);
        } catch (Throwable $e) {
            CLog::warn('Signup Failed. ' . $e->getMessage(), CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
            return new CError(1402, sprintf('CreateUser failed. %s', $e->getMessage()));
        }

        return $rUser;
    }

    /**
     * Login user
     *
     * @param array $input
     * @return App\Models\User|App\Utils\CError;
     */
    public function login(array $input)
    {
        CLog::info('Login', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
        $rUser = User::where('email', $input['email'])->first();
        if (!$rUser) {
            CLog::warn('User not exist', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
            return new CError(1400, 'Email not exist');
        }

        if (!$rUser->checkPassword($input['password'])) {
            CLog::warn('Password not matched', CLog::getTrace(__FUNCTION__, __FILE__, __LINE__), ['input' => $input]);
            return new CError(1401, 'Password is invalid');
        }

        $rUser->setToken();
        return $rUser;
    }
}
