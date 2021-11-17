<?php

declare(strict_types=1);

namespace App\Utils;

class CError {
	private $httpStatus;

	static $httpCode;
	static $httpMsg;
	static $msg;

	function __construct(){
	}

	public static function set($httpMsg, $msg) {
		self::$httpMsg = $httpMsg;
		self::$msg = $msg;
	}

	public static function get() {
		return self::$msg;
	}
}