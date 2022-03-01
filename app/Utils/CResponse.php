<?php

declare(strict_types=1);

namespace App\Utils;

use App\Utils\CLog;

class CResponse
{
    /**
     * Response json
     *
     * @param int        $httpCode
     * @param string     $msg
     * @param NULL|array $resultData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response(int $code = 200, string $msg = 'Error occured', $resultData = null)
    {
        $array = ['trid' => TRID, 'resultCode' => $code, 'msg' => $msg];
        if ($resultData) {
            $array['resultData'] = $resultData;
        }
        
        CLog::info(sprintf('[Response] %s', $msg), CLog::getResultTrace($code, self::getHttpCode($code), $resultData));
        
        return response()->json(
            $array,
            self::getHttpCode($code)
        );
    }

    private static function getHttpCode(int $code): int
    {
        $httpPackage = new \Lukasoppermann\Httpstatus\HttpStatus();
        if ($httpPackage->hasStatusCode($code)) {
            return $code;
        }

        $code -= 1000;
        if ($code > 0 && $httpPackage->hasStatusCode($code)) {
            return $code;
        }
        return 500;
    }
}
