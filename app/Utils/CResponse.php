<?php

declare(strict_types=1);

namespace App\Utils;

class CResponse
{
	public static function response($httpCode = 200, $msg = 'Error occured', $resultData = NULL)
	{
		return response()->json(
			array(
				'resultCode' => $httpCode < 1000 ? 1000 + $httpCode: $httpCode,
				'msg' => $msg,
				'resultData' => $resultData
			), $httpCode
		);
	}
}
