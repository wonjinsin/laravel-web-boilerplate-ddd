<?php

declare(strict_types=1);

namespace App\Utils;

class CResponse
{
	public static function response($httpCode = 200, $msg = 'Error occured', $resultData = array())
	{
		return response()->json(
			array(
				'resultCode' => $httpCode,
				'msg' => $msg,
				'resultData' => $resultData
			), $httpCode
		);
	}
}
