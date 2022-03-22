<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use App\Domains\Logger\LogDomain;
use Illuminate\Support\Facades\Config;
use Throwable;

class CLog
{
    /**
     * Get formatted string.
     *
     * @param  App\Domains\Logger\LogDomain $ld
     * @return string
     */
    private static function getFormattedString(LogDomain $ld)
    {
        $str = sprintf('{"trid": "%d", ', Config::get('constants.TRID'));
        $str .= $ld->getTrace('method') ? sprintf('"method": "%s", ', $ld->getTrace('method')) : '';
        $str .= $ld->getTrace('uri') ? sprintf('"uri": "%s", ', $ld->getTrace('uri')) : '';
        $str .= $ld->getTrace('status') ? sprintf('"status": "%d", ', $ld->getTrace('status')) : '';
        $str .= $ld->getTrace('remoteIP') ? sprintf('"remote_ip": "%s", ', $ld->getTrace('remoteIP')) : '';
        $str .= $ld->getMsg() ? sprintf('"msg": "%s", ', $ld->getMsg()) : '';
        $str .= $ld->getInfo() ? sprintf('"params": "%s", ', json_encode($ld->getInfo())) : '';
        $str .= $ld->getTrace('latency') ? sprintf('"latency": "%d", ', $ld->getTrace('latency')) : '';
        $str .= $ld->getTrace('function') ? sprintf('"caller": "%s(%s:%d)"', $ld->getTrace('function'), $ld->getCurrentFile(), $ld->getTrace('line')) : '';
        $str .= $ld->getTrace('resultData') ? sprintf('"resultData": "%s"', json_encode($ld->getTrace('resultData'))) : '';
        $str .= sprintf('}');

        return $str;
    }

    /**
     * Get error string.
     *
     * @param  App\Domains\Logger\LogDomain $ld
     * @return string
     */
    private static function getErrorString(LogDomain $ld)
    {
        $str = sprintf('{"trid": "%d", ', Config::get('constants.TRID'));
        $str .= $ld->getMsg() ? sprintf('"msg": "%s", ', $ld->getMsg()) : '';
        $str .= $ld->getInfo() ? sprintf('"params": "%s", ', json_encode($ld->getInfo())) : '';
        $str .= sprintf('}');

        return $str;
    }

    /**
     * Logging info.
     *
     * @param  string $msg
     * @param  array  $trace
     * @param  array  $info
     * @return void
     */
    public static function info(string $msg = '', array $trace = [], array $info = [])
    {
        Log::channel('stderr')->info(self::getFormattedString(new LogDomain($msg, $trace, $info)));
    }

    /**
     * Logging warn.
     *
     * @param  string $msg
     * @param  array  $trace
     * @param  array  $info
     * @return void
     */
    public static function warn(string $msg = '', array $trace = [], array $info = [])
    {
        return Log::channel('stderr')->warning(self::getFormattedString(new LogDomain($msg, $trace, $info)));
    }

    /**
     * Logging error.
     *
     * @param  string $msg
     * @param  array  $trace
     * @param  array  $info
     * @return void
     */
    public static function error(string $msg = '', array $trace = [], array $info = [])
    {
        if (isset($info['error']) && $info['error'] instanceof Throwable) {
            return Log::channel('stderr')->error(self::getErrorString(new LogDomain($msg, $trace, $info)));
        }
        return Log::channel('stderr')->error(self::getFormattedString(new LogDomain($msg, $trace, $info)));
    }

    /**
     * Get trace.
     *
     * @param  string $function
     * @param  string $file
     * @param  int    $line
     * @return array
     */
    public static function getTrace(string $function = '', string $file = '', int $line = 0): array
    {
        $arr['function'] = $function;
        $arr['file'] = $file;
        $arr['line'] = $line;
        return $arr;
    }

    /**
     * Get trace at Request.
     *
     * @param  string $function
     * @param  string $file
     * @param  int    $line
     * @return array
     */
    public static function getReqTrace(string $function = '', string $file = '', int $line = 0): array
    {
        $arr = self::getTrace($function, $file, $line);
        $arr['remoteIP'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $arr['uri'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        return $arr;
    }

    /**
     * Get trace at Result.
     *
     * @param  int        $code
     * @param  int        $code
     * @param  NULL|array $resultData
     * @return array
     */
    public static function getResultTrace(int $code = 0, int $httpCode = 0, $resultData): array
    {
        $arr['code'] = $code;
        $arr['status'] = $httpCode;
        if ($resultData) {
            $arr['resultData'] = $resultData;
        }
        return $arr;
    }
}
