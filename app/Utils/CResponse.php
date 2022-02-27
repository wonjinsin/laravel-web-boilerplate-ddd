<?php

declare(strict_types=1);

namespace App\Utils;

class CResponse
{
	/**
	 * Response json
	 * 
	 * @param int $httpCode
	 * @param string $msg
	 * @param NULL|array $resultData
	 * 
     * @return \Illuminate\Http\JsonResponse
	 */
	public static function response($httpCode = 200, $msg = 'Error occured', $resultData = NULL)
	{
		return response()->json(
			array(
				'resultCode' => $httpCode,
				'msg' => $msg,
				'resultData' => $resultData
			), $httpCode
		);
	}

	public static function getStatus(int $httpCode): int{
		$httpPackage = new \Lukasoppermann\Httpstatus\HttpStatus();
		if ($httpPackage->hasStatusCode($httpCode)) {
			return $httpCode;
		}
		return 500;
	}
}
