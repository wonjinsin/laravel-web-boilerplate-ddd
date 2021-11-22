<?php

declare(strict_types=1);

namespace App\Utils;

class CError
{
	/**
	 * @var CError
	 */
	private static $cerror;

	/**
	 * @var \Lukasoppermann\Httpstatus\Httpstatus;
	 */
	private static $httpPackage;

	/**
	 * @var int
	 */
	private static $httpCode;

	/**
	 * @var string
	 */
	private static $msg;

	/**
	 * Get instance.
	 * 
	 * @return CError
	 */
	public static function getInstance()
	{
		if (!isset(CError::$cerror)) CError::$cerror = new CError('');
		return CError::$cerror;
	}

	/**
	 * Set Error.
	 * 
	 * @param string $httpMsg
	 * @param string $msg
	 * @return CError
	 */
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

	/**
	 * Get HttpCode.
	 * 
	 * @return int
	 */
	public static function getHttpCode()
	{
		return isset(self::$httpCode) ? self::$httpCode: 200;
	}

	/**
	 * Get message.
	 * 
	 * @return string
	 */
	public static function getMsg()
	{
		return isset(self::$msg) ? self::$msg: 'Request Success';
	}
}
