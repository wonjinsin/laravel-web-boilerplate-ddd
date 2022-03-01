<?php

declare(strict_types=1);

namespace App\Utils;

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
    public static function response($httpCode = 200, $msg = 'Error occured', $resultData = null)
    {
        $array = ['resultCode' => $httpCode, 'msg' => $msg];
        if ($resultData) {
            $array['resultData'] = $resultData;
        }

        return response()->json(
            $array,
            self::getResponseCode($httpCode)
        );
    }

    private static function getResponseCode(int $httpCode): int
    {
        $httpPackage = new \Lukasoppermann\Httpstatus\HttpStatus();
        if ($httpPackage->hasStatusCode($httpCode)) {
            return $httpCode;
        }

        $httpCode -= 1000;
        if ($httpCode > 0 && $httpPackage->hasStatusCode($httpCode)) {
            return $httpCode;
        }
        return 500;
    }
}
