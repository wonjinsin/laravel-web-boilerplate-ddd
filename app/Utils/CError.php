<?php

declare(strict_types=1);

namespace App\Utils;

class CError
{
	private static $cerror;

	private static $httpPackage;
	private static $httpCode;
	private static $msg;

	public static function getInstance()
	{
		if (!isset(CError::$cerror)) CError::$cerror = new CError('');
		return CError::$cerror;
	}

	public static function set($httpMsg = 'Internal Server Error', $msg = 'Error occured')
	{
		self::$httpPackage = new \Lukasoppermann\Httpstatus\Httpstatus();
		if (self::$httpPackage->hasReasonPhrase(($httpMsg))) {
			self::$httpCode = self::$httpPackage->getStatusCode($httpMsg);
		} else {
			self::$httpCode = 500;
		}

		self::$msg = $msg;

		return self::getInstance();
	}

	public static function getHttpCode()
	{
		return isset(self::$httpCode) ? self::$httpCode: 200;
	}

	public static function getMsg()
	{
		return isset(self::$msg) ? self::$msg: 'Request success';
	}
}
