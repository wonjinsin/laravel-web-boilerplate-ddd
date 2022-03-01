<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Utils\CLog;
use App\Utils\CResponse;
use Illuminate\Support\Facades\Config;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            return CLog::error($this->makeErrorMsg($e), [], ['error' => $e]);
        })->stop();

        $this->renderable(function (Throwable $e) {
            return CResponse::response(Config::get('constants.httpCode.ServerError'), 'Internal Error Occurred. ' . $e->getMessage());
        });
    }

    private function makeErrorMsg(Throwable $e): string {
        return sprintf('msg: %s file: %s line: %s', $e->getMessage(), $e->getFile(), $e->getLine());
    }
}
